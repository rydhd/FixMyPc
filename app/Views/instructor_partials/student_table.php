<section class="section card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Student Information</h4>
        <div class="buttons">
            <button type="button" class="btn icon icon-left btn-primary" data-bs-toggle="modal" data-bs-target="#uploadClassListModal">
                <i class="bi bi-plus-lg"></i>
                Add Class
            </button>
            <button type="button" class="btn icon icon-left btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i data-feather="user-plus"></i> Add Student
            </button>
        </div>
    </div>
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>

        <div id="custom-filter-container" style="display: none;">
            <label for="section-select-filter">Filter by Section: </label>
            <select id="section-select-filter" class="form-select form-select-sm">
                <option value="">All</option>
                <?php if (!empty($sections)) : ?>
                    <?php foreach ($sections as $section) : ?>
                        <option value="<?= esc($section) ?>"><?= esc($section) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="table-responsive">
            <table class="table table-striped" id="table2">
                <thead class="table-light">
                <tr>
                    <th>LAST NAME</th>
                    <th>FIRST NAME</th>
                    <th>MIDDLE NAME</th>
                    <th>GRADE LEVEL</th>
                    <th>SECTION</th>
                    <th>STUDENT CODE</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($students) && is_array($students)): ?>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= esc($student['last_name']) ?></td>
                            <td><?= esc($student['first_name']) ?></td>
                            <td><?= esc($student['middle_name']) ?></td>
                            <td><?= esc($student['grade_level']) ?></td>
                            <td><?= esc($student['section']) ?></td>
                            <td><?= esc($student['code']) ?></td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <button type="button" class="btn btn-sm icon btn-info"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editStudentModal"
                                            data-student='<?= esc(json_encode($student)) ?>'
                                            data-action="<?= site_url('instructor/students/update/' . $student['id']) ?>">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm icon btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteStudentModal"
                                            data-url="<?= site_url('instructor/students/delete/' . $student['id']) ?>">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </div>
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
</section>