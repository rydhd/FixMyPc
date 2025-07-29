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
                    <h1 class="auth-title"><?= lang('Auth.checkYourEmail') ?></h1>
                    <p class="auth-subtitle mb-5"><?= lang('Auth.magicLinkDetails', [setting('Auth.magicLinkLifetime') / 60]) ?></p>

                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">
                            <a href="<?= url_to('login') ?>" class="font-bold"><?= lang('Auth.backToLogin') ?></a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right-magic">
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>