<?= $this->extend('landing/layout') ?>

<?= $this->section('head') ?>
<style>
.faq-page-hero {
    text-align: center;
    padding: 8rem 1.5rem 2rem;
}
.faq-page-hero h1 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; }
.faq-page-hero p { color: var(--landing-muted); font-size: 1.1rem; max-width: 640px; margin: 0.5rem auto 0; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="faq-page-hero">
    <h1>Frequently Asked <span class="gradient-text">Questions</span></h1>
    <p>Everything you need to know about deploying and using myCoder.</p>
</div>

<section>
    <div class="container-custom" style="max-width: 780px; margin: 0 auto;">
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>What is myCoder?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>myCoder is a self-hosted, multi-model AI orchestration platform. You send one prompt and it queries up to 6 AI models in parallel (Gemini, DeepSeek, Grok, OpenAI, Kimi, MiniMax, Groq, OpenRouter). An optional Master Model then evaluates all responses and synthesizes the best answer. It's built with PHP 8.4.27 and CodeIgniter 4.6.4, backed by MySQL 8.4 LTS and Dozzle log monitoring, and runs entirely on your own infrastructure via Docker.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>What supporting containers run alongside the WebApp?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>myCoder orchestrates three specialized containers on an isolated Docker bridge network (<code>hosts-shared-network</code>):</p>
                <ul style="margin: 0.5rem 0 0.5rem 1.25rem; color: var(--landing-muted); font-size: 0.95rem; line-height: 1.6;">
                    <li><strong><code>my-coder-webapp</code> (:80)</strong>: Apache HTTP server running PHP 8.4.27, handling the CodeIgniter 4 framework, sessions, frontend views, and non-blocking parallel cURL dispatches.</li>
                    <li><strong><code>shared-mysql</code> (:3306)</strong>: Official MySQL 8.4 LTS image configured with persistent volume storage (<code>mysql-data</code>), utf8mb4 collation, and automated TCP socket health checking.</li>
                    <li><strong><code>shared-dozzle</code> (:8080)</strong>: Lightweight real-time log viewer connected to the host Docker daemon socket (read-only), allowing you to tail container stdout/stderr live from any browser without SSH.</li>
                </ul>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>How do I monitor application and container logs?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>You can access real-time logs via Dozzle at <code>http://&lt;your-server-ip&gt;:8080</code>. Dozzle streams logs directly from all three running containers with live search, filtering, and memory/CPU usage indicators. Alternatively, from the terminal you can run <code>docker compose logs -f [service_name]</code>.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>How does the 13-stage deployment script (<code>deploy.sh</code>) work?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>The included <code>./scripts/deploy.sh</code> script provides an automated, idempotent production deployment pipeline that runs 13 sequential phases:</p>
                <ol style="margin: 0.5rem 0 0.5rem 1.25rem; color: var(--landing-muted); font-size: 0.95rem; line-height: 1.6;">
                    <li>Detects the host public/private IP addresses to configure <code>app.baseURL</code>.</li>
                    <li>Checks system resources (ensures &ge; 1 GB RAM and sufficient disk space).</li>
                    <li>Validates the Git repository and remote tracking branch.</li>
                    <li>Synchronizes <code>.env</code> settings with sane production defaults.</li>
                    <li>Safely tears down previous container iterations.</li>
                    <li>Builds the PHP 8.4 image and launches containers in detached mode.</li>
                    <li>Pre-configures <code>writable/</code> directory permissions for session and cache stability.</li>
                    <li>Probes MySQL container health and tests TCP query readiness.</li>
                    <li>Executes automated database migrations via <code>php spark migrate --all</code>.</li>
                    <li>Verifies Dozzle log viewer readiness on port 8080.</li>
                    <li>Probes the WebApp HTTP endpoint on port 80 for HTTP 200/302 response.</li>
                    <li>Prunes dangling Docker builder cache and unused images to preserve disk space.</li>
                    <li>Prints an operational summary with clickable endpoints for the WebApp and Dozzle.</li>
                </ol>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>How do I get API keys for the models?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>You need to register for API access at each provider directly: <a href="https://makersuite.google.com/app/apikey" target="_blank">Google AI Studio</a> (Gemini), <a href="https://platform.openai.com/api-keys" target="_blank">OpenAI</a>, <a href="https://console.groq.com/keys" target="_blank">Groq</a>, <a href="https://openrouter.ai/keys" target="_blank">OpenRouter</a>, <a href="https://console.x.ai" target="_blank">xAI Console</a> (Grok), etc. Once obtained, add them securely in the myCoder settings panel — they are encrypted at rest using AES-256-CTR.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>Is myCoder free and open source?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Yes! myCoder is released under the MIT License. You can self-host it at no cost. The only costs are the API usage fees charged by your chosen AI providers. There are no subscription fees for the platform itself.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>Do I need to use all 8 providers?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Not at all. You can configure as few or as many models as you like across the 6 regular slots. If you only want to use one model, that works too. The Master Model (slot 7) is optional — disable it if you just want to see all raw responses side by side.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>How are my API keys stored?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>API keys are encrypted at rest in the database using CodeIgniter's encryption library (OpenSSL, AES-256-CTR mode). The encryption key is configured in your <code>.env</code> file. Keys are decrypted in memory only at request time and never logged or exposed.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>What are the minimum requirements to run myCoder?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>You need a Linux server (or any host with Docker) with at least 1 GB RAM (2 GB recommended) and Docker Engine 24+ with Docker Compose v2+. The application runs on PHP 8.4 with Apache inside the container.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>Can I use myCoder without Docker?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Yes. Since myCoder is a standard PHP application, you can deploy it directly on any Apache/Nginx server with PHP 8.4+ and MySQL 8.4. Clone the repo, run <code>composer install</code>, configure your <code>.env</code> file, point your web server's document root to the <code>public/</code> directory, and run <code>php spark migrate --all</code>. However, Docker is the recommended and tested deployment method.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>How do I update myCoder to the latest version?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Simply run <code>git pull</code> followed by <code>./scripts/deploy.sh</code>. The deployment script will safely re-build images, restart containers, probe database readiness, and apply any new database schema migrations automatically.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>What happens to my data if I restart the containers?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>All persistent data (conversations, user accounts, API keys, personas, folders) is stored in MySQL with a named Docker volume (<code>mysql-data</code>). Restarting or rebuilding containers will not affect your data as long as the volume is not removed. Sessions are stored on the application container's writable directory and will reset on restart, requiring re-login.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this)">
                <span>Can I contribute to myCoder?</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Absolutely! myCoder is open source under the MIT License. Contributions are welcome. Check the <code>CONTRIBUTING.md</code> file in the repository for coding standards (PHP CS Fixer), testing (PHPUnit), and pull request guidelines.</p>
            </div>
        </div>
    </div>
</section>

<section class="section-dark text-center">
    <div class="container-custom">
        <h2 class="section-title">Still Have Questions?</h2>
        <p class="section-subtitle" style="margin-bottom: 1.5rem;">Get started and explore the app, or sign in to your account.</p>
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
