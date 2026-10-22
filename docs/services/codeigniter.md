# Service Guide: CodeIgniter 4 WebApp

## 1. Directory Layout & Roles

The web application backend is located in the root repository and follows standard CodeIgniter 4 conventions:

```text
app/
├── Config/               # Routes, Filters, Session, Database, and Shield configs
├── Controllers/
│   ├── Api/              # REST JSON API Controllers (Chat, Settings, Conversations)
│   ├── Auth/             # Custom authentication view controller
│   ├── Chat.php          # Main chat view controller
│   └── Landing.php       # Public SEO landing pages
├── Database/
│   └── Migrations/       # Database migrations (Shield + App schema)
├── Models/               # Conversation, Message, Persona, UserSetting, Folder
└── Views/
    ├── auth/             # Custom login, registration, and password recovery views
    ├── chat/             # Chat workspace, sidebar, and slot configuration modals
    └── landing/          # Features, How It Works, Models, Docker setup, FAQ
```

---

## 2. Essential Spark CLI Commands

Run these inside the container (`docker compose exec my-coder <command>`) or natively:

```bash
# Display system information and routes
php spark routes

# Run all pending migrations
php spark migrate --all

# Create a new migration
php spark make:migration AddTelemetryToMessages

# Run unit and integration tests
./vendor/bin/phpunit
```

---

## 3. Shield Authentication & Route Protection

All private and API routes are guarded by filters in `app/Config/Routes.php`:
- `session`: Enforces authenticated session.
- `auth-rates`: Throttles requests to prevent API spamming.
- `csrf`: Auto-validates CSRF tokens across POST, PATCH, and DELETE requests.
