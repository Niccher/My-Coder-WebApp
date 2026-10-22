# User Guide: Setup and Run

## Overview
This guide provides complete instructions for operators and users deploying **My Coder WebApp** on a fresh machine.

---

## 1. Quick Start (Automated Pipeline)

From the project root:

```bash
# Execute the 13-stage automated deployment pipeline
bash scripts/deploy.sh
```

The script will automatically:
- Discover host IP
- Run hardware pre-flight checks
- Initialize and configure `.env`
- Start MySQL 8.4, WebApp (PHP 8.4), and Dozzle log viewer
- Execute database migrations
- Enforce permissions on storage

---

## 2. Verification Checklist

After deployment finishes, verify the following services:

| Service | Address | Expected Status |
|---|---|---|
| **Web Application** | `http://localhost` (Port 80) | 200 OK (Landing page) |
| **Dozzle Log Viewer** | `http://localhost:8080` (Port 8080) | 200 OK (Shows live container logs) |
| **MySQL Direct Port** | `localhost:3306` (host) | Accepting connections |

---

## 3. Stopping the Stack

```bash
docker compose down
```
To stop containers without losing database data.
