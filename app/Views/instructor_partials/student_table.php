<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Student Information</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <p class="card-text">
                            Click on a student's row to view details or perform actions.
                        </p>
                    </div>

                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success mx-4"><?= session()->getFlashdata('message') ?></div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                            <tr>
                                <th>LAST NAME</th>
                                <th>FIRST NAME</th>
                                <th>MIDDLE NAME</th>
                                <th>GRADE LEVEL</th>
                                <th>SECTION</th>
                                <th>STUDENT CODE</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($students) && is_array($students)): ?>
                                <?php foreach ($students as $student): ?>
                                    <tr class="student-row"
                                        data-bs-toggle="modal"
                                        data-bs-target="#studentDetailsModal"
                                        data-id="<?= $student['id'] ?>"
                                        data-lastname="<?= esc($student['last_name']) ?>"
                                        data-firstname="<?= esc($student['first_name']) ?>"
                                        data-middlename="<?= esc($student['middle_name']) ?>"
                                        data-gradelevel="<?= esc($student['grade_level']) ?>"
                                        data-section="<?= esc($student['section']) ?>"
                                        data-code="<?= esc($student['code']) ?>"
                                        data-password="<?= esc($student['password']) ?>"
                                        style="cursor: pointer;">

                                        <td class="text-bold-500"><?= esc($student['last_name']) ?></td>
                                        <td><?= esc($student['first_name']) ?></td>
                                        <td class="text-bold-500"><?= esc($student['middle_name']) ?></td>
                                        <td><?= esc($student['grade_level']) ?></td>
                                        <td><?= esc($student['section']) ?></td>
                                        <td><?= esc($student['code']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No students found. Upload a class list to get started.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="studentDetailsModal" tabindex="-1" aria-labelledby="studentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentDetailsModalLabel">Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Last Name:</strong> <span id="modalLastName"></span></p>
                <p><strong>First Name:</strong> <span id="modalFirstName"></span></p>
                <p><strong>Middle Name:</strong> <span id="modalMiddleName"></span></p>
                <hr>
                <p><strong>Grade Level:</strong> <span id="modalGradeLevel"></span></p>
                <p><strong>Section:</strong> <span id="modalSection"></span></p>
                <p><strong>Student Code:</strong> <span id="modalStudentCode"></span></p>
                <p><strong>Password:</strong> <span id="modalPassword"></span></p>
            </div>
            <div class="modal-footer">
                <a id="modalEditButton" href="#" class="btn btn-info">Edit</a>

                <form id="modalDeleteForm" action="" method="post" onsubmit="return confirm('Are you sure you want to delete this student? This action cannot be undone.');" style="display: inline;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>

                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var studentDetailsModal = document.getElementById('studentDetailsModal');
        studentDetailsModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var row = event.relatedTarget;

            // Extract info from data-* attributes
            var studentId = row.getAttribute('data-id');
            var lastName = row.getAttribute('data-lastname');
            var firstName = row.getAttribute('data-firstname');
            var middleName = row.getAttribute('data-middlename');
            var gradeLevel = row.getAttribute('data-gradelevel');
            var section = row.getAttribute('data-section');
            var studentCode = row.getAttribute('data-code');
            var password = row.getAttribute('data-password');

            // Update the modal's content
            var modalTitle = studentDetailsModal.querySelector('.modal-title');
            var modalLastName = studentDetailsModal.querySelector('#modalLastName');
            var modalFirstName = studentDetailsModal.querySelector('#modalFirstName');
            var modalMiddleName = studentDetailsModal.querySelector('#modalMiddleName');
            var modalGradeLevel = studentDetailsModal.querySelector('#modalGradeLevel');
            var modalSection = studentDetailsModal.querySelector('#modalSection');
            var modalStudentCode = studentDetailsModal.querySelector('#modalStudentCode');
            var modalPassword = studentDetailsModal.querySelector('#modalPassword');
            var editButton = studentDetailsModal.querySelector('#modalEditButton');
            var deleteForm = studentDetailsModal.querySelector('#modalDeleteForm');

            modalTitle.textContent = 'Details for ' + firstName + ' ' + lastName;
            modalLastName.textContent = lastName;
            modalFirstName.textContent = firstName;
            modalMiddleName.textContent = middleName;
            modalGradeLevel.textContent = gradeLevel;
            modalSection.textContent = section;
            modalStudentCode.textContent = studentCode;
            modalPassword.textContent = password;

            // Update action URLs
            var baseUrl = "<?= site_url() ?>";
            editButton.href = baseUrl + 'instructor/students/edit/' + studentId;
            deleteForm.action = baseUrl + 'instructor/students/delete/' + studentId;
        });
    });
</script>