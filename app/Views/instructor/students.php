<?= $this->extend('layouts/instructor_master') ?>

<?= $this->section('content') ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Class List</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Statistics</a></li>
        </ul>
        <div class="buttons">
            <button type="button" class="btn icon icon-left btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAllStudentsModal">
                <i class="bi bi-trash-fill"></i> Delete All Students
            </button>
        </div>
    </div>

        <div class="card-body rounded-4">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <?= $this->include('instructor_partials/student_table') ?>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <?= $this->include('instructor_partials/statistics_table') ?>
                </div>
            </div>
        </div>

    <div class="modal fade" id="deleteAllStudentsModal" tabindex="-1" aria-labelledby="deleteAllStudentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="deleteAllStudentsModalLabel">DANGER: Confirm Deletion of ALL Students</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
                </div>
                <div class="modal-body">
                    <p class="fs-5 text-dark">Are you absolutely sure you want to delete every student in your class list?</p>
                    <p class="text-danger"><strong>This action is permanent and cannot be undone.</strong> All student data will be lost.</p>
                </div>
                <div class="modal-footer">
                    <form action="<?= site_url('instructor/students/delete-all') ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger ms-1">Yes, Delete All</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade text-left" id="uploadClassListModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title" id="myModalLabel17">Upload Class List</h4><button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button></div>
                <div class="modal-body">
                    <p>Upload an Excel file (.xlsx or .xls) with your student information. The first row should be headers and will be skipped.</p>
                    <div class="alert alert-info"><strong>Column Order:</strong> `Last Name`, `First Name`, `Middle Name`, `Section`, `Grade Level`, `Student Code`, `Password`</div>
                    <form action="<?= site_url('/instructor/classlist/upload') ?>" method="post" enctype="multipart/form-data" id="uploadForm">
                        <?= csrf_field() ?>
                        <div class="mt-3"><label for="classlist_file" class="form-label">Select Excel file</label><input class="form-control" type="file" name="classlist_file" id="classlist_file" accept=".xlsx,.xls" required></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="uploadForm" class="btn btn-primary ms-1">Upload and Add Students</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title" id="addStudentModalLabel">Add New Student</h5><button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button></div>
                <form action="<?= site_url('instructor/students/create') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="form-group"><label for="add_first_name">First Name</label><input type="text" id="add_first_name" name="first_name" class="form-control" required></div>
                        <div class="form-group"><label for="add_last_name">Last Name</label><input type="text" id="add_last_name" name="last_name" class="form-control" required></div>
                        <div class="form-group"><label for="add_middle_name">Middle Name</label><input type="text" id="add_middle_name" name="middle_name" class="form-control"></div>
                        <div class="form-group"><label for="add_grade_level">Grade Level</label><input type="text" id="add_grade_level" name="grade_level" class="form-control"></div>
                        <div class="form-group">
                            <label for="add_section">Section</label>
                            <select id="add_section" name="section" class="form-select" required>
                                <option value="" disabled selected>Select a Section</option>
                                <?php if (!empty($sections)) : ?>
                                    <?php foreach ($sections as $section) : ?>
                                        <option value="<?= esc($section) ?>"><?= esc($section) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group"><label for="add_password">Password</label><input type="password" id="add_password" name="password" class="form-control" autocomplete="new-password"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary ms-1">Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1150">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white"><strong class="me-auto"><i class="bi bi-check-circle-fill"></i> Success</strong><button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button></div>
            <div class="toast-body" id="successToastBody"></div>
        </div>
        <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white"><strong class="me-auto"><i class="bi bi-exclamation-triangle-fill"></i> Error</strong><button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button></div>
            <div class="toast-body" id="errorToastBody"></div>
        </div>
    </div>

    <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger"><h5 class="modal-title text-white" id="deleteStudentModalLabel">Confirm Deletion</h5><button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button></div>
                <div class="modal-body">Are you sure you want to delete this student? This action cannot be undone.</div>
                <div class="modal-footer">
                    <form id="modalDeleteForm" action="" method="post" style="display: inline;"><?= csrf_field() ?><button type="submit" class="btn btn-danger ms-1">Yes, Delete</button></form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title" id="editStudentModalLabel">Edit Student Details</h5><button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button></div>
                <form id="editStudentForm" action="" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="form-group"><label for="edit_first_name">First Name</label><input type="text" id="edit_first_name" name="first_name" class="form-control" required></div>
                        <div class="form-group"><label for="edit_last_name">Last Name</label><input type="text" id="edit_last_name" name="last_name" class="form-control" required></div>
                        <div class="form-group"><label for="edit_middle_name">Middle Name</label><input type="text" id="edit_middle_name" name="middle_name" class="form-control"></div>
                        <div class="form-group"><label for="edit_grade_level">Grade Level</label><input type="text" id="edit_grade_level" name="grade_level" class="form-control"></div>
                        <div class="form-group">
                            <label for="edit_section">Section</label>
                            <select id="edit_section" name="section" class="form-select" required>
                                <option value="" disabled>Select a Section</option>
                                <?php if (!empty($sections)) : ?>
                                    <?php foreach ($sections as $section) : ?>
                                        <option value="<?= esc($section) ?>"><?= esc($section) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group"><label for="edit_code">Student Code</label><input type="text" id="edit_code" name="code" class="form-control"></div>
                        <hr><p class="text-muted small">Leave password blank to keep it unchanged.</p>
                        <div class="form-group"><label for="edit_password">New Password</label><input type="password" id="edit_password" name="password" class="form-control" autocomplete="new-password"></div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary ms-1" form="editStudentForm">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php // This PHP 'if' statement prevents the script from running if there are no students ?>
<?php if (!empty($students)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- DataTable Logic ---
            var studentTable = $('#table2').DataTable({
                "retrieve": true,
            });

            // Moves the filter dropdown into the DataTable's controls
            var customFilter = $('#custom-filter-container').html();
            if (customFilter && !$('div.dataTables_length').find('#section-select-filter').length) {
                $('div.dataTables_length').html(customFilter);
            }

            $('.card-body').on('change', '#section-select-filter', function() {
                var section = $(this).val();
                studentTable.column(4).search(section ? '^' + section + '$' : '', true, false).draw();
            });

            // Redraws icons on table changes
            studentTable.on('draw.dt', function () {
                feather.replace();
            });

            // --- Toast Notification Logic ---
            const successMessage = "<?= session()->getFlashdata('toast_success') ?>";
            if (successMessage) {
                $('#successToastBody').text(successMessage);
                new bootstrap.Toast(document.getElementById('successToast')).show();
            }

            // --- Delete Modal Logic ---
            var deleteModalEl = document.getElementById('deleteStudentModal');
            if (deleteModalEl) {
                deleteModalEl.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var deleteUrl = button.getAttribute('data-url');
                    var deleteForm = deleteModalEl.querySelector('#modalDeleteForm');
                    deleteForm.action = deleteUrl;
                });
            }

            // --- Edit Modal Logic ---
            var editModalEl = document.getElementById('editStudentModal');
            if (editModalEl) {
                editModalEl.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var action = button.getAttribute('data-action');
                    var student = JSON.parse(button.getAttribute('data-student'));
                    var form = editModalEl.querySelector('#editStudentForm');

                    form.action = action;
                    form.querySelector('#edit_first_name').value = student.first_name || '';
                    form.querySelector('#edit_last_name').value = student.last_name || '';
                    form.querySelector('#edit_middle_name').value = student.middle_name || '';
                    form.querySelector('#edit_grade_level').value = student.grade_level || '';
                    form.querySelector('#edit_section').value = student.section || '';
                    form.querySelector('#edit_code').value = student.code || '';
                    form.querySelector('#edit_password').value = '';
                });
            }
        });
    </script>
<?php endif; ?>
<?= $this->endSection() ?>