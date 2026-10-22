# Engineering: Local Development Guide

## 1. Prerequisites (Native Development)

If developing natively without Docker, ensure your host has:
- **PHP 8.4** (`php -v`)
- PHP Extensions: `intl`, `mbstring`, `mysqli`, `pdo_mysql`, `zip`, `gd`, `curl`
- **Composer 2.x**
- **MySQL 8.4** (or running via `docker compose up -d mysql`)

---

## 2. Setup Procedure

1. **Clone repository**:
   ```bash
   git clone https://github.com/Niccher/My-Coder-WebApp.git
   cd My-Coder-WebApp
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Configure Environment**:
   ```bash
   cp .env.example .env
   # Update database.default.hostname to localhost
   # Update app.baseURL to http://localhost:8080/
   ```

4. **Generate Encryption Key**:
   ```bash
   php spark key:generate
   ```

5. **Run Migrations**:
   ```bash
   php spark migrate --all
   ```

6. **Start Development Server**:
   ```bash
   php spark serve --port 8080
   ```
