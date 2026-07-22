<?= $this->extend('auth/layout') ?>

<?= $this->section('card-header') ?>
<div class="logo-icon"><i class="fa-solid fa-key"></i></div>
<h4>Forgot Password?</h4>
<p>No worries — we'll send you reset instructions</p>
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

<form action="<?= url_to('magic-link') ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-4">
        <label for="email" class="form-label form-label-custom">Email Address</label>
        <div class="input-group input-group-custom">
            <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
            <input type="email" class="form-control auth-input" id="email" name="email"
                   placeholder="name@example.com" required autocomplete="email">
        </div>
    </div>

    <button type="submit" class="auth-btn">
        <i class="fa-solid fa-paper-plane me-2"></i>Send Reset Instructions
    </button>
</form>

<div class="auth-divider">
    <span>Remembered your password?</span>
</div>

<div class="text-center">
    <a href="<?= base_url('login') ?>" class="auth-link">
        <i class="fa-solid fa-arrow-left me-1"></i> Back to sign in
    </a>
</div>

<?= $this->endSection() ?>
