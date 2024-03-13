<div class="modal fade" id="updatecampus<?php echo $data['id']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Campus</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../admin/campus.php'"></button>
            </div>
            <form method="POST" action="modals/update/campus.php?id=<?php echo $data['id']; ?>" id="form">
                <div class="modal-body">
                    <label for="campus" class="form-label">Campus:</label>
                    <div class="mb-2">
                        <input type="text" name="campusid" value="<?php echo $data['id']?>" hidden>
                        <input type="text" class="form-control" name="campus" id="campus" value="<?php echo $data['campus']?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Save"></input>
                </div>
            </form>
        </div>
    </div>
</div>