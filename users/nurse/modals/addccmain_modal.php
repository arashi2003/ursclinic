<div class="modal fade" id="addccmain" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Chief Complaint</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/setnurse_chiefcomplaint.php" id="form">
                <div class="modal-body">
                    <label for="cc" class="form-label">Chief Complaint:</label>
                    <div class="mb-2">
                        <input type="text" class="form-control" name="chief_complaint" id="chief_complaint" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add Chief Complaint"></input>
                </div>
            </form>
        </div>
    </div>
</div>