<div class="modal fade" id="adddepartment" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Department</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../admin/department'"></button>
            </div>
            <form method="POST" action="modals/settings/department.php" id="form">
                <div class="modal-body">
                    <label for="department" class="form-label">Department:</label>
                    <div class="mb-2">
                        <input type="text" class="form-control" name="department" id="department" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add Department"></input>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#adddepartment').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
    });
</script>