<div class="modal fade" id="updatecollege<?php echo $data['id']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update College</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/update/college.php" id="form">
                <div class="modal-body">
                    <label for="college" class="form-label">College:</label>
                    <div class="mb-2">
                        <input type="text" name="collegeid" value="<?php echo $data['id']?>" hidden>
                        <input type="text" class="form-control" name="college" id="college" value="<?php echo $data['college']?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Save"></input>
                </div>
            </form>
        </div>
    </div>
</div>