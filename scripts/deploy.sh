#!/usr/bin/env bash
# ==============================================================================
# deploy.sh — ONE-CLICK Automated Deployment Pipeline
#             for My Coder WebApp (Multi-Model AI Orchestrator)
#
# Usage:  bash scripts/deploy.sh
#         (run from the repository root)
#
# Standard Ports:
#   - Web Application & REST API : Port 80
#   - Dozzle Container Log Viewer: Port 8080
#   - MySQL 8.4 Relational DB   : Port 3306
#
# 13-Step Automated Pipeline:
#   1. Detect Dynamic Host IP (WAN / LAN Fallback)
#   2. Pre-flight Hardware & Resource Check (OS, CPU, RAM, Disk)
#   3. Git Working Tree Sanity Check
#   4. Write / Patch .env Configuration (Dynamic IP & Encryption Key)
#   5. Stop Old Containers & Clear Name Conflicts
#   6. Build & Start Containers (MySQL, WebApp, Dozzle)
#   7. Wait for MySQL Database Health (:3306)
#   8. Execute Database Migrations (php spark migrate --all)
#   9. Verify Dozzle Log Viewer Readiness (:8080)
#  10. Verify WebApp Server Readiness (:80)
#  11. Container Permissions Enforcement (writable/)
#  12. Housekeeping & Docker Cache Pruning
#  13. Clean Execution Timeline & Access Summary
# ==============================================================================
set -euo pipefail

# ── Colors & Formatting ───────────────────────────────────────────────────────
GREEN="\033[0;32m"; YELLOW="\033[1;33m"; RED="\033[0;31m"
CYAN="\033[0;36m"; BOLD="\033[1m"; RESET="\033[0m"

DEPLOY_START_TIME=$(date +%s)
SECTION_START_TIME=$DEPLOY_START_TIME
PREV_SECTION=""
declare -a STAGE_NAMES=()
declare -a STAGE_DURATIONS=()

format_duration() {
    local S=$1
    if [ "$S" -ge 60 ]; then
        local M=$((S / 60))
        local R=$((S % 60))
        echo "${M}m ${R}s"
    else
        echo "${S}s"
    fi
}

log()  { echo -e "${GREEN}[OK]${RESET}   $1"; }
warn() { echo -e "${YELLOW}[WARN]${RESET} $1"; }
err()  {
    local NOW=$(date +%s)
    local ELAPSED=$((NOW - DEPLOY_START_TIME))
    echo -e "${RED}[FAIL]${RESET} $1 (aborted after $(format_duration "$ELAPSED"))"
    exit 1
}

section() {
    local NOW=$(date +%s)
    if [ -n "$PREV_SECTION" ]; then
        local DURATION=$((NOW - SECTION_START_TIME))
        echo -e "${CYAN}──> Completed: ${PREV_SECTION} in $(format_duration "$DURATION")${RESET}"
        STAGE_NAMES+=("$PREV_SECTION")
        STAGE_DURATIONS+=("$DURATION")
    fi
    PREV_SECTION="$1"
    SECTION_START_TIME=$NOW
    echo -e "\n${CYAN}${BOLD}=== $1 ===${RESET}"
}

finish_deployment() {
    local NOW=$(date +%s)
    if [ -n "$PREV_SECTION" ]; then
        local DURATION=$((NOW - SECTION_START_TIME))
        echo -e "${CYAN}──> Completed: ${PREV_SECTION} in $(format_duration "$DURATION")${RESET}"
        STAGE_NAMES+=("$PREV_SECTION")
        STAGE_DURATIONS+=("$DURATION")
        PREV_SECTION=""
    fi
    local TOTAL_DURATION=$((NOW - DEPLOY_START_TIME))
    echo ""
    echo -e "${GREEN}${BOLD}══════════════════════════════════════════════════════════════${RESET}"
    echo -e "${GREEN}${BOLD}   DEPLOYMENT TIMELINE & EXECUTION SUMMARY${RESET}"
    echo -e "${GREEN}${BOLD}══════════════════════════════════════════════════════════════${RESET}"
    for i in "${!STAGE_NAMES[@]}"; do
        printf "   %-48s : %s\n" "${STAGE_NAMES[$i]}" "$(format_duration "${STAGE_DURATIONS[$i]}")"
    done
    echo -e "   ------------------------------------------------------------"
    printf "   ${BOLD}%-48s${RESET} : ${BOLD}%s (%ss)${RESET}\n" "Total Deployment Time" "$(format_duration "$TOTAL_DURATION")" "$TOTAL_DURATION"
    echo -e "${GREEN}${BOLD}══════════════════════════════════════════════════════════════${RESET}"
}

# ── Guard: verify repository root ─────────────────────────────────────────────
[ -f "docker-compose.yml" ] || err "Run from the repository root (where docker-compose.yml lives)."

# ── 1. Detect Dynamic IP ──────────────────────────────────────────────────────
section "1. Detecting Dynamic Host IP"
DETECTED_IP=""
for url in "https://api.ipify.org" "https://ifconfig.me" "https://icanhazip.com"; do
    DETECTED_IP=$(curl -s --max-time 3 "$url" 2>/dev/null | tr -d '[:space:]' || true)
    [ -n "$DETECTED_IP" ] && break
done

# Fallback to local network IP
if [ -z "$DETECTED_IP" ]; then
    DETECTED_IP=$(hostname -I 2>/dev/null | awk '{print $1}' | tr -d '[:space:]' || true)
fi

# Fallback to localhost
if [ -z "$DETECTED_IP" ]; then
    DETECTED_IP="localhost"
fi

log "Resolved Host IP: ${BOLD}${DETECTED_IP}${RESET}"

# ── 2. Pre-flight Hardware & Resource Check ───────────────────────────────────
section "2. Pre-flight Hardware & Resource Check"

if [ -f /etc/os-release ]; then
    # shellcheck disable=SC1091
    . /etc/os-release
    OS_NAME="${PRETTY_NAME:-$NAME}"
else
    OS_NAME="$(uname -s)"
fi
KERNEL="$(uname -r)"
ARCH="$(uname -m)"
CPU_CORES=$(nproc 2>/dev/null || echo "1")

TOTAL_MEM_MB=$(free -m 2>/dev/null | awk '/Mem:/ {print $2}' || echo "0")
USED_MEM_MB=$(free -m 2>/dev/null | awk '/Mem:/ {print $3}' || echo "0")
FREE_MEM_MB=$(free -m 2>/dev/null | awk '/Mem:/ {print ($7 != "" ? $7 : $4)}' || echo "0")

if [ "$TOTAL_MEM_MB" -gt 0 ]; then
    MEM_PCT=$(awk -v u="$USED_MEM_MB" -v t="$TOTAL_MEM_MB" 'BEGIN {printf "%.1f", (u/t)*100}')
else
    MEM_PCT="0"
fi

DISK_AVAIL=$(df -h . | awk 'NR==2 {print $4}')
DISK_USE_PCT=$(df -h . | awk 'NR==2 {print $5}')

log "OS: $OS_NAME ($ARCH, Kernel $KERNEL)"
log "Compute: $CPU_CORES CPU Cores | RAM: ${USED_MEM_MB}MB / ${TOTAL_MEM_MB}MB used (${MEM_PCT}%)"
log "Disk: $DISK_AVAIL available (${DISK_USE_PCT} used)"

# ── 3. Git Working Tree Sanity Check ──────────────────────────────────────────
section "3. Checking Git Working Tree"
if command -v git >/dev/null 2>&1 && [ -d ".git" ]; then
    CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD 2>/dev/null || echo "detached")
    CURRENT_COMMIT=$(git rev-parse --short HEAD 2>/dev/null || echo "unknown")
    log "Branch: ${BOLD}${CURRENT_BRANCH}${RESET} (commit ${CURRENT_COMMIT})"
else
    warn "Git metadata not found or git is unavailable; skipping VCS checks."
fi

# ── 4. Write / Patch .env Configuration ───────────────────────────────────────
section "4. Configuring Environment (.env)"
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        log "Initialized .env from .env.example"
    else
        err ".env.example not found. Cannot initialize environment configuration."
    fi
fi

# Auto-patch app.baseURL with resolved IP
TARGET_BASE_URL="http://${DETECTED_IP}/"
if grep -q "^app.baseURL" .env; then
    sed -i "s|^app.baseURL.*|app.baseURL = '${TARGET_BASE_URL}'|" .env
    log "Updated app.baseURL to: ${TARGET_BASE_URL}"
else
    echo "app.baseURL = '${TARGET_BASE_URL}'" >> .env
    log "Appended app.baseURL: ${TARGET_BASE_URL}"
fi

# Ensure database settings in .env match the Docker MySQL service
set_or_replace_env() {
    local key="$1"
    local value="$2"
    if grep -q "^${key}" .env; then
        sed -i "s|^${key}.*|${key} = ${value}|" .env
    else
        echo "${key} = ${value}" >> .env
    fi
}

set_or_replace_env "database.default.hostname" "mysql"
set_or_replace_env "database.default.database" "db_my_coder"
set_or_replace_env "database.default.username" "root"
set_or_replace_env "database.default.password" "root_password"
set_or_replace_env "database.default.DBDriver" "MySQLi"
set_or_replace_env "database.default.port" "3306"
log "Configured database settings in .env for container network (mysql:3306/db_my_coder)."

# Ensure encryption key exists
CURRENT_KEY=$(grep "^encryption.key" .env | awk -F'=' '{print $2}' | tr -d " '" || true)
if [ -z "$CURRENT_KEY" ] || [ "$CURRENT_KEY" = "hex2bin:" ]; then
    NEW_KEY="hex2bin:$(openssl rand -hex 32 2>/dev/null || head -c 32 /dev/urandom | od -An -tx1 | tr -d ' \n')"
    sed -i "s|^encryption.key.*|encryption.key = ${NEW_KEY}|" .env
    log "Generated fresh 256-bit encryption key in .env"
else
    log "Encryption key is configured."
fi

# ── 5. Stop Old Containers & Clear Conflicts ───────────────────────────────────
section "5. Stopping Existing Containers"
docker compose down --remove-orphans >/dev/null 2>&1 || true
log "Existing containers and orphaned networks cleared."

# ── 6. Build & Start Containers ───────────────────────────────────────────────
section "6. Building and Starting Containers"
log "Building and orchestrating services (MySQL, WebApp, Dozzle)..."
docker compose up --build -d
log "Container orchestration launched."

# ── 7. Enforcing Permissions on writable/ ─────────────────────────────────────
section "7. Enforcing Permissions on writable/"
docker compose exec -T my-coder bash -c "mkdir -p /var/www/html/writable/cache /var/www/html/writable/session /var/www/html/writable/logs /var/www/html/writable/debugbar /var/www/html/writable/uploads && chmod -R 777 /var/www/html/writable && chown -R www-data:www-data /var/www/html/writable"
log "Enforced permissions (777 / www-data) on writable storage."

# ── 8. Wait for MySQL Health ──────────────────────────────────────────────────
section "8. Waiting for Database Health"
log "Waiting for MySQL container health probe on internal port 3306..."
MAX_ATTEMPTS=40
ATTEMPT=0
DB_HEALTHY=false

while [ $ATTEMPT -lt $MAX_ATTEMPTS ]; do
    ATTEMPT=$((ATTEMPT + 1))
    STATUS=$(docker inspect --format='{{json .State.Health.Status}}' shared-mysql 2>/dev/null || echo "\"unknown\"")
    if [ "$STATUS" = "\"healthy\"" ]; then
        DB_HEALTHY=true
        break
    fi
    echo -n "."
    sleep 2
done
echo ""

if [ "$DB_HEALTHY" != true ]; then
    err "MySQL failed to reach healthy status within 80 seconds."
fi

log "Verifying TCP connection and query readiness from WebApp container..."
TCP_READY=false
for i in {1..20}; do
    if docker compose exec -T my-coder php -r '
        mysqli_report(MYSQLI_REPORT_OFF);
        $m = @new mysqli("mysql", "root", "root_password", "db_my_coder", 3306);
        if (!$m->connect_error) {
            $res = $m->query("SELECT 1");
            if ($res) { exit(0); }
        }
        exit(1);
    ' >/dev/null 2>&1; then
        TCP_READY=true
        break
    fi
    echo -n "."
    sleep 1
done
echo ""

if [ "$TCP_READY" = true ]; then
    log "MySQL 8.4 is healthy and accepting queries on port 3306."
else
    err "MySQL container is running but port 3306 refused connection from WebApp container."
fi

# ── 9. Execute Database Migrations ────────────────────────────────────────────
section "9. Running Database Migrations"
log "Running CodeIgniter Spark migrations inside WebApp container..."
MIGRATE_OUT=$(docker compose exec -T my-coder php spark migrate --all 2>&1 || true)
echo "$MIGRATE_OUT"

if echo "$MIGRATE_OUT" | grep -qiE "DatabaseException|Connection refused|Unable to connect"; then
    err "Database migration failed due to a database exception."
fi

# Verify core tables were created
TABLE_COUNT=$(docker compose exec -T my-coder php -r '
    mysqli_report(MYSQLI_REPORT_OFF);
    $m = @new mysqli("mysql", "root", "root_password", "db_my_coder", 3306);
    if (!$m || $m->connect_error) { echo "0"; exit; }
    $res = $m->query("SHOW TABLES");
    echo $res ? $res->num_rows : "0";
' 2>/dev/null || echo "0")

if [ "$TABLE_COUNT" -eq 0 ]; then
    err "Database migration completed without error, but 0 tables exist in db_my_coder."
fi

log "Database migrations executed successfully (${TABLE_COUNT} tables present)."

# ── 10. Verify Dozzle Log Viewer Readiness ────────────────────────────────────
section "10. Verifying Dozzle Log Viewer"
DOZZLE_READY=false
for i in {1..15}; do
    if curl -sf --max-time 2 http://localhost:8080/ >/dev/null 2>&1; then
        DOZZLE_READY=true
        break
    fi
    sleep 1
done

if [ "$DOZZLE_READY" = true ]; then
    log "Dozzle container log viewer is accessible on http://localhost:8080"
else
    warn "Dozzle did not respond on :8080 immediately (it may still be initializing)."
fi

# ── 11. Verify WebApp Server Readiness ────────────────────────────────────────
section "11. Verifying WebApp Health"
APP_READY=false
for i in {1..20}; do
    HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" --max-time 3 http://localhost/ || echo "000")
    if [ "$HTTP_CODE" = "200" ] || [ "$HTTP_CODE" = "302" ]; then
        APP_READY=true
        break
    fi
    sleep 1
done

if [ "$APP_READY" = true ]; then
    log "WebApp HTTP probe passed (Status: ${HTTP_CODE})."
else
    warn "Diagnostic: Dumping HTTP error page from http://localhost/:"
    curl -sS --max-time 3 http://localhost/ | grep -A 4 -B 2 -iE "<title>|exception|error|whoops" | head -n 25 || true
    warn "Diagnostic: Recent CodeIgniter logs:"
    docker compose exec -T my-coder bash -c "tail -n 25 /var/www/html/writable/logs/*.log 2>/dev/null || true"
    warn "Diagnostic: Recent Apache error log:"
    docker compose exec -T my-coder tail -n 25 /var/log/apache2/error.log 2>/dev/null || true
    err "WebApp failed readiness probe on http://localhost/ (HTTP code: ${HTTP_CODE})."
fi

# ── 12. Housekeeping & Docker Cache Pruning ───────────────────────────────────
section "12. Housekeeping & Cache Pruning"
docker image prune -f >/dev/null 2>&1 || true
log "Pruned dangling Docker images."

# ── 13. Summary & Access Endpoints ────────────────────────────────────────────
finish_deployment

echo ""
echo -e "${GREEN}${BOLD}🚀 MY CODER WEBAPP IS DEPLOYED AND LIVE!${RESET}"
echo -e "${CYAN}------------------------------------------------------------${RESET}"
printf "  %-32s : %s\n" "Web Application (LAN/WAN)" "http://${DETECTED_IP}"
printf "  %-32s : %s\n" "Web Application (Local)"   "http://localhost"
printf "  %-32s : %s\n" "Dozzle Container Log Viewer" "http://${DETECTED_IP}:8080"
printf "  %-32s : %s\n" "MySQL Host Direct Port"    "localhost:3306"
echo -e "${CYAN}------------------------------------------------------------${RESET}"
echo -e "To follow live logs: ${BOLD}docker compose logs -f${RESET} or visit ${BOLD}http://localhost:8080${RESET}"
echo ""
