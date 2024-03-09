<div class="modal fade" id="addcollege" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add College</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../admin/college'"></button>
            </div>
            <form method="POST" action="modals/settings/college.php" id="form">
                <div class="modal-body">
                    <label for="college" class="form-label">College:</label>
                    <div class="mb-2">
                        <input type="text" class="form-control" name="college" id="college" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add College"></input>
                </div>
            </form>
        </div>
    </div>
</div>