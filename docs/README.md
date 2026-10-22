# 🛠️ Engineering Documentation

Welcome to the **My Coder WebApp** engineering documentation. This directory is written specifically for software engineers and architects who need to understand, maintain, test, and evolve the platform.

If you only need to **run or operate** the platform, refer to the root [README.md](../README.md).

---

## 🗺️ Navigation

| I want to… | Resource | Description |
|---|---|---|
| **Run without coding** | [../README.md](../README.md) | 1-click Docker deployment and operator run instructions |
| **Understand the Architecture** | [architecture/overview.md](architecture/overview.md) | C4 container model, network topology, and trust boundaries |
| **Inspect Service Communication** | [architecture/communication.md](architecture/communication.md) | Multi-model parallel inference flow & sequence diagrams |
| **Inspect Data & Storage** | [architecture/data-and-storage.md](architecture/data-and-storage.md) | MySQL schema, API key encryption, and Redis/MinIO analysis |
| **Explore the REST API** | [api/openapi.yaml](api/openapi.yaml) | Full OpenAPI 3.0 specification for all REST endpoints |
| **Work on CodeIgniter 4** | [services/codeigniter.md](services/codeigniter.md) | Controllers, Shield auth, routes, and Spark CLI |
| **Set Up Native Development** | [engineering/local-development.md](engineering/local-development.md) | Developing locally without container rebuild overhead |
| **Add Features Safely** | [engineering/making-changes.md](engineering/making-changes.md) | Developer recipe task table and Definition of Done (DoD) |
| **Container Operations** | [runbooks/restart.md](runbooks/restart.md) | Graceful restarts, clean rebuilds, and nuclear resets |
| **Disaster Recovery** | [runbooks/backup-and-restore.md](runbooks/backup-and-restore.md) | Database dump automation and avatar asset restore |
| **Review Architectural Decisions** | [adr/0001-multi-model-master-synthesis.md](adr/0001-multi-model-master-synthesis.md) | ADR: Multi-model parallel fan-out and master synthesis |

---

## 🏗️ System Overview

```mermaid
flowchart TD
    Client["Browser / Single Page Client"]
    Dozzle["Dozzle Log Viewer (:8080)"]
    DockerSock["/var/run/docker.sock"]

    subgraph AppContainer["Application Container (my-coder-webapp :80)"]
        Apache["Apache 2.4 (VirtualHost /public)"]
        CI4["CodeIgniter 4.5+ (PHP 8.4.27)"]
        Shield["CodeIgniter Shield Auth"]
        ChatEngine["Multi-Model ChatController (curl_multi)"]
    end

    subgraph StorageLayer["Data & Persistence Layer"]
        MySQL[("MySQL 8.4 Database (:3306)")]
        DiskStorage[("Local Disk Volumes (writable/, uploads/)")]
    end

    subgraph ExternalAI["External AI Model Providers"]
        Gemini["Google Gemini API"]
        OpenAI["OpenAI API"]
        DeepSeek["DeepSeek API"]
        Grok["xAI Grok API"]
        Others["Kimi / MiniMax / Groq"]
    end

    Client -->|HTTP / AJAX POST| Apache
    Client -->|HTTP :8080| Dozzle
    Dozzle -.->|read-only socket| DockerSock

    Apache --> CI4
    CI4 --> Shield
    CI4 --> ChatEngine
    Shield --> MySQL
    CI4 --> MySQL
    CI4 --> DiskStorage

    ChatEngine -->|Parallel HTTPS| Gemini
    ChatEngine -->|Parallel HTTPS| OpenAI
    ChatEngine -->|Parallel HTTPS| DeepSeek
    ChatEngine -->|Parallel HTTPS| Grok
    ChatEngine -->|Parallel HTTPS| Others
```
