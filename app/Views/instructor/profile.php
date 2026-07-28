<?= $this->extend('layouts/instructor_master') ?>

<?= $this->section('content') ?>
<?php
// Capture validation errors into a clean variable so we can apply them directly to the input fields
$valErrors = session()->getFlashdata('validation_errors') ?? [];
?>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="m-3 ">
                    <h3>Edit Profile</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- --- TOP LEVEL ALERTS --- -->
<?php if (session()->getFlashdata('toast_success') || session()->getFlashdata('message')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('toast_success') ?? session()->getFlashdata('message') ?>
    </div>
<?php endif ?>

<?php if (session()->getFlashdata('toast_error')) : ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('toast_error') ?>
        <?php if (!empty($valErrors)): ?>
            Please correct the highlighted fields below.
        <?php endif; ?>
    </div>
<?php endif ?>
    <!-- ------------------------ -->

    <div class="two-column-container-flex">
        <div class="card-body">
            <form action="<?= site_url('instructor/profile/update') ?>" method="post" id="profileForm" novalidate>
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" id="first_name"
                           class="form-control <?= isset($valErrors['first_name']) ? 'is-invalid' : '' ?>"
                           placeholder="First Name" value="<?= old('first_name', $instructor['first_name'] ?? '') ?>" readonly required>
                    <?php if (isset($valErrors['first_name'])): ?>
                        <div class="invalid-feedback"><?= esc($valErrors['first_name']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" id="middle_name"
                           class="form-control <?= isset($valErrors['middle_name']) ? 'is-invalid' : '' ?>"
                           placeholder="Middle Name" value="<?= old('middle_name', $instructor['middle_name'] ?? '') ?>" readonly>
                    <?php if (isset($valErrors['middle_name'])): ?>
                        <div class="invalid-feedback"><?= esc($valErrors['middle_name']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" id="last_name"
                           class="form-control <?= isset($valErrors['last_name']) ? 'is-invalid' : '' ?>"
                           placeholder="Last Name" value="<?= old('last_name', $instructor['last_name'] ?? '') ?>" readonly required>
                    <?php if (isset($valErrors['last_name'])): ?>
                        <div class="invalid-feedback"><?= esc($valErrors['last_name']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="grade_level" class="form-label">Grade Level</label>
                    <input type="text" name="grade_level" id="grade_level"
                           class="form-control <?= isset($valErrors['grade_level']) ? 'is-invalid' : '' ?>"
                           placeholder="e.g., Grade 10" value="<?= old('grade_level', $instructor['grade_level'] ?? '') ?>" readonly>
                    <?php if (isset($valErrors['grade_level'])): ?>
                        <div class="invalid-feedback"><?= esc($valErrors['grade_level']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="access_code" class="form-label">Access Code</label>
                    <input type="text" id="access_code" class="form-control" value="<?= esc($instructor['access_code'] ?? 'Not available') ?>" readonly>
                </div>

                <hr>
                <h5 class="mt-3">Change Password (Optional)</h5>

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" id="password"
                           class="form-control <?= isset($valErrors['password']) ? 'is-invalid' : '' ?>"
                           placeholder="Leave blank to keep current password" readonly>
                    <?php if (isset($valErrors['password'])): ?>
                        <div class="invalid-feedback"><?= esc($valErrors['password']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group position-relative">
                    <label for="password_confirm" class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirm" id="password_confirm"
                           class="form-control <?= isset($valErrors['password_confirm']) ? 'is-invalid' : '' ?>"
                           placeholder="Confirm new password" readonly>
                    <?php if (isset($valErrors['password_confirm'])): ?>
                        <div class="invalid-feedback"><?= esc($valErrors['password_confirm']) ?></div>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="column-right">
            <div class="card-body text-center">
                <div class="avatar avatar-2xl">
                    <img src="<?= base_url('assets/static/images/faces/2.jpg') ?>" alt="Avatar">
                </div>

                <h4 class="mt-3">
                    Full Name: <?= esc(($instructor['first_name'] ?? 'New') . ' ' . ($instructor['last_name'] ?? 'Instructor')) ?>
                </h4>
                <p class="text-muted">
                    Grade Level: <?= esc($instructor['grade_level'] ?? '') ?>
                </p>
                <div class="form-group">
                    <button type="button" class="btn btn-primary rounded-pill" id="editButton">Edit Profile</button>
                    <button type="submit" form="profileForm" class="btn btn-primary" id="saveButton" style="display: none;">Save Changes</button>
                    <button type="button" class="btn btn-primary rounded-pill" id="cancelButton" style="display: none;">Cancel</button>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButton = document.getElementById('editButton');
            const saveButton = document.getElementById('saveButton');
            const cancelButton = document.getElementById('cancelButton');
            const profileForm = document.getElementById('profileForm');

            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirm');

            const formInputs = [
                document.getElementById('first_name'),
                document.getElementById('middle_name'),
                document.getElementById('last_name'),
                document.getElementById('grade_level'),
                passwordInput,
                confirmInput,
            ];

            // --- Edit Button Logic ---
            editButton.addEventListener('click', function() {
                formInputs.forEach(input => {
                    if (input) {
                        input.readOnly = false;
                    }
                });

                formInputs[0].focus();

                editButton.style.display = 'none';
                saveButton.style.display = 'inline-block';
                cancelButton.style.display = 'inline-block';
            });

            // --- Cancel Button Logic ---
            cancelButton.addEventListener('click', function() {
                location.reload();
            });

            // --- Dynamic UI Error Handling for Password Match ---
            profileForm.addEventListener('submit', function(event) {
                const pass = passwordInput.value;
                const confirm = confirmInput.value;

                // Clear out any old JS validation errors first
                confirmInput.classList.remove('is-invalid');
                const oldError = document.getElementById('js-password-error');
                if (oldError) oldError.remove();

                // Check if they typed a password but it doesn't match the confirmation
                if (pass !== '' || confirm !== '') {
                    if (pass !== confirm) {
                        event.preventDefault(); // Stop form submission

                        // Apply Bootstrap's invalid class
                        confirmInput.classList.add('is-invalid');

                        // Create and inject the error message directly under the field
                        const errorDiv = document.createElement('div');
                        errorDiv.id = 'js-password-error';
                        errorDiv.className = 'invalid-feedback';
                        errorDiv.innerText = 'Passwords do not match. Please ensure both fields are identical.';
                        confirmInput.parentNode.appendChild(errorDiv);
                    }
                }
            });
        });
    </script>
<?= $this->endSection() ?>