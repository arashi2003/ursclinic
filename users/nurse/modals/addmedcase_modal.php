<div class="modal fade" id="addmedcase" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Medical Case</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/setnurse_medcase.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="type" class="form-label">Type:</label>
                        <select name="type" class="form-control" id="type" required>
                            <option value="" disabled selected>-Select Medical Case Type-</option>
                            <option value="main">Main</option>
                            <option value="checkups">Checkups</option>
                            <option value="others">Others</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="medcase" class="form-label">Medical Case:</label>
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