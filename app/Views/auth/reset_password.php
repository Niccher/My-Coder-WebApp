<?= $this->extend('auth/layout') ?>

<?= $this->section('card-header') ?>
<div class="logo-icon"><i class="fa-solid fa-rotate-right"></i></div>
<h4>Set New Password</h4>
<p>Must be different from previously used passwords</p>
<?= $this->endSection() ?>

<?= $this->section('main') ?>

<form action="<?= base_url('reset') ?>" method="post">
    <?= csrf_field() ?>

    <input type="hidden" name="token" value="<?= isset($token) ? $token : '' ?>">

    <div class="mb-3">
        <label for="password" class="form-label form-label-custom">New Password</label>
        <div class="input-group input-group-custom">
            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
            <input type="password" class="form-control auth-input" id="password" name="password"
                   placeholder="Must be at least 8 characters" required autocomplete="new-password">
        </div>
    </div>

    <div class="mb-4">
        <label for="password_confirm" class="form-label form-label-custom">Confirm Password</label>
        <div class="input-group input-group-custom">
            <span class="input-group-text"><i class="fa-solid fa-check"></i></span>
            <input type="password" class="form-control auth-input" id="password_confirm" name="password_confirm"
                   placeholder="Repeat your new password" required autocomplete="new-password">
        </div>
    </div>

    <button type="submit" class="auth-btn">
        <i class="fa-solid fa-check me-2"></i>Reset Password
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
