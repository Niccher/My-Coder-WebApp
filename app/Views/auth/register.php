<?= $this->extend('auth/layout') ?>

<?= $this->section('card-header') ?>
<div class="logo-icon"><i class="fa-solid fa-user-plus"></i></div>
<h4>Create Your Account</h4>
<p>Start orchestrating multiple AI models in minutes</p>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<?php if (session('error') !== null): ?>
    <div class="alert alert-danger alert-custom d-flex align-items-center gap-2">
        <i class="fa-solid fa-circle-exclamation"></i> <?= session('error') ?>
    </div>
<?php elseif (session('errors') !== null): ?>
    <div class="alert alert-danger alert-custom">
        <?php if (is_array(session('errors'))): ?>
            <?php foreach (session('errors') as $error): ?>
                <div class="d-flex align-items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i> <?= $error ?></div>
            <?php endforeach ?>
        <?php else: ?>
            <div class="d-flex align-items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i> <?= session('errors') ?></div>
        <?php endif ?>
    </div>
<?php endif ?>

<form action="<?= url_to('register') ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="username" class="form-label form-label-custom">Username</label>
        <div class="input-group input-group-custom">
            <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
            <input type="text" class="form-control auth-input" id="username" name="username"
                   placeholder="Choose a username" required autocomplete="username">
        </div>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label form-label-custom">Email Address</label>
        <div class="input-group input-group-custom">
            <span class="input-group-text"><i class="fa-solid fa-at"></i></span>
            <input type="email" class="form-control auth-input" id="email" name="email"
                   placeholder="name@example.com" required autocomplete="email">
        </div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label form-label-custom">Password</label>
        <div class="input-group input-group-custom">
            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
            <input type="password" class="form-control auth-input" id="password" name="password"
                   placeholder="Create a strong password" required autocomplete="new-password">
        </div>
    </div>

    <div class="mb-4">
        <label for="password_confirm" class="form-label form-label-custom">Confirm Password</label>
        <div class="input-group input-group-custom">
            <span class="input-group-text"><i class="fa-solid fa-shield-halved"></i></span>
            <input type="password" class="form-control auth-input" id="password_confirm" name="password_confirm"
                   placeholder="Repeat your password" required autocomplete="new-password">
        </div>
    </div>

    <button type="submit" class="auth-btn">
        <i class="fa-solid fa-rocket me-2"></i>Create Account
    </button>
</form>

<div class="auth-divider">
    <span>Already registered?</span>
</div>

<div class="text-center">
    <a href="<?= base_url('login') ?>" class="auth-link">
        Sign in to your account <i class="fa-solid fa-arrow-right ms-1"></i>
    </a>
</div>

<?= $this->endSection() ?>
