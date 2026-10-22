# Operational Runbook: Container Restarts & Recovery

## 1. Graceful Container Restart

To safely stop and restart containers without data loss:

```bash
# Restart without rebuilding
docker compose restart

# Gracefully take down containers (preserves MySQL volume)
docker compose down

# Bring back up
docker compose up -d
```

---

## 2. Clean Rebuild (No-Cache)

Use when Dockerfile or base dependencies change:

```bash
docker compose down
docker compose build --no-cache
docker compose up -d
```

---

## 3. Emergency "Nuclear" Reset (Destructive)

> [!CAUTION]
> This destroys all conversations, user accounts, and database records!

```bash
# Stop containers and erase named volumes
docker compose down -v

# Re-run automated deployment to re-initialize schema from scratch
bash scripts/deploy.sh
```
