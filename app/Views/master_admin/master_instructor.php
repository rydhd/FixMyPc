<?= $this->extend('layouts/master_admin_master') ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-md-12"> <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Instructor Management</h5>

                    <form action="/master/generate-code" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Generate New Access Code
                        </button>
                    </form>

                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                               aria-controls="home" aria-selected="true">Class List</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <?= $this->include('master_admin_partials/instructor_statistics_table') ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>