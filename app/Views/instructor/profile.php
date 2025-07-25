<?= $this->extend('layouts/instructor_master') ?>

<?= $this->section('content') ?>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="m-3 ">
                    <h3>Edit Profile</h3>
                    <p class="text-subtitle text-muted">A page where users can change profile information</p>
                </div>
            </div>
        </div>
    </div>

<?php if (session()->getFlashdata('message')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
<?php endif ?>
<?php if (session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

    <div class="two-column-container-flex">
        <div class="card-body">
            <form action="<?= site_url('instructor/profile/update') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="<?= old('first_name', $instructor['first_name'] ?? '') ?>" readonly required>
                </div>
                <div class="form-group">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle Name" value="<?= old('middle_name', $instructor['middle_name'] ?? '') ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="<?= old('last_name', $instructor['last_name'] ?? '') ?>" readonly required>
                </div>
                <div class="form-group">
                    <label for="grade_level" class="form-label">Grade Level</label>
                    <input type="text" name="grade_level" id="grade_level" class="form-control" placeholder="e.g., Grade 10" value="<?= old('grade_level', $instructor['grade_level'] ?? '') ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="access_code" class="form-label">Access Code</label>
                    <input type="text" id="access_code" class="form-control" value="<?= esc($instructor['access_code'] ?? 'Not available') ?>" readonly>
                </div>

                <hr>
                <h5 class="mt-3">Change Password (Optional)</h5>

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank to keep current password" readonly>
                </div>

                <div class="form-group">
                    <label for="password_confirm" class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Confirm new password" readonly>
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
                        <button type="submit" class="btn btn-primary" id="saveButton" style="display: none;">Save Changes</button>
                        <button type="button" class="btn btn-primary rounded-pill" id="cancelButton" style="display: none;">Cancel</button>
                    </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get references to the buttons
            const editButton = document.getElementById('editButton');
            const saveButton = document.getElementById('saveButton');
            const cancelButton = document.getElementById('cancelButton');

            // Get references to all the input fields that should be toggled
            const formInputs = [
                document.getElementById('first_name'),
                document.getElementById('middle_name'),
                document.getElementById('last_name'),
                document.getElementById('grade_level'),
                document.getElementById('password'),
                document.getElementById('password_confirm'),
            ];

            // --- Event Listener for the Edit Button ---
            editButton.addEventListener('click', function() {
                // Loop through all inputs and remove the 'readonly' attribute
                formInputs.forEach(input => {
                    if (input) { // Check if the element exists
                        input.readOnly = false;
                    }
                });

                // Focus the first input field for better UX
                formInputs[0].focus();

                // Toggle button visibility
                editButton.style.display = 'none';
                saveButton.style.display = 'inline-block';
                cancelButton.style.display = 'inline-block';
            });

            // --- Event Listener for the Cancel Button ---
            cancelButton.addEventListener('click', function() {
                // Simply reload the page to discard changes and reset the form state
                location.reload();
            });
        });
    </script>
<?= $this->endSection() ?>