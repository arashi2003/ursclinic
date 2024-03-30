<div class="modal fade" id="disapproveappointment<?php echo $data['id'] ?>" tabindex="-1" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Disapproval of Request Appointment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/cancel-appointment.php" id="form">
                <div class="modal-body">
                    <input type="text" name="id" value="<?php echo $data['id'] ?>" hidden>
                    <input type="text" name="name" value="<?php echo ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname'])) ?>" hidden>
                    <input type="text" name="date" value="<?php echo date("F d, Y", strtotime($data['date'])) ?>" hidden>
                    <input type="text" name="time" value="<?php echo date("g:i A", strtotime($data['time_from'])) . " - " . date("g:i A", strtotime($data['time_to'])) ?>" hidden>
                    <input type="text" name="email" value="<?= $data['email'] ?>" hidden>
                    <input type="text" name="physician" value="<?= $physician ?>" hidden>
                    <div class="mb-2">
                        <label for="reason" class="form-label">Reason for disapproval:</label>
                        <textarea type="text" style="resize:none;" class="form-control" name="reason" id="reason" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-danger" value="Cancel Request"></input>
                </div>
            </form>
        </div>
    </div>
</div>