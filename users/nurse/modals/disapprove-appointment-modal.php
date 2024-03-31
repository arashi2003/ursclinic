<div class="modal fade" id="disapproveappointment<?= $id ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Disapproval of Request Appointment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/cancel-appointment.php" id="form">
                <div class="modal-body">
                    <input type="text" value="<?= $id; ?>" name="id" hidden>
                    <label for="reason" class="form-label">Reason for disapproval:</label>
                    <textarea type="text" style="resize:none;" class="form-control" name="reason" id="reason" required></textarea>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-danger" value="Cancel Request"></input>
                </div>
            </form>
        </div>
    </div>
</div>