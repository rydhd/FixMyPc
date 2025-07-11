<?= $this->extend('layouts/master_admin_master') ?>

<?= $this->section('content') ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Access Codes</h5>

                        <form action="<?= url_to('master_generate_code') ?>" method="post">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Generate New Code
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <?php if (session('message') !== null) : ?>
                            <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                        <?php endif ?>
                        <?php if (session('error') !== null) : ?>
                            <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                        <?php endif ?>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Access Code</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Created At</th>
                                    <th>Used By</th>
                                    <th>Used At</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (empty($codes)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No access codes found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($codes as $code): ?>
                                        <tr>
                                            <td><strong><?= esc($code['code']) ?></strong></td>
                                            <td>
                                                <?php if ($code['is_used']): ?>
                                                    <span class="badge bg-danger">Used</span>
                                                <?php else: ?>
                                                    <span class="badge bg-success">Available</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($code['creator_username'] ?? 'N/A') ?></td>
                                            <td><?= esc($code['created_at']) ?></td>
                                            <td><?= esc($code['user_username'] ?? 'N/A') ?></td>
                                            <td><?= esc($code['used_at'] ?? 'N/A') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?= $this->endSection() ?>