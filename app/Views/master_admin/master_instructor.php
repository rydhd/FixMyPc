<?= $this->extend('layouts/master_admin_master') ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center rounded-bottom-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateCodeModal">
                        <i class="fas fa-plus"></i> Generate New Access Code
                    </button>
                </div>
                <div class="card-body rounded-top-0">
                    <div class="tab-content pt-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <?= $this->include('master_admin_partials/instructor_statistics_table') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->include('master_admin_partials/_generate_code_modal') ?>
<?= $this->endSection() ?>