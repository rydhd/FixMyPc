<?= $this->extend('layouts/instructor_master') ?>

<?= $this->section('content') ?>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Account Profile</h3>
                    <p class="text-subtitle text-muted">A page where users can change profile information</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= site_url('instructor/dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <div class="avatar avatar-2xl">
                                    <img src="<?= base_url('assets/static/images/faces/2.jpg') ?>" alt="Avatar">
                                </div>

                                <h3 class="mt-3"><?= esc(($instructor['first_name'] ?? 'New') . ' ' . ($instructor['last_name'] ?? 'Instructor')) ?></h3>
                                <p class="text-small"><?= esc(($instructor['grade_level'] ?? '') . ' ' . ($instructor['section'] ?? '')) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Profile Details</h4>
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
                                    <label for="section" class="form-label">Section</label>
                                    <input type="text" name="section" id="section" class="form-control" placeholder="e.g., Section A" value="<?= old('section', $instructor['section'] ?? '') ?>">
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
                    </div>
                </div>
            </div>
        </section>
    </div>
<?= $this->endSection() ?>