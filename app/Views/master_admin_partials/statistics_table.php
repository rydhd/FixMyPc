<section class="section">
    <div class="card-header">
        <h4 class="card-title">Student Statistics</h4>
    </div>
        <div class="table-responsive">
            <table class="table table-striped" id="table3">
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
                <?php if (!empty($students) && is_array($students)) : ?>
                    <?php foreach ($students as $student) : ?>
                        <tr>
                            <td class="text-bold-500"><?= esc($student['code']) ?></td>
                            <td>85</td>
                            <td>85%</td>
                            <td>Passed</td>
                            <td>2025-07-19</td>
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