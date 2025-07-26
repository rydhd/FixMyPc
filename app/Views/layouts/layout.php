<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>

    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/auth.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/auth.rtl.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app.css') ?>">

    <link rel="shortcut icon" href="<?= base_url('assets/compiled/png/icon.png') ?>" type="image/x-icon">

</head>

<body>
<script src="<?= base_url('assets/static/js/initTheme.js') ?>"></script>
<div id="main-content">
    <?= $this->renderSection('main') ?>
</div>
</body>

</html>