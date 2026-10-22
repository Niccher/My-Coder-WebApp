# Engineering: Making Changes & Recipes

## 1. Developer Recipe Task Table

| If you want to… | Files to Touch | Verification Step |
|---|---|---|
| **Add a new AI Model Provider** (e.g. Anthropic Claude) | `app/Controllers/Api/ChatController.php` (add cURL builder case & response parser), `app/Views/chat/index.php` (modal dropdown) | Send test prompt with the new provider slot; verify JSON response format. |
| **Add a new REST API endpoint** | `app/Config/Routes.php`, `app/Controllers/Api/`, `docs/api/openapi.yaml` | Test endpoint with Postman / cURL; verify CSRF/session filter enforcement. |
| **Add a new database migration** | `php spark make:migration <Name>`, edit file in `app/Database/Migrations/` | Run `php spark migrate --all`; verify table/column in MySQL. |
| **Modify Chat UI / Client Logic** | `public/js/chat.js`, `public/css/chat.css`, `app/Views/chat/` | Reload browser; verify theme persistence and Markdown rendering. |
| **Adjust Container Topology** | `docker-compose.yml`, `scripts/deploy.sh` | Run `docker compose config`; test `bash scripts/deploy.sh`. |

---

## 2. Definition of Done (DoD)

Before merging any pull request:
- [ ] Code adheres to CodeIgniter 4 standards.
- [ ] Migrations are reversible where applicable.
- [ ] No plaintext secrets or API tokens committed.
- [ ] `docs/api/openapi.yaml` updated if API endpoints or payloads changed.
- [ ] `scripts/deploy.sh` tested and passes cleanly.
- [ ] Automated tests run (`composer test`).
