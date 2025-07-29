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
                        <tr>
                            <th scope="row">1</th>
                            <td>John Doe</td>
                            <td>98.5</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jane Smith</td>
                            <td>97.2</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Peter Jones</td>
                            <td>96.8</td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>Samuel Williams</td>
                            <td>95.5</td>
                        </tr>
                        <tr>
                            <th scope="row">5</th>
                            <td>Linda Davis</td>
                            <td>94.9</td>
                        </tr>
                        <tr>
                            <th scope="row">6</th>
                            <td>Michael Brown</td>
                            <td>93.1</td>
                        </tr>
                        <tr>
                            <th scope="row">7</th>
                            <td>Barbara Wilson</td>
                            <td>92.7</td>
                        </tr>
                        <tr>
                            <th scope="row">8</th>
                            <td>Richard Taylor</td>
                            <td>91.4</td>
                        </tr>
                        <tr>
                            <th scope="row">9</th>
                            <td>Susan Martinez</td>
                            <td>90.8</td>
                        </tr>
                        <tr>
                            <th scope="row">10</th>
                            <td>Charles Anderson</td>
                            <td>89.6</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

<?= $this->include('instructor_partials/chart') ?>
<?= $this->endSection() ?>