<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?? 'Admin Dashboard' ?></title>

    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/table-datatable-jquery.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app-dark.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/iconly.css') ?>">
    <link rel="stylesheet" href="<?=base_url('assets/extensions/filepond/filepond.css')?>">

    <link rel="shortcut icon" href="<?= base_url('assets/compiled/png/icon.png') ?>" type="image/x-icon">
</head>

<body>
<script src="<?= base_url('assets/static/js/initTheme.js') ?>"></script>
<div id="app">

    <?= $this->include('instructor_partials/sidebar') ?>

    <div id="main">
        <header class='mb-3'>
            <nav class="navbar navbar-expand navbar-light ">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown me-3">
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <?= $this->renderSection('content') ?>
    </div>
</div>
<script src="<?= base_url('assets/extensions/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') ?>"></script>
<script src="<?= base_url('assets/static/js/pages/datatables.js') ?>"></script>

<script src="<?= base_url('assets/static/js/components/dark.js') ?>"></script>
<script src="<?= base_url('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
<script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>
<script src="<?= base_url('assets/static/js/components/dark.js') ?>"></script>
<script src="<?= base_url('assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
<script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>

<script src="<?= base_url('assets/vendors/apexcharts/apexcharts.js') ?>"></script>
<script src="<?= base_url('assets/extensions/apexcharts/apexcharts.min.js') ?>"></script>
<script src="<?= base_url('assets/static/js/pages/dashboard.js') ?>"></script>

<script src="<?= base_url('assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') ?>"></script>
<script src="<?= base_url('assets/extensions/filepond/filepond.js') ?>"></script>
<script src="<?= base_url('assets/extensions/toastify-js/src/toastify.js') ?>"></script>
<script src="<?= base_url('assets/static/js/pages/filepond.js') ?>"></script><?= $this->renderSection('scripts') ?>
<script src="<?= base_url('assets/extensions/feather-icons/feather.min.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</body>

</html>