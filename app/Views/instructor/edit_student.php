<?= $this->extend('layouts/instructor_master') ?>

<?= $this->section('content') ?>
    <div class="page-heading">
        <h3>Edit Student: <?= esc($student['first_name']) ?> <?= esc($student['last_name']) ?></h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Student Details</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('instructor/students/update/' . $student['id']) ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= esc($student['first_name']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= esc($student['last_name']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?= esc($student['middle_name']) ?>">
                            </div>

                            <div class="mb-3">
                                <label for="grade_level" class="form-label">Grade Level</label>
                                <input type="text" class="form-control" id="grade_level" name="grade_level" value="<?= esc($student['grade_level']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="section" class="form-label">Section</label>
                                <input type="text" class="form-control" id="section" name="section" value="<?= esc($student['section']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="code" class="form-label">Student Code</label>
                                <input type="text" class="form-control" id="code" name="code" value="<?= esc($student['code']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password (leave blank to keep current password)</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="<?= site_url('/instructor/students') ?>" class="btn btn-light-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?= $this->endSection() ?>