# 🚀 myCoder

> A professional, highly-scalable CodeIgniter 4 web application built for modern workflows.

A sophisticated **multi-model AI orchestration platform** that queries several LLMs at once, giving you a unified interface for sending one prompt to models like Gemini, DeepSeek, Grok, OpenAI, Kimi, MiniMax, Groq, and OpenRouter — and letting a **Master Model** audit, rank, and synthesize the best answer.

[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php&logoColor=white)](#)
[![CodeIgniter 4](https://img.shields.io/badge/CodeIgniter-4.x-EF4223?style=for-the-badge&logo=codeigniter&logoColor=white)](#)
[![MySQL](https://img.shields.io/badge/MySQL-8.4-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](#)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker&logoColor=white)](#)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge)](LICENSE)

---

## 📖 1. About the Project

**myCoder** is a self-hosted chat platform that sends your prompt to **up to 6 configured AI models in parallel** and displays every answer side by side. A dedicated **Master Model slot** then reviews all responses, flags incorrect or misleading content, and produces a synthesized final answer.

It is built on CodeIgniter 4 with **CodeIgniter Shield** authentication and ships fully containerized (Docker Compose) with zero-configuration automated database migrations on boot and host-mapped persistent storage.

**Who it's for:** developers, power users, and teams that want to compare AI providers side by side, evaluate model quality, or hedge across vendors — all in one private, self-hosted interface.

---

## ✨ 2. Features

### 🤖 Multi-Model Orchestration
- **6 parallel model slots** (slots 1–6) + **1 Master evaluator slot** (slot 7).
- Supports **8 providers**: Google Gemini, DeepSeek, xAI Grok, OpenAI, Moonshot Kimi, MiniMax, Groq, and OpenRouter.
- Requests are fired **simultaneously with `curl_multi`** (non-blocking) — total latency equals the slowest model, not the sum of all.
- Per-model **history limit** — cap how many past messages each model receives (or keep it unlimited).

### ⭐ Master Model Evaluation
- Slot 7 reviews every model's output, identifies inaccuracies, names the best answer, and synthesizes a combined final response.
- System instructions injected at the API level prevent internal reasoning/`<thought>` leakage from appearing in responses.

### 👤 AI Personas
- Define reusable **system instructions** (e.g. "Code Reviewer", "Technical Writer") and assign one per conversation.
- Mark a persona as the **default** for new chats.

### 💬 Conversation Management
- Create, open, delete, and **branch (fork)** conversations from any message.
- Conversations are addressable via **shareable UUID links** (`/c/{uuid}`).
- Organize chats into **folders** (create, rename-assign, delete, drag-free via actions modal).
- **Global history explorer** with live search and pagination.
- **Retry** any user message and **copy** any AI response with one click.

### 📤 Export & Share
- Export any conversation as **PDF, JSON, XML, or YAML** (generated client-side).
- Copy a conversation's share link with one click.

### 🔐 Security
- Authentication & authorization via **CodeIgniter Shield** (register / login / logout / magic-link / two-factor actions).
- **Encrypted API keys at rest** (AES-256-CTR, base64-stored in the DB, decrypted in memory only).
- API keys are **masked** in API responses (first/last 4 chars only).
- Global **CSRF** protection, rate limiting on `POST /api/chat`, and hardened session handling.
- Full ownership checks on every conversation/persona/folder — users only ever see their own data.

### 🖥️ Frontend UX
- Side-by-side "kanban" response cards with skeleton loaders and animated streaming text.
- **Markdown rendering** (Marked.js) with **syntax-highlighted code blocks** (Prism.js) and one-click copy.
- **File attachments**: text is extracted client-side and injected as context (files are never stored server-side).
- Live **token & cost estimation** as you type.
- **3 themes** (Dark, Solarized, White) persisted in `localStorage`.
- Responsive UI with Bootstrap 5, jQuery, and Font Awesome.

### 🐳 DevOps
- **100% Dockerized**: Apache + PHP 8.4 (8.4.27) + MySQL 8.4 + phpMyAdmin.
- **Automated migrations** run automatically on container boot.
- Database data persisted in a named volume; project files bind-mounted to the host.

---

## ⚙️ 3. Tech Stack

| Layer | Technology |
|---|---|
| **Backend Framework** | [CodeIgniter 4](https://codeigniter.com/) |
| **Authentication** | [CodeIgniter Shield](https://github.com/codeigniter4/shield) |
| **Language** | PHP 8.4 (composer requires `^8.1`) |
| **Database** | MySQL 8.4 |
| **Database Manager** | phpMyAdmin |
| **Containerization** | Docker & Docker Compose |
| **Dependency Manager** | Composer |
| **Frontend** | Bootstrap 5, jQuery, Marked.js, Prism.js, Font Awesome, html2pdf.js, js-yaml |

---

## 🏗️ 4. How It Works (Architecture)

1. **Configure models** — In *Settings → Models*, assign a provider, model name, API key, and optional history limit to any of the 7 slots. API keys are encrypted before being written to `user_settings`.
2. **Send a prompt** — `POST /api/chat` (see [API reference](#9-rest-api-reference)) saves the user message, loads the configured models, and loads the conversation history.
3. **Parallel execution** — Each active model is queried concurrently using PHP's `curl_multi_*` functions. Every model receives its own clean thread: only the user messages plus **its own** previous answers (OpenAI-style message arrays or Gemini `contents`, depending on provider).
4. **Persist & evaluate** — Every model's response is stored (tagged with its `model_name`) and displayed in a side-by-side card. If slot 7 (Master) is configured and more than one model responded, the Master Model evaluates all answers and a synthesized result is stored and shown.

**Key implementation details:**

| Concern | Implementation |
|---|---|
| Parallel HTTP | `curl_multi_init()` / `curl_multi_exec()` in `app/Controllers/Api/ChatController.php:174` |
| History isolation per model | `buildOpenAiMessages()` / `buildGeminiContents()` filter AI messages by `model_name` |
| Master evaluation prompt | `queryMasterModel()` builds an expert-evaluation prompt from all model outputs |
| API key encryption | CodeIgniter `Encrypter` (AES-256-CTR) + base64 storage in `UserSettingModel` |
| Immutable history | `MessageModel` disables the `updated` timestamp; messages never change |
| Rate limiting | `auth-rates` filter applied to `POST /api/chat` |
| Shareable chats | 128-bit random UUID per conversation (`ConversationModel::generateUuid`) |

**Why this design?**
- **Latency** — `curl_multi` means a 3-model query takes about as long as the slowest model, not 3× the average.
- **Context hygiene** — filtering history per model avoids cross-model contamination (Model A never sees Model B's answers), keeping every thread valid and token-efficient.
- **Provenance** — every AI message is tagged with its source model, so you always know who said what.
- **Privacy** — keys are encrypted at rest; prompts and responses stay on your own server.

---

## 📋 5. Prerequisites

- [Docker](https://docs.docker.com/get-docker/) & [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/)

*(To run without Docker you'll need PHP 8.1+, Composer, MySQL, and the PHP extensions `intl`, `mbstring`, `curl` and a MySQL driver.)*

---

## 🚀 6. Installation & Setup (Detailed)

### Option 1: Using Docker (Preferred & Easiest)

A pre-configured `docker-compose.yml` eliminates the need to install PHP, a web server, or MySQL locally.

#### 1. Clone the repository
```bash
git clone https://github.com/yourusername/my-coder-webapp.git
cd "My Coder WebApp"
```

#### 2. Configure Environment Variables
```bash
cp .env.example .env
```
*(The defaults in `.env.example` match the bundled Docker setup — host `mysql`, database `db_my_coder`, user `root`, password `root_password`.)*

#### 3. Build and Run
```bash
docker compose up --build -d
```

#### 4. Access the Application
Migrations run automatically on first boot. Your services are available at:
- **Application**: [http://localhost:9003](http://localhost:9003)
- **phpMyAdmin**: [http://localhost:9000](http://localhost:9000)
- **MySQL (external)**: port `9306`

**Useful Docker Commands:**
- Stop the application: `docker compose down`
- View live application logs: `docker compose logs -f my-coder`
- Restart the application: `docker compose restart my-coder`
- Re-run migrations manually: `docker compose exec my-coder php spark migrate --all`

### Option 2: Local Development (Without Docker)

1. **Clone the repo** and run `composer install` in the root directory.
2. **Copy `.env.example`** to `.env`.
3. **Configure the Database**: update the `database.default.*` variables inside your `.env` to match your local MySQL credentials (and change `app.baseURL` to `http://localhost:8080/` for `php spark serve`).
4. **Generate an encryption key** (used to protect API keys):
   ```bash
   php spark key:generate
   ```
5. **Run Migrations**:
   ```bash
   php spark migrate --all
   ```
6. **Serve the Application**:
   ```bash
   php spark serve
   ```

---

## 🗄️ 7. Database Configuration

With Docker, the database is fully automated.

**Development Credentials:**
- **Host:** `mysql` (inside the Docker network)
- **Database Name:** `db_my_coder`
- **Username:** `root`
- **Password:** `root_password`
- **External port:** `9306`

Manage it visually at [http://localhost:9000](http://localhost:9000) using the credentials above.

**Schema** (managed by migrations in `app/Database/Migrations/`):
- `users`, `auth_*` tables — managed by CodeIgniter Shield
- `user_settings` — per-slot model config (slot, model name, provider, encrypted key, history limit)
- `conversations` — chat threads (user, title, uuid, persona, folder)
- `messages` — immutable user/AI messages tagged with `model_name`
- `personas` — reusable system instructions
- `folders` — conversation organization

---

## 📖 8. Usage

1. **Sign Up / Login** — Create an account from the landing page (`/register`). Email verification is disabled by default for self-hosted installs.
2. **Configure AI models** — Open **Settings → Models & Tokens**. Pick a provider and model per slot, enter your API keys (they're encrypted and masked after saving), and optionally set a per-model history limit.
3. **Optional: create Personas** — In **Settings → Personas**, add reusable system instructions and mark one as default.
4. **Chat** — Type a prompt, optionally attach files (text context) and pick a persona. All configured models answer in parallel; the Master Model (slot 7) adds a synthesized evaluation.
5. **Manage chats** — Branch from any message, retry a prompt, organize chats into folders, search all history, and share chats via their unique `/c/{uuid}` link.
6. **Export** — From the user menu, export the current chat as PDF, JSON, XML, or YAML.
7. **Profile** — Update your display name, bio, and avatar from **Settings → Profile**.

> **Note on uploads:** files attached to a chat are read in the browser and only their text content is sent as context — they are **not** stored on the server. User avatars are uploaded to `public/uploads/avatars/` (bind-mounted to the host in Docker).

---

## 🔌 9. REST API Reference

All routes below require an authenticated session (Shield `session` filter).

### Chat
| Method | Route | Description |
|---|---|---|
| `POST` | `/api/chat` | Send a prompt to all configured models + Master evaluation. Body: `{ prompt, conversation_id?, persona_id?, file_context? }` |

### Settings
| Method | Route | Description |
|---|---|---|
| `GET` | `/api/settings` | Current user's 7 slots (keys masked) |
| `POST` | `/api/settings` | Save slots. Body: `{ slots: [{ slot, provider, model_name, api_key?, history_limit? }] }` |

### Conversations
| Method | Route | Description |
|---|---|---|
| `GET` | `/api/conversations` | All conversations for the user |
| `GET` | `/api/conversations/paginated?page=&search=` | Paginated history (10/page) with model names |
| `GET` | `/api/conversations/{id\|uuid}` | Conversation detail with messages |
| `DELETE` | `/api/conversations/{id}` | Delete a conversation |
| `POST` | `/api/conversations/{id}/branch` | Fork a conversation from a message. Body: `{ message_id }` |
| `PATCH` | `/api/conversations/{id}/folder` | Assign/unassign a folder. Body: `{ folder_id }` |

### Personas
| Method | Route | Description |
|---|---|---|
| `GET` | `/api/personas` | List personas |
| `POST` | `/api/personas` | Create/update a persona |
| `DELETE` | `/api/personas/{id}` | Delete a persona |

### Folders
| Method | Route | Description |
|---|---|---|
| `GET` | `/api/folders` | List folders |
| `POST` | `/api/folders` | Create a folder. Body: `{ name }` |
| `DELETE` | `/api/folders/{id}` | Delete a folder (conversations unlinked) |

### User
| Method | Route | Description |
|---|---|---|
| `POST` | `/api/user/profile` | Update profile (multipart: `username`, `bio`, optional `avatar` file) |

---

## 📁 10. Project Structure

```text
.
├── app/
│   ├── Config/              # Routes, Filters, Session, Security, etc.
│   ├── Controllers/
│   │   ├── Api/             # Chat, Conversations, Settings, Personas, Folders, User
│   │   ├── Auth/            # (views) auth helper controller
│   │   ├── Chat.php         # Chat page renderer
│   │   └── Landing.php      # Landing/SEO pages
│   ├── Database/Migrations/ # Shield auth + app schema (settings, conversations, ...)
│   ├── Models/              # Conversation, Message, Persona, UserSetting
│   └── Views/
│       ├── auth/            # Login / register / password views
│       ├── chat/            # Chat UI + sidebar + settings modals
│       ├── landing/         # Home, features, how-it-works, models, docker-setup, FAQ
│       └── errors/          # Custom error pages (400/401/403/404/5xx)
├── public/                  # Document root: index.php, css/, js/chat.js, uploads/
├── system/                  # CodeIgniter 4 framework
├── writable/                # Cache, logs, sessions (bind-mounted in Docker)
├── docker-compose.yml       # MySQL + phpMyAdmin + app orchestration
├── Dockerfile               # PHP 8.4 + Apache build
├── entrypoint.sh            # Waits for MySQL, auto-migrates, starts Apache
└── spark                    # CodeIgniter CLI
```

---

## 🛡️ 11. Security Notes

- API keys are encrypted at rest with the CodeIgniter `Encrypter` (default cipher AES-256-CTR) and stored base64-encoded in `user_settings.api_key`. Decryption happens only in memory during a request.
- Every data-access method scopes queries by the authenticated `user_id` (see `findForUser()` and the `->where('user_id', ...)` calls).
- Global CSRF filter protects all forms/API calls; `auth-rates` throttles the chat endpoint.
- `App.php`/`Security.php` configure hardened session & security defaults.

---

## 🤝 12. Contributing

We welcome contributions from the community! To contribute:

1. **Fork** the repository.
2. **Create a new branch**: `git checkout -b feature/your-feature-name`
3. **Commit your changes**: `git commit -m 'Add some feature'`
4. **Push to the branch**: `git push origin feature/your-feature-name`
5. **Open a Pull Request**.

Please run `composer test` (PHPUnit) and verify your changes inside the Docker environment before submitting. See `CONTRIBUTING.md` for more detail.

---

## 📄 13. License

Distributed under the MIT License. See `LICENSE` for more information.

---

## 📸 14. Screenshots & Demo

*(Screenshots coming soon)*

---

## 💬 15. Support & Acknowledgments

- Built with ❤️ using [CodeIgniter 4](https://codeigniter.com/) and [CodeIgniter Shield](https://github.com/codeigniter4/shield).
- UI components powered by Bootstrap 5, jQuery, Marked.js, Prism.js, and Font Awesome.
