<div class="modal fade" id="adddform_set" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Dosage Form</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/setnurse_dosageform.php" id="form">
                <div class="modal-body">
                    <label for="dosage_form" class="form-label">Dosage Form:</label>
                    <div class="mb-2">
                        <input type="text" class="form-control" name="dosage_form" id="dosage_form" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add Dosage Form"></input>
                </div>
            </form>
        </div>
    </div>
</div>