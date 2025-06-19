<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Students List</h3>
                    <p class="text-subtitle text-muted">A list of all students in the system.</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Students</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

<?= $this->include('partials/student_table') ?>

<?= $this->endSection() ?>