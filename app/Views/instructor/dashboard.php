<?= $this->extend('layouts/instructor_master') ?>

<?= $this->section('content') ?>
    <div class="d-flex flex-wrap gap-3">
        <div class="card" style="width: 220px;">
            <div class="card-body rounded-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar bg-primary rounded-3 p-3">
                            <i class="bi bi-people-fill text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Number of Students</h6>
                        <h5 class="mb-0"><?= $student_count ?? '0' ?></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="width: 220px; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#studentRankingModal">
            <div class="card-body rounded-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="avatar bg-info rounded-3 p-3">
                            <i class="bi bi-person-check-fill text-white fs-4"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Student Ranking</h6>
                        <h5 class="mb-0">Top 10</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="studentRankingModal" tabindex="-1" aria-labelledby="studentRankingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentRankingModalLabel">Top 10 Student Ranking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">Rank</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Score</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($top_students)): ?>
                            <?php foreach ($top_students as $index => $student): ?>
                                <tr>
                                    <th scope="row"><?= $index + 1 ?></th>
                                    <td>
                                        <?= esc(is_array($student) ? $student['first_name'] . ' ' . $student['last_name'] : $student->first_name . ' ' . $student->last_name) ?>
                                    </td>
                                    <td>
                                        <?= esc(is_array($student) ? $student['score'] : $student->score) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No student scores available yet.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!-- Inject CodeIgniter data into JavaScript for ApexCharts to use -->
    <script>
        const dynamicChartLabels = <?= $chart_labels ?? '[]' ?>;
        const dynamicChartData = <?= $chart_data ?? '[]' ?>;
    </script>

<?= $this->include('instructor_partials/chart') ?>
<?= $this->endSection() ?>