<div class="modal fade" id="cancelappointment<?php echo $data['id'] ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cancelling..</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="#" id="form">
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                    <div class="mb-2">
                        <h5>Are you sure, you want to cancel this appointment?</h5>
                    </div>
                    <div class="mb-2">
                        <label for="cancelling" class="form-label">Reason for cancelling:</label>
                        <input type="text" class="form-control" name="cancelling" id="cancelling" placeholder="-please state your reasoning XD-" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Yes"></input>
                </div>
            </form>
        </div>
    </div>
</div>