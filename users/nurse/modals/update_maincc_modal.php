<div class="modal fade" id="updatecc<?php echo $data['id']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Chief Complaint</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="modals/update/update_chiefcomplaint.php" id="form">
                <div class="modal-body">
                    <label for="cc" class="form-label">Chief Complaint:</label>
                    <div class="mb-2">
                        <input type="text" name="id" value="<?php echo $data['id']?>" hidden>
                        <input type="text" class="form-control" name="chief_complaint" id="chief_complaint" value="<?php echo $data['chief_complaint']?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Save"></input>
                </div>
            </form>
        </div>
    </div>
</div>