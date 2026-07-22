<?php
$title = '500 - Server Error';
include __DIR__ . '/_header.php';
?>

<div class="error-code">5xx</div>
<h3 class="fw-bold text-main">Server Error</h3>

<p class="text-muted mt-3 mb-4 px-md-4">
    Something went wrong on our end. Our team has been notified, and we&rsquo;re working to fix the issue. Please try again later.
</p>

<?php if (! empty($message) && $message !== '(null)') : ?>
    <div class="alert alert-danger bg-danger bg-opacity-10 border-0 text-danger rounded-3 text-start small mb-0">
        <i class="fa-solid fa-bug me-2"></i> <?= esc($message) ?>
    </div>
<?php endif ?>

<a href="<?= base_url() ?>" class="error-btn">
    <i class="fa-solid fa-rotate-right me-2"></i> Try Again
</a>

<?php include __DIR__ . '/_footer.php'; ?>
