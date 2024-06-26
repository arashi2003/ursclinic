<div class="modal fade" id="cancelsched<?php echo $data['id'] ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cancellation of Walk-In Schedule</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/cancel/sched.php" id="form">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                    <input type="hidden" name="campus" value="<?php echo $data['campus'] ?>">
                    <div class="mb-2">
                        <label for="cancelreasonling" class="form-label">Reason for cancellation: <i style="color: red; font-size: 20px">*</i></label>
                        <textarea class="form-control" name="reason" id="reason" style="resize: none;" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Confirm"></input>
                    &ThickSpace;
                    <input type="reset" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </form>
        </div>
    </div>
</div>