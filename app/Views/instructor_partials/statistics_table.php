<section class="section">
    <div class="card-header d-flex justify-content-between align-items-center rounded-4">
        <h4 class="card-title mb-0">Student Statistics</h4>
    </div>
    <div class="table-responsive">
        <table class="table table-striped" id="table3">
            <thead class="table-light">
            <tr>
                <th>USERNAME</th>
                <th>SCORE</th>
                <th>PERCENTAGE</th>
                <th>STATUS</th>
                <th>COC LEVEL</th>
                <th>DATE COMPLETED</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($students) && is_array($students)) : ?>
                <?php foreach ($students as $student) : ?>
                    <tr>
                        <td class="text-bold-500"><?= esc($student['code']) ?></td>

                        <!-- Dynamic Score -->
                        <td><?= esc($student['score'] ?? '0') ?></td>

                        <!-- Optional: If you have a percentage column, output it here. Otherwise, fallback to 0% -->
                        <td><?= esc($student['percentage'] ?? '0') ?>%</td>

                        <!-- Dynamic Status with Badges -->
                        <td>
                            <?php $status = $student['status'] ?? 'Not Started'; ?>
                            <?php if ($status === 'Passed'): ?>
                                <span class="badge bg-success">Passed</span>
                            <?php elseif ($status === 'Not Started'): ?>
                                <span class="badge bg-secondary">Not Started</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark"><?= esc($status) ?></span>
                            <?php endif; ?>
                        </td>

                        <!-- Dynamic COC Level Tracking -->
                        <td>
                            <?php if (isset($student['coc_level']) && (string)$student['coc_level'] === '1'): ?>
                                <span class="badge bg-primary">COC 1</span>
                            <?php elseif (!empty($student['coc_level'])): ?>
                                <span class="badge bg-info">COC <?= esc($student['coc_level']) ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary">N/A</span>
                            <?php endif; ?>
                        </td>

                        <!-- Use 'updated_at' to track when the game last pushed data -->
                        <td>
                            <?php
                            if (!empty($student['updated_at'])) {
                                echo esc(date('Y-m-d', strtotime($student['updated_at'])));
                            } else {
                                echo '<span class="text-muted">No Data</span>';
                            }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize DataTable
        const table = new DataTable('#table3', {
            // This adds the default search box and pagination
            "dom": '<"row"<"col-sm-12"l><"col-md-6">>' +
                '<"row"<"col-sm-12"tr>>' +
                '<"row"<"col-sm-12 col-md-5"><"col-sm-12 col-md-7"p>>',
        });
    });
</script>