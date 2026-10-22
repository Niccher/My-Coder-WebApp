# User Guide: Configuration Reference

This reference documents environment variables configurable in `.env`.

| Variable | Default Value | Description |
|---|---|---|
| `CI_ENVIRONMENT` | `development` | `development` (enables debugbar/error display) or `production` |
| `app.baseURL` | `http://localhost/` | The public base URL of the web application |
| `database.default.hostname` | `mysql` | Hostname of the MySQL container (`mysql` in Docker) |
| `database.default.database` | `db_my_coder` | Database name |
| `database.default.username` | `root` | Database username |
| `database.default.password` | `root_password` | Database password |
| `database.default.port` | `3306` | MySQL internal port |
| `encryption.key` | Generated | 256-bit key used for encrypting API keys at rest (`hex2bin:...`) |
| `AUTH_SEND_EMAIL_ON_REGISTER` | `false` | When `false`, user registration does not require email verification |
