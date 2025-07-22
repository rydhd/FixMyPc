<div class="modal fade" id="generateCodeModal" tabindex="-1" aria-labelledby="generateCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateCodeModalLabel">Generate New Access Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to generate a new access code?</p>
                <div id="generatedCodeResult" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmGenerateCode">Generate Code</button>
            </div>
        </div>
    </div>
</div>

<script>
    // --- CHANGE #1: Directly create a JavaScript variable with the CSRF token ---
    const csrfToken = '<?= csrf_hash() ?>';

    document.addEventListener('DOMContentLoaded', function () {
        const generateCodeModal = document.getElementById('generateCodeModal');
        const confirmBtn = document.getElementById('confirmGenerateCode');
        const resultDiv = document.getElementById('generatedCodeResult');

        if (confirmBtn) {
            confirmBtn.addEventListener('click', function () {
                resultDiv.innerHTML = `<div class="d-flex align-items-center"><strong>Generating...</strong><div class="spinner-border ms-auto" role="status" aria-hidden="true"></div></div>`;
                confirmBtn.disabled = true;

                fetch('<?= url_to('master_generate_code') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        // --- CHANGE #2: Use the new JavaScript variable instead of querySelector ---
                        'X-CSRF-TOKEN': csrfToken
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success && data.code) {
                            resultDiv.innerHTML = `<div class="alert alert-success text-center"><h4 class="alert-heading">Code Generated!</h4><p class="fs-5 mb-0">${data.code}</p></div>`;
                        } else {
                            resultDiv.innerHTML = `<div class="alert alert-danger">${data.message || 'Failed to generate code. Please try again.'}</div>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resultDiv.innerHTML = '<div class="alert alert-danger">An error occurred. Check the console for details.</div>';
                    })
                    .finally(() => {
                        confirmBtn.disabled = false;
                    });
            });
        }

        if (generateCodeModal) {
            generateCodeModal.addEventListener('hidden.bs.modal', function () {
                resultDiv.innerHTML = '';
            });
        }
    });
</script>