# 🚀 My Coder WebApp

A professional multi-model AI orchestration platform built on CodeIgniter 4 and MySQL 8.4. It enables developers to dispatch unified prompts concurrently across multiple AI models (Gemini, DeepSeek, Grok, OpenAI) and receive an authoritative synthesized evaluation and ranking from a Master Model.

[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)](#)
[![CodeIgniter 4](https://img.shields.io/badge/CodeIgniter-4.x-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)](#)
[![MySQL](https://img.shields.io/badge/MySQL-8.4-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](#)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white)](#)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](LICENSE)

**If you only need to run the system, this page is enough.**  
Software engineers and contributors: see the [Engineering Documentation](docs/README.md).

---

## 🖥️ What "Running" Looks Like

| Service | URL / Port | Purpose | Default Credentials |
|---|---|---|---|
| **Web Application** | [http://localhost](http://localhost) (Port 80) | Multi-model chat interface & dashboard | Create account at `/register` |
| **Dozzle Log Viewer** | [http://localhost:8080](http://localhost:8080) (Port 8080) | Real-time container logs & resource metrics | None (open LAN access) |
| **MySQL Database** | `localhost:3306` (host) | Relational persistence (`db_my_coder`) | User: `root` / Pass: `root_password` |

---

## 📋 Prerequisites

- **Git**
- **Docker Engine** (24+) and **Docker Compose v2**

*(Native installation without Docker requires PHP 8.4+, Composer, and MySQL 8.4; see [Native Setup Guide](docs/engineering/local-development.md)).*

---

## ⚡ Setup and Run

From a fresh clone, run the automated 13-stage deployment pipeline:

```bash
# 1. Clone the repository
git clone https://github.com/Niccher/My-Coder-WebApp.git
cd My-Coder-WebApp

# 2. Run the automated deployment pipeline
bash scripts/deploy.sh
```

The script automatically detects your network IP, performs hardware pre-flight checks, configures `.env`, builds containers, executes database migrations, verifies service health, and outputs access URLs.

### Stopping the Stack

```bash
docker compose down
```

---

## ⚙️ Configuration (User Editable)

Variables configurable in `.env` (copied automatically from `.env.example`):

| Variable | Default Value | Purpose |
|---|---|---|
| `app.baseURL` | `http://localhost/` | Public address of the web application |
| `database.default.hostname` | `mysql` | MySQL container hostname |
| `database.default.database` | `db_my_coder` | Application database name |
| `database.default.password` | `root_password` | Database root password |
| `AUTH_SEND_EMAIL_ON_REGISTER` | `false` | Disable email verification for self-hosted setups |

*For full variable details, see [Configuration Reference](docs/user/configuration.md).*

---

## ❓ Something Went Wrong?

| Symptom | Quick Fix |
|---|---|
| **Port 80 or 8080 in use** | Stop conflicting processes (`sudo lsof -i :80`) or edit ports in `docker-compose.yml`. |
| **MySQL not ready** | Check container logs in Dozzle (`http://localhost:8080`) or run `docker compose logs mysql`. |
| **Permission denied on writable** | Run `docker compose exec my-coder chown -R www-data:www-data /var/www/html/writable`. |

*For extended diagnosis, see [Troubleshooting Guide](docs/user/troubleshooting.md).*

---

## 🧑‍💻 Software Engineers

- **Engineering Index**: [docs/README.md](docs/README.md)
- **Architecture Overview**: [docs/architecture/overview.md](docs/architecture/overview.md)
- **Communication & Sequence Flows**: [docs/architecture/communication.md](docs/architecture/communication.md)
- **REST API Contract**: [docs/api/openapi.yaml](docs/api/openapi.yaml)
- **CodeIgniter 4 Service Guide**: [docs/services/codeigniter.md](docs/services/codeigniter.md)
- **Making Changes & Recipes**: [docs/engineering/making-changes.md](docs/engineering/making-changes.md)
- **Restart & Recovery Runbook**: [docs/runbooks/restart.md](docs/runbooks/restart.md)
