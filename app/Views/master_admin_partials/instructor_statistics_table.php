<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Statistics Information</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <p class="card-text">
                            Statistics of all students in the system.
                        </p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                            <tr>
                                <th>USER NAME</th>
                                <th>AVG</th>
                                <th>CODE</th>
                                <th>DATE COMPLETED</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($students) && is_array($students)): ?>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td class="text-bold-500"><?= esc($student['last_name']) ?></td>
                                        <td><?= esc($student['first_name']) ?></td>
                                        <td class="text-bold-500"><?= esc($student['middle_initial']) ?></td>
                                        <td><?= esc($student['username']) ?></td>
                                        <td><?= esc($student['year']) ?></td>
                                        <td><?= esc($student['section']) ?></td>
                                        <td>
                                            <a href="/admin/students/edit/<?= $student['id'] ?>">Edit</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No students found.</td>
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