<section class="section">
    <div class="col-12">
        <div class="card-header">
            <h4 class="card-title">Instructor Statistics</h4>

            <!-- Optional: Display success/error messages here -->
            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                <tr>
                    <th>LAST NAME</th>
                    <th>FIRST NAME</th>
                    <th>USERNAME</th>
                    <th>EMAIL</th>
                    <th>GRADE LEVEL</th>
                    <th>ACCESS CODE</th>
                    <th>ACTIONS</th> <!-- NEW COLUMN HEADER -->
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($instructors) && is_array($instructors)): ?>
                    <?php foreach ($instructors as $instructor): ?>
                        <tr>
                            <td class="text-bold-500"><?= esc($instructor['last_name']) ?></td>
                            <td><?= esc($instructor['first_name']) ?></td>
                            <td><?= esc($instructor['username']) ?></td>
                            <td><?= esc($instructor['email']) ?></td>
                            <td><?= esc($instructor['grade_level']) ?></td>
                            <td><?= esc($instructor['access_code']) ?></td>
                            <td>
                                <!-- DELETE BUTTON -->
                                <a href="<?= base_url('master/instructor/delete/' . esc($instructor['id'])) ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete Instructor <?= esc($instructor['first_name']) ?>? This action cannot be undone.');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <!-- Changed colspan to 7 to match the new number of columns -->
                        <td colspan="7" class="text-center">No instructors found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>