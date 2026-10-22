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
            <li>Ports <code>80</code> (app), <code>3306</code> (MySQL), and <code>8080</code> (Dozzle Log Viewer) available on your host.</li>
            <li>Minimum 1 GB RAM (2 GB recommended for parallel API requests).</li>
        </ul>

        <h5 class="fw-semibold mt-5 mb-2">Quick Start</h5>
        <div class="docker-block">
            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-clipboard me-1"></i>Copy</button>
            <pre><code># 1. Clone the repository
git clone https://github.com/Niccher/My-Coder-WebApp.git
cd My-Coder-WebApp

# 2. Run automated 13-stage deployment pipeline
bash scripts/deploy.sh

# 3. Open in your browser
echo "Open http://localhost"</code></pre>
        </div>

        <h5 class="fw-semibold mt-5 mb-2">Automated One-Click Deployment</h5>
        <p style="color: var(--landing-muted);">
            myCoder includes a hardened, 13-stage deployment pipeline script that automates hardware checks, dynamic IP discovery, container orchestration, permission provisioning, and database migrations:
        </p>
        <div class="docker-block">
            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-clipboard me-1"></i>Copy</button>
            <pre><code># 1. Clone the repository
git clone https://github.com/Niccher/My-Coder-WebApp.git
cd My-Coder-WebApp

# 2. Run automated 13-stage deployment pipeline
bash scripts/deploy.sh

# 3. Access your services:
#    - Web Application         : http://localhost (or your server's public IP)
#    - Dozzle Live Log Viewer  : http://localhost:8080
#    - MySQL Database Port     : localhost:3306</code></pre>
        </div>

        <h5 class="fw-semibold mt-5 mb-2">13-Stage Deployment Pipeline Overview</h5>
        <p style="color: var(--landing-muted);">
            When you run <code>bash scripts/deploy.sh</code>, the pipeline executes the following stages sequentially with strict error handling and real-time validation:
        </p>
        <div class="pipeline-list">
            <div class="pipeline-item"><div class="pipeline-num">1</div><span><strong>Dynamic Host IP Resolution</strong> (WAN/LAN fallback)</span></div>
            <div class="pipeline-item"><div class="pipeline-num">2</div><span><strong>Pre-flight Resource Checks</strong> (OS, CPU, RAM, Disk)</span></div>
            <div class="pipeline-item"><div class="pipeline-num">3</div><span><strong>Git Working Tree Sanity</strong> (branch &amp; commit hash)</span></div>
            <div class="pipeline-item"><div class="pipeline-num">4</div><span><strong>Environment Sync (.env)</strong> (baseURL &amp; AES-256 keys)</span></div>
            <div class="pipeline-item"><div class="pipeline-num">5</div><span><strong>Conflict Cleanup</strong> (orphaned networks &amp; containers)</span></div>
            <div class="pipeline-item"><div class="pipeline-num">6</div><span><strong>Building &amp; Starting Services</strong> (MySQL, App, Dozzle)</span></div>
            <div class="pipeline-item"><div class="pipeline-num">7</div><span><strong>Storage Permissions</strong> (777 on <code>writable/</code> storage)</span></div>
            <div class="pipeline-item"><div class="pipeline-num">8</div><span><strong>MySQL TCP Query Readiness</strong> (:3306 probe)</span></div>
            <div class="pipeline-item"><div class="pipeline-num">9</div><span><strong>Database Migrations</strong> (<code>spark migrate --all</code>)</span></div>
            <div class="pipeline-item"><div class="pipeline-num">10</div><span><strong>Dozzle Viewer Verification</strong> (:8080 probe)</span></div>
            <div class="pipeline-item"><div class="pipeline-num">11</div><span><strong>WebApp Readiness Probe</strong> (:80 HTTP verification)</span></div>
            <div class="pipeline-item"><div class="pipeline-num">12</div><span><strong>Docker Cache Pruning</strong> (clean dangling images)</span></div>
            <div class="pipeline-item"><div class="pipeline-num">13</div><span><strong>Execution Timeline &amp; Summary</strong> (per-stage latency)</span></div>
        </div>

        <h5 class="fw-semibold mt-5 mb-2">Containerized Services &amp; Supporting Architecture</h5>
        <p style="color: var(--landing-muted);">
            The stack runs three dedicated containers on an isolated Docker bridge network (<code>hosts-shared-network</code>), providing high cohesion, process isolation, and zero host contamination:
        </p>
        <div class="arch-grid">
            <div class="arch-card">
                <span class="arch-port">:80</span>
                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;"><i class="fa-solid fa-server" style="color: #3b82f6;"></i></div>
                <h6 style="font-weight: 600;">myCoder WebApp</h6>
                <span class="badge-service mb-2"><i class="fa-brands fa-php"></i> PHP 8.4.27 &bull; Apache 2.4</span>
                <p style="font-size: 0.85rem; color: var(--landing-muted);">
                    The primary application engine. Configured with Apache <code>DocumentRoot /var/www/html/public</code>, OPcache, and CodeIgniter 4.6.4. Features dynamic permissions self-healing on <code>writable/</code> (session, cache, logs, debugbar, uploads) and non-blocking parallel HTTP orchestration.
                </p>
            </div>
            <div class="arch-card">
                <span class="arch-port">:3306</span>
                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;"><i class="fa-solid fa-database" style="color: #f39c12;"></i></div>
                <h6 style="font-weight: 600;">MySQL 8.4 LTS</h6>
                <span class="badge-service mb-2"><i class="fa-solid fa-hard-drive"></i> MySQL 8.4 &bull; Volume: mysql-data</span>
                <p style="font-size: 0.85rem; color: var(--landing-muted);">
                    Enterprise relational database engine. Persists conversations, personas, folders, and encrypted API keys. Protected by a TCP query healthcheck (<code>127.0.0.1:3306</code>) that guarantees table readiness before web traffic is accepted.
                </p>
            </div>
            <div class="arch-card">
                <span class="arch-port">:8080</span>
                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;"><i class="fa-solid fa-terminal" style="color: #22c55e;"></i></div>
                <h6 style="font-weight: 600;">Dozzle Log Viewer</h6>
                <span class="badge-service mb-2"><i class="fa-brands fa-docker"></i> amir20/dozzle:latest &bull; Port 8080</span>
                <p style="font-size: 0.85rem; color: var(--landing-muted);">
                    Lightweight real-time container log viewer and resource monitor. Streams Apache access/error logs, PHP exceptions, and MySQL operational logs directly to your browser via a read-only Docker socket integration.
                </p>
            </div>
        </div>

        <h5 class="fw-semibold mt-5 mb-2">Environment Configuration (.env)</h5>
        <p style="color: var(--landing-muted);">The <code>.env</code> file governs database, encryption, and network configurations:</p>
        <div class="docker-block">
            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-clipboard me-1"></i>Copy</button>
            <pre><code># .env Production Configuration
CI_ENVIRONMENT = production

# App Settings — auto-synced by deploy.sh with resolved host IP
app.baseURL = 'http://localhost/'
app.forceGlobalSecureRequests = false

# Database Settings — points to the internal 'mysql' container
database.default.hostname = mysql
database.default.database = db_my_coder
database.default.username = root
database.default.password = root_password
database.default.DBDriver = MySQLi
database.default.port = 3306

# 256-Bit AES Encryption Key for API key security at rest
encryption.key = hex2bin:your-32-byte-hex-key-here

# Email Registration Toggle (set to false for private/local nodes)
AUTH_SEND_EMAIL_ON_REGISTER = false</code></pre>
        </div>

        <h5 class="fw-semibold mt-5 mb-2">Hardened Docker Compose Specification</h5>
        <p style="color: var(--landing-muted);">The complete <code>docker-compose.yml</code> orchestrates the three services on <code>hosts-shared-network</code>:</p>
        <div class="docker-block">
            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-clipboard me-1"></i>Copy</button>
            <pre><code>services:
  mysql:
    image: mysql:8.4
    container_name: shared-mysql
    ports:
      - "3306:3306"
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: db_my_coder
    command: --sql-mode="STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION"
    healthcheck:
      test: ["CMD-SHELL", "mysqladmin ping -h 127.0.0.1 -u root -proot_password && mysql -h 127.0.0.1 -u root -proot_password -e 'SELECT 1;' db_my_coder >/dev/null 2>&1"]
      interval: 5s
      timeout: 5s
      retries: 20
      start_period: 15s
    volumes:
      - mysql-data:/var/lib/mysql
    networks:
      - shared-network

  dozzle:
    image: amir20/dozzle:latest
    container_name: shared-dozzle
    restart: unless-stopped
    ports:
      - "8080:8080"
    volumes:
      - /var/run/docker.sock:/var/run/docker.sock:ro
    networks:
      - shared-network

  my-coder:
    build:
      context: .
      dockerfile: Dockerfile
    image: my-coder-webapp:latest
    container_name: my-coder-webapp
    ports:
      - "80:80"
    environment:
      - DB_HOST=mysql
      - DB_PORT=3306
      - DB_USER=root
      - DB_PASSWORD=root_password
      - DB_DATABASE=db_my_coder
      - database.default.hostname=mysql
      - database.default.database=db_my_coder
      - database.default.username=root
      - database.default.password=root_password
      - database.default.port=3306
      - database.default.DBDriver=MySQLi
    volumes:
      - .:/var/www/html
    depends_on:
      mysql:
        condition: service_healthy
    networks:
      - shared-network

volumes:
  mysql-data:

networks:
  shared-network:
    name: hosts-shared-network</code></pre>
        </div>

        <h5 class="fw-semibold mt-5 mb-2">Application Dockerfile (PHP 8.4.27)</h5>
        <p style="color: var(--landing-muted);">The web application container is built with high-performance PHP 8.4 on Apache:</p>
        <div class="docker-block">
            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-clipboard me-1"></i>Copy</button>
            <pre><code>FROM php:8.4.27-apache

# System dependencies & build packages
RUN apt-get update && apt-get install -y --no-install-recommends \
    libicu-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev zip unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) intl mysqli pdo_mysql zip gd

# Enable Apache rewrite & security headers
RUN a2enmod rewrite headers

# Re-route Apache DocumentRoot to CodeIgniter public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf

WORKDIR /var/www/html
COPY . /var/www/html

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
EXPOSE 80</code></pre>
        </div>

        <div class="mt-5 p-3" style="background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.15); border-radius: 12px;">
            <i class="fa-solid fa-circle-check me-2" style="color: var(--landing-accent);"></i>
            <strong>Zero-Touch Auto-Provisioning:</strong> The <code>entrypoint.sh</code> script dynamically tests database connectivity on port 3306, runs <code>php spark migrate --all</code>, ensures <code>777</code> permissions across all storage directories (<code>cache</code>, <code>session</code>, <code>logs</code>, <code>debugbar</code>, <code>uploads</code>), and launches Apache.
        </div>

        <h5 class="fw-semibold mt-5 mb-2">Zero-Downtime Maintenance &amp; Updates</h5>
        <p style="color: var(--landing-muted);">
            To upgrade your deployment when new releases are pushed to GitHub:
        </p>
        <div class="docker-block">
            <button class="copy-btn" onclick="copyCode(this)"><i class="fa-regular fa-clipboard me-1"></i>Copy</button>
            <pre><code># Pull latest changes & re-run deployment pipeline
git pull origin master
bash scripts/deploy.sh</code></pre>
        </div>
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
