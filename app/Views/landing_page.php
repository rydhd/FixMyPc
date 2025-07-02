<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to StatDash</title>

    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/compiled/css/app-dark.css') ?>">

    <link rel="shortcut icon" href="<?= base_url('assets/compiled/svg/favicon.svg') ?>" type="image/x-icon">

    <style>
        #landing-page {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    </style>
</head>

<body>
<script src="<?= base_url('assets/static/js/initTheme.js') ?>"></script>
<div id="app">
    <div id="landing-page">
        <div>
            <img src="<?= base_url('assets/compiled/svg/favicon.svg') ?>" alt="Logo" class="mb-4" style="width: 70px; height: 70px;">

            <h1 class="fs-1 fw-bold">Welcome to StatDash</h1>
            <p class="fs-5 mb-5">Your application's journey starts here. Please log in to continue or register for a new account.</p>

            <div>
                <a href="<?= site_url('login') ?>" class="btn btn-primary btn-lg px-4 me-2">Log In</a>
                <a href="<?= site_url('register') ?>" class="btn btn-success btn-lg px-4">Register</a>
            </div>

        </div>
    </div>
</div>

<script src="<?= base_url('assets/static/js/components/dark.js') ?>"></script>
<script src="<?= base_url('assets/compiled/js/app.js') ?>"></script>

</body>
</html>