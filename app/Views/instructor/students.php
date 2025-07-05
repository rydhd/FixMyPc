<?= $this->extend('layouts/instructor_master') ?>

<?= $this->section('content') ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="buttons">
            <button type="button" class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#uploadClassListModal">
                + Class List
            </button>
        </div>
        <div class="buttons">
            <form action="<?= site_url('instructor/students/delete-all') ?>" method="post" onsubmit="return confirm('DANGER: Are you absolutely sure you want to delete ALL of your students? This action is permanent and cannot be undone.');" style="display: inline;">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-danger rounded-pill">
                    <i class="bi bi-trash-fill"></i> Delete All Students
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                               aria-controls="home" aria-selected="true">Class List</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                               aria-controls="profile" aria-selected="false">Statistics</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <?= $this->include('instructor_partials/student_table') ?>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <?= $this->include('instructor_partials/statistics_table') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="uploadClassListModal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
             role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Upload Class List</h4>
                    <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Upload an Excel file (.xlsx) with your student information. The first row should be headers and will be skipped.</p>

                    <div class="alert alert-info">
                        <strong>Column Order:</strong> `Last Name`, `First Name`, `Middle Name`, `Section`, `Grade Level`, `Student Code`, `Password`
                    </div>

                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                            <?php if (session()->getFlashdata('validation_errors')): ?>
                                <ul class="mt-2 mb-0">
                                    <?php foreach (session()->getFlashdata('validation_errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('/instructor/classlist/upload') ?>" method="post" enctype="multipart/form-data" id="uploadForm">
                        <?= csrf_field() ?>
                        <div class="mt-3">
                            <label for="classlist_file" class="form-label">Select .xlsx file</label>
                            <input class="form-control" type="file" name="classlist_file" id="classlist_file" accept=".xlsx" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary"
                            data-bs-dismiss="modal">
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" form="uploadForm" class="btn btn-primary ms-1">
                        <span class="d-none d-sm-block">Upload and Add Students</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('styles') ?>
    <style>
        /* Optional: Custom styles for better spacing or appearance can go here */
    </style>
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // This part is important: If there was a form error on the previous page
            // (e.g., failed validation), the modal needs to re-open to show the error message.
            <?php if (session()->getFlashdata('error')): ?>
            var errorModal = new bootstrap.Modal(document.getElementById('uploadClassListModal'), {
                keyboard: false
            });
            errorModal.show();
            <?php endif; ?>
        });
    </script>
<?= $this->endSection() ?>