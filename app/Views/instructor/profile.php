<?= $this->extend('layouts/instructor_master') ?>

<?= $this->section('content') ?>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Profile</h3>
                    <p class="text-subtitle text-muted">A page where users can change profile information</p>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">

            </div>
        </section>
    </div>
    <div class="two-column-container-flex">
        <div class="card-body">
            <form action="<?= site_url('instructor/profile/update') ?>" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="<?= old('first_name', $instructor['first_name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle Name" value="<?= old('middle_name', $instructor['middle_name'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="<?= old('last_name', $instructor['last_name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="grade_level" class="form-label">Grade Level</label>
                    <input type="text" name="grade_level" id="grade_level" class="form-control" placeholder="e.g., Grade 10" value="<?= old('grade_level', $instructor['grade_level'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="access_code" class="form-label">Access Code</label>
                    <input type="text" id="access_code" class="form-control" value="<?= esc($access_code['code'] ?? 'Not available') ?>" readonly>
                </div>

                <hr>
                <h5 class="mt-3">Change Password (Optional)</h5>

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank to keep current password">
                </div>

                <div class="form-group">
                    <label for="password_confirm" class="form-label">Confirm New Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Confirm new password">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
        <div class="column-right">
            <div class="col-20 col-lg-4">
                            <div class="avatar avatar-2xl">
                                <img src="<?= base_url('assets/static/images/faces/2.jpg') ?>" alt="Avatar">
                            </div>

                            <h4 class="mt-3">
                                <strong>Full Name:</strong> <?= esc(($instructor['first_name'] ?? 'New') . ' ' . ($instructor['last_name'] ?? 'Instructor')) ?>
                            </h4>
                            <p class="text-small">
                                <strong>Grade Level:</strong> <?= esc($instructor['grade_level'] ?? '') ?>
                            </p>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
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
                    </div>

                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>