<?php
$title = '502 - Bad Gateway';
include __DIR__ . '/_header.php';
?>

<div class="error-code">502</div>
<h3 class="fw-bold text-main">Bad Gateway</h3>

<p class="text-muted mt-3 mb-4 px-md-4">
    The server received an invalid response from an upstream server while processing the request. This usually indicates a temporary issue with a backend service. Please try again shortly.
</p>

<?php if (! empty($message) && $message !== '(null)') : ?>
    <div class="alert alert-warning bg-warning bg-opacity-10 border-0 text-warning rounded-3 text-start small mb-0">
        <i class="fa-solid fa-triangle-exclamation me-2"></i> <?= esc($message) ?>
    </div>
<?php endif ?>

<a href="<?= base_url() ?>" class="error-btn">
    <i class="fa-solid fa-rotate-right me-2"></i> Try Again
</a>

<?php include __DIR__ . '/_footer.php'; ?>
