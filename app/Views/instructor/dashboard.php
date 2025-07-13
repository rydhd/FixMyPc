<?= $this->extend('layouts/instructor_master') ?>

<?= $this->section('content') ?>
    <div class="row">
        <div class="col-6 col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body px-3 py-4-5">
                    <div class="row">
                        <div class="col-md-auto">
                            <div class="stats-icon purple">
                                <i class="iconly-boldShow"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="text-muted font-semibold">Number of Students</h6>
                            <h6 class="font-extrabold mb-0"><?= $student_count ?? 0 ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-4 col-md-6">
            <a href="#" data-bs-toggle="modal" data-bs-target="#studentRankingModal" class="text-decoration-none">
                <div class="card">
                    <div class="card-body px-3 py-4-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="stats-icon blue">
                                    <i class="iconly-boldProfile"></i>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h6 class="text-muted font-semibold">Student Ranking</h6>
                                <h6 class="font-extrabold mb-0">Top 10</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?= $this->include('instructor_partials/chart') ?>
<?= $this->endSection() ?>