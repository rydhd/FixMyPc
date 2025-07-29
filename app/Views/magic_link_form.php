<?= $this->extend(config('Auth')->views['layout']) ?>

<?= $this->section('title') ?><?= lang('Auth.useMagicLink') ?> <?= $this->endSection() ?>

<?= $this->section('main') ?>

<div id="auth">
    <div class="row h-100">
        <div class="col-lg-5 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    <a href="/"><img src="<?= base_url('assets/compiled/png/Logo.png') ?>" alt="Logo"></a>
                </div>
                <h1 class="auth-title"><?= lang('Auth.forgotPassword') ?></h1>
                <p class="auth-subtitle mb-5"><?= lang('Input your email and we will send you reset password link.') ?></p>

                <?php if (session('message') !== null) : ?>
                    <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                <?php endif ?>

                <?php if (session('error') !== null) : ?>
                    <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                <?php elseif (session('errors') !== null) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php if (is_array(session('errors'))) : ?>
                            <?php foreach (session('errors') as $error) : ?>
                                <?= $error ?>
                                <br>
                            <?php endforeach ?>
                        <?php else : ?>
                            <?= session('errors') ?>
                        <?php endif ?>
                    </div>
                <?php endif ?>

                <form action="<?= url_to('magic-link') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" class="form-control form-control-xl" name="email" inputmode="email" autocomplete="email" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>" required>
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5"><?= lang('Auth.send') ?></button>
                </form>

                <div class="text-center mt-5 text-lg fs-4">
                    <p class="text-gray-600"><?= lang('Remember your account? ') ?> <a href="<?= url_to('login') ?>" class="font-bold"><?= lang('Auth.login') ?></a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
            <div id="auth-right-forgot">

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
