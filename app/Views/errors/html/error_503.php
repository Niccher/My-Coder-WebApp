<?php
$title = '503 - Service Unavailable';
include __DIR__ . '/_header.php';
?>

<div class="error-code">503</div>
<h3 class="fw-bold text-main">Service Unavailable</h3>

<p class="text-muted mt-3 mb-4 px-md-4">
    The server is temporarily unable to handle the request due to maintenance or capacity issues. Please wait a moment and try again.
</p>

<?php if (! empty($message) && $message !== '(null)') : ?>
    <div class="alert alert-info bg-info bg-opacity-10 border-0 text-info rounded-3 text-start small mb-0">
        <i class="fa-solid fa-circle-info me-2"></i> <?= esc($message) ?>
    </div>
<?php endif ?>

<a href="<?= base_url() ?>" class="error-btn">
    <i class="fa-solid fa-rotate-right me-2"></i> Refresh Page
</a>

<?php include __DIR__ . '/_footer.php'; ?>
