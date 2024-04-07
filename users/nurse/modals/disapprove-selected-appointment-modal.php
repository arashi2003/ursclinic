<div class="modal fade" id="disapproveselectedappointment" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Disapproval of Request Appointment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="massdisapproved.php" id="form">
                <div class="modal-body">
                    <!-- Hidden input field to store the disapproved IDs -->
                    <input type="text" id="disapprovedIDsInput" name="disapprovedIDs" hidden>
                    <!-- Rest of your modal content -->
                    <label for="reason" class="form-label">Reason for disapproval:</label>
                    <textarea type="text" style="resize:none;" class="form-control" name="reason" id="reason" required></textarea>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" name="app_disapproved" value="Confirm"></input>
                    &ThickSpace;
                    <input type="reset" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </form>
        </div>
    </div>
</div>