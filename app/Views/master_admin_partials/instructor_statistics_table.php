<section class="section">
        <div class="col-12">
                <div class="card-header">
                    <h4 class="card-title">Instructor Statistics</h4>
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
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No instructors found.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
</section>