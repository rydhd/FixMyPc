<?= $this->extend('layouts/instructor_master') ?>

<?= $this->section('content') ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
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
        <div class="buttons">
            <form action="<?= site_url('instructor/students/delete-all') ?>" method="post" onsubmit="return confirm('DANGER: Are you absolutely sure you want to delete ALL of your students? This action is permanent and cannot be undone.');" style="display: inline;">
                <?= csrf_field() ?>
                <button type="submit" class="btn icon icon-left btn-danger">
                    <i class="bi bi-trash-fill"></i> Delete All Students
                </button>
            </form>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card">
                    <div class="card-body">

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

    <div class="modal fade text-left" id="addStudentModal" tabindex="-1" role="dialog"
         aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
             role="document"> <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addStudentModalLabel">Add New Student</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="<?= site_url('instructor/students/add') ?>" method="post" id="addStudentForm">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <p>Enter the details for the new student.</p>

                        <?php if (session()->getFlashdata('add_student_error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('add_student_error') ?>
                                <?php if (session()->getFlashdata('add_student_validation_errors')): ?>
                                    <ul class="mt-2 mb-0">
                                        <?php foreach (session()->getFlashdata('add_student_validation_errors') as $error): ?>
                                            <li><?= esc($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('add_student_message')): ?>
                            <div class="alert alert-success"><?= session()->getFlashdata('add_student_message') ?></div>
                        <?php endif; ?>

                        <label for="add_first_name">First Name: </label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="add_first_name" name="first_name" value="<?= old('first_name') ?>" placeholder="First Name" required>
                        </div>
                        <label for="add_middle_name">Middle Name (Optional): </label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="add_middle_name" name="middle_name" value="<?= old('middle_name') ?>" placeholder="Middle Name">
                        </div>
                        <label for="add_last_name">Last Name: </label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="add_last_name" name="last_name" value="<?= old('last_name') ?>" placeholder="Last Name" required>
                        </div>
                        <label for="add_section">Section: </label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="add_section" name="section" value="<?= old('section') ?>" placeholder="Section" required>
                        </div>
                        <label for="add_grade_level">Grade Level: </label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="add_grade_level" name="grade_level" value="<?= old('grade_level') ?>" placeholder="Grade Level" required>
                        </div>
                        <label for="add_password">Password: </label>
                        <div class="form-group">
                            <input type="password" class="form-control" id="add_password" name="password" placeholder="Password">
                        </div>
                        <label for="add_password_confirm">Confirm Password: </label>
                        <div class="form-group">
                            <input type="password" class="form-control" id="add_password_confirm" name="password_confirm" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" form="addStudentForm" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Add Student</span>
                        </button>
                    </div>
                </form>
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
        $(document).ready(function() {

            // 1. Initialize the DataTable
            var studentTable = $('#table2').DataTable();

            // 2. Replace the default dropdown with our custom section filter
            var customFilter = $('#custom-filter-container').html();
            $('div.dataTables_length').html(customFilter);

            // 3. THE FIX: Update listener to filter by the SECTION column (index 4)
            $('.card-body').on('change', '#section-select-filter', function() {
                var section = $(this).val();

                // Search the 5th column (index 4) for an exact match
                studentTable.column(4).search(section).draw();
            });

            // 4. Your existing modal scripts...
        });
    </script>
<?= $this->endSection() ?>