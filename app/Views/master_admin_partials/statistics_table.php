<section class="section">
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <p class="card-text">
                            This table shows the statistics of the students. The student's code is used as their username.
                        </p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                            <tr>
                                <th>USERNAME</th>
                                <th>SCORE</th>
                                <th>PERCENTAGE</th>
                                <th>STATUS</th>
                                <th>DATE COMPLETED</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($students) && is_array($students)): ?>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td class="text-bold-500"><?= esc($student['code']) ?></td>

                                        <td>N/A</td>
                                        <td>N/A</td>
                                        <td>N/A</td>
                                        <td>N/A</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No student statistics found.</td>
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