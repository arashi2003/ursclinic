<div class="modal fade" id="addmedcase" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Medical Case</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../nurse/medcase_set.php'"></button>
            </div>
            <form method="POST" action="modals/setnurse_medcase.php" id="form">
                <div class="modal-body">
                    <label for="medcase" class="form-label">Medical Case:</label>
                    <div class="mb-2">
                        <input type="text" class="form-control" name="medcase" id="medcase" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add Medical Case"></input>
                </div>
            </form>
        </div>
    </div>
</div>