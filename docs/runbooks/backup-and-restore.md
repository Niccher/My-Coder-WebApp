# Operational Runbook: Database & Asset Backup & Recovery

## 1. Database Backup (Snapshot via mysqldump)

To create a timestamped SQL dump of `db_my_coder`:

```bash
mkdir -p backups
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
docker compose exec -T mysql mysqldump -u root -proot_password db_my_coder > "backups/my_coder_backup_${TIMESTAMP}.sql"
echo "Backup created: backups/my_coder_backup_${TIMESTAMP}.sql"
```

---

## 2. Database Restore

To restore from an existing SQL dump:

```bash
BACKUP_FILE="backups/my_coder_backup_YYYYMMDD_HHMMSS.sql"

# Pipe SQL dump into the container
cat "$BACKUP_FILE" | docker compose exec -T mysql mysql -u root -proot_password db_my_coder

# Re-run migrations to ensure schema currency
docker compose exec -T my-coder php spark migrate --all
```

---

## 3. Uploaded Assets Backup & Restore

User avatars are stored in `public/uploads/avatars/`:

```bash
# Archive avatars
tar -czvf "backups/avatars_${TIMESTAMP}.tar.gz" public/uploads/avatars/

# Restore avatars
tar -xzvf "backups/avatars_YYYYMMDD_HHMMSS.tar.gz" -C .
```
