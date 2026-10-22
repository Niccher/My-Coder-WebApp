<?= $this->extend('landing/layout') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Deploy with <span class="gradient-text">Docker</span></h1>
    <p>Run myCoder on your own infrastructure in minutes. All services are containerized with Docker Compose.</p>
</div>

<section>
    <div class="container-custom" style="max-width: 900px; margin: 0 auto;">
        <h5 class="fw-semibold mb-2">Prerequisites</h5>
        <ul style="color: var(--landing-muted); line-height: 2.2;">
            <li><strong>Docker</strong> Engine v24+ and <strong>Docker Compose</strong> v2+ installed on your host.</li>
            <li><strong>Git</strong> to clone the repository.</li>
            <li>Ports <code>9003</code> (app), <code>9306</code> (MySQL), and <code>9000</code> (phpMyAdmin) available on your host.</li>
            <li>Minimum 1 GB RAM (2 GB recommended for parallel API requests).</li>
        </ul>

        <h5 class="fw-semibold mt-5 mb-2">Quick Start</h5>
        <div class="docker-block">
            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-clipboard me-1"></i>Copy</button>
            <pre><code># 1. Clone the repository
git clone https://github.com/your-org/my-coder-webapp.git
cd my-coder-webapp

# 2. Configure environment
cp .env.example .env
# Edit .env with your database credentials and app URL

# 3. Start all services
docker compose up -d

# 4. Run database migrations
docker compose exec my-coder php spark migrate --all

# 5. Open in your browser
echo "Open http://localhost:9003"</code></pre>
        </div>

        <h5 class="fw-semibold mt-5 mb-2">Architecture</h5>
        <p style="color: var(--landing-muted);">
            The stack runs three containers orchestrated by Docker Compose, connected via a shared network:
        </p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
            <div class="feature-card" style="padding: 1.25rem;">
                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;"><i class="fa-solid fa-database" style="color: #f39c12;"></i></div>
                <h6 style="font-weight: 600;">MySQL 8.4</h6>
                <p style="font-size: 0.85rem;">Persistent data store. Exposed on port <code>9306</code>. Uses a named volume <code>mysql-data</code> for persistence across restarts. Healthcheck configured via mysqladmin ping.</p>
            </div>
            <div class="feature-card" style="padding: 1.25rem;">
                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;"><i class="fa-solid fa-server" style="color: #3b82f6;"></i></div>
                <h6 style="font-weight: 600;">myCoder App</h6>
                <p style="font-size: 0.85rem;">PHP 8.3 + Apache with mod_rewrite. Exposed on port <code>9003</code>. Auto-runs migrations on first start via <code>entrypoint.sh</code>. Writable directory mounted for logs, cache, sessions, and uploads.</p>
            </div>
            <div class="feature-card" style="padding: 1.25rem;">
                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;"><i class="fa-solid fa-table" style="color: #22c55e;"></i></div>
                <h6 style="font-weight: 600;">phpMyAdmin</h6>
                <p style="font-size: 0.85rem;">Web-based database administration. Exposed on port <code>9000</code>. Auto-connected to the MySQL container via environment variables.</p>
            </div>
        </div>

        <h5 class="fw-semibold mt-5 mb-2">Environment Variables</h5>
        <p style="color: var(--landing-muted);">The <code>.env</code> file at the project root controls all key configuration:</p>
        <div class="docker-block">
            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-clipboard me-1"></i>Copy</button>
            <pre><code># .env key settings
app.baseURL = 'http://localhost:9003/'

# Database — hostname must match the Docker service name
database.default.hostname = mysql
database.default.username = root
database.default.password = root_password
database.default.database = db_my_coder
database.default.DBDriver = MySQLi
database.default.port = 3306

# Encryption key for API key storage
# Generate with: openssl rand -hex 32
encryption.key = hex2bin:your-32-byte-hex-key-here

# Disable email verification for local/private deployments
AUTH_SEND_EMAIL_ON_REGISTER=false</code></pre>
        </div>

        <h5 class="fw-semibold mt-5 mb-2">Docker Compose Configuration</h5>
        <p style="color: var(--landing-muted);">The full <code>docker-compose.yml</code> defines three services with a shared network and persistent volume:</p>
        <div class="docker-block">
            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-clipboard me-1"></i>Copy</button>
            <pre><code>services:
  mysql:
    image: mysql:8.4
    ports: ["9306:3306"]
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: db_my_coder
    volumes: [mysql-data:/var/lib/mysql]
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost"]
      interval: 10s
      timeout: 5s
      retries: 5

  my-coder:
    build: .
    ports: ["9003:80"]
    environment:
      CI_ENVIRONMENT: production
    depends_on:
      mysql: { condition: service_healthy }
    volumes: [./writable:/var/www/html/writable]

  phpmyadmin:
    image: phpmyadmin:latest
    ports: ["9000:80"]
    environment:
      PMA_HOST: mysql
      PMA_PORT: 3306

volumes:
  mysql-data:</code></pre>
        </div>

        <h5 class="fw-semibold mt-5 mb-2">Dockerfile</h5>
        <p style="color: var(--landing-muted);">The application container is built from <code>php:8.4.27-apache</code> with these additions:</p>
        <div class="docker-block">
            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-clipboard me-1"></i>Copy</button>
            <pre><code>FROM php:8.4.27-apache

# System dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev libzip-dev libpng-dev libjpeg-dev \
    libfreetype6-dev zip unzip git && \
    rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install intl mysqli pdo_mysql zip gd

# Apache modules
RUN a2enmod rewrite headers

# Document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/apache2.conf

COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html/writable

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]</code></pre>
        </div>

        <div class="mt-5 p-3" style="background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.15); border-radius: 12px;">
            <i class="fa-solid fa-circle-info me-2" style="color: var(--landing-accent);"></i>
            <strong>Auto-Migration:</strong> The <code>entrypoint.sh</code> script waits for MySQL to accept connections (up to 30 retries), runs <code>php spark migrate --all</code> automatically, and then starts Apache. No manual migration step needed after the first build.
        </div>

        <h5 class="fw-semibold mt-5 mb-2">Non-Docker Deployment</h5>
        <p style="color: var(--landing-muted);">
            myCoder can also run directly on any Apache/Nginx server with PHP 8.3+ and MySQL 8.4. Clone the repo, run <code>composer install</code>, configure your <code>.env</code> file, point your web server's document root to the <code>public/</code> directory, and run <code>php spark migrate --all</code>. Docker is the recommended and tested deployment method.
        </p>

        <h5 class="fw-semibold mt-5 mb-2">Updating</h5>
        <p style="color: var(--landing-muted);">
            Pull the latest changes: <code>git pull</code>, rebuild images: <code>docker compose build --no-cache</code>, then restart: <code>docker compose up -d</code>. New database migrations run automatically via the entrypoint script.
        </p>
    </div>
</section>

<section class="section-dark text-center">
    <div class="container-custom">
        <h2 class="section-title">Ready to Deploy?</h2>
        <p class="section-subtitle" style="margin-bottom: 1.5rem;">Get your own instance running in minutes.</p>
        <?php if ($loggedIn): ?>
        <a href="<?= base_url('chat') ?>" class="btn btn-primary-landing btn-lg">
            <i class="fa-solid fa-comment me-2"></i>Go to Chat
        </a>
        <?php else: ?>
        <a href="<?= base_url('register') ?>" class="btn btn-primary-landing btn-lg me-2 mb-2">
            <i class="fa-solid fa-rocket me-2"></i>Create Free Account
        </a>
        <a href="<?= base_url('login') ?>" class="btn btn-outline-landing btn-lg mb-2">
            <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Sign In
        </a>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>
