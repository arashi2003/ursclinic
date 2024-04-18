<div class="modal fade" id="app_cancelled<?php echo $data['id'] ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cancelled Appointment Request</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                <div class="mb-2">
                    <label for="cancelreasonling" class="form-label">Reason for cancellation: <i style="color: red; font-size: 20px">*</i></label>
                    <textarea class="form-control" name="reason" id="reason" style="resize: none;" disabled><?= $data['reason'] ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>