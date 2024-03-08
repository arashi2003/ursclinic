<div class="modal fade" id="apptype_set" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Appointment Type</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../nurse/apptype_set.php'"></button>
            </div>
            <form method="POST" action="modals/setnurse_apptype.php" id="form">
                <div class="modal-body">
                    <label for="apptype" class="form-label">Appointment Type:</label>
                    <div class="mb-2">
                        <input type="text" class="form-control" name="apptype" id="apptype" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add Appointment Type"></input>
                </div>
            </form>
        </div>
    </div>
</div>