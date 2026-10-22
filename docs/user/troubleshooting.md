# User Guide: Troubleshooting

Common issues and remediation steps:

### 1. Port 80 or 8080 Already in Use
- **Symptom**: `Error response from daemon: driver failed programming external connectivity on endpoint ... address already in use`.
- **Fix**: Check what process is occupying the port:
  ```bash
  sudo lsof -i :80
  sudo lsof -i :8080
  ```
  Terminate the process or change the port mapping in `docker-compose.yml`.

### 2. MySQL Health Check Failing
- **Symptom**: `my-coder-webapp` container waits indefinitely for MySQL.
- **Fix**: Check MySQL container logs in Dozzle (`http://localhost:8080`) or via CLI:
  ```bash
  docker compose logs mysql
  ```

### 3. Writable Directory Permission Denied
- **Symptom**: PHP error stating `Unable to write to cache/session directory`.
- **Fix**: Re-apply ownership inside the container:
  ```bash
  docker compose exec my-coder chown -R www-data:www-data /var/www/html/writable
  ```
