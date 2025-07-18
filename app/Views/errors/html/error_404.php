<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('Errors.pageNotFound') ?></title>

    <link rel="shortcut icon" href="<?= base_url('assets/compiled/svg/favicon.svg') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/error.css') ?>">
</head>

<body>
<script src="<?= base_url('assets/static/js/initTheme.js') ?>"></script>
<div id="error">
    <div class="error-page container">
        <div class="col-md-8 col-12 offset-md-2">
            <div class="text-center">
                <img class="img-error" src="<?= base_url('assets/compiled/svg/error-404.svg') ?>" alt="Not Found">
                <h1 class="error-title">NOT FOUND</h1>

                <p class='fs-5 text-gray-600'>
                    <?php if (ENVIRONMENT !== 'production') : ?>
                        <?= nl2br(esc($message)) ?>
                    <?php else : ?>
                        <?= lang('Errors.sorryCannotFind') ?>
                    <?php endif; ?>
                </p>

                <a href="<?= site_url('/') ?>" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
            </div>
        </div>
    </div>
</div>
</body>

</html>