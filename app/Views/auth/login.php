<?= $this->extend('auth/layout') ?>

<?= $this->section('card-header') ?>
<div class="logo-icon"><i class="fa-solid fa-right-to-bracket"></i></div>
<h4>Welcome Back</h4>
<p>Sign in to your account to continue</p>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<?php if (session('error') !== null) : ?>
    <div class="alert alert-danger alert-custom d-flex align-items-center gap-2">
        <i class="fa-solid fa-circle-exclamation"></i> <?= session('error') ?>
    </div>
<?php elseif (session('errors') !== null) : ?>
    <div class="alert alert-danger alert-custom">
        <?php if (is_array(session('errors'))) : ?>
            <?php foreach (session('errors') as $error) : ?>
                <div class="d-flex align-items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i> <?= $error ?></div>
            <?php endforeach ?>
        <?php else : ?>
            <div class="d-flex align-items-center gap-2"><i class="fa-solid fa-circle-exclamation"></i> <?= session('errors') ?></div>
        <?php endif ?>
    </div>
<?php endif ?>

<?php if (session('message') !== null) : ?>
    <div class="alert alert-success alert-custom d-flex align-items-center gap-2">
        <i class="fa-solid fa-check-circle"></i> <?= session('message') ?>
    </div>
<?php endif ?>

<form action="<?= url_to('login') ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="email" class="form-label form-label-custom">Email Address</label>
        <div class="input-group input-group-custom">
            <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
            <input type="email" class="form-control auth-input" id="email" name="email"
                   placeholder="name@example.com" required autocomplete="email">
        </div>
    </div>

    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <label for="password" class="form-label form-label-custom mb-0">Password</label>
            <a href="<?= url_to('magic-link') ?>" class="auth-link" style="font-size: 0.8rem;">Forgot?</a>
        </div>
        <div class="input-group input-group-custom">
            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
            <input type="password" class="form-control auth-input" id="password" name="password"
                   placeholder="Enter your password" required autocomplete="current-password">
        </div>
    </div>

    <div class="form-check mb-4">
        <input type="checkbox" class="form-check-input" id="remember" name="remember"
               style="border-color: var(--border-color); background-color: var(--input-bg);">
        <label class="form-check-label" for="remember" style="color: var(--text-muted); font-size: 0.85rem;">
            Keep me signed in for 30 days
        </label>
    </div>

    <button type="submit" class="auth-btn">
        <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Sign In
    </button>
</form>

<div class="auth-divider">
    <span>New to myCoder?</span>
</div>

<div class="text-center">
    <a href="<?= base_url('register') ?>" class="auth-link">
        Create an account <i class="fa-solid fa-arrow-right ms-1"></i>
    </a>
</div>

<?= $this->endSection() ?>
