<!-- Modal -->
<div class="modal fade modal" id="nurseappointmentapprovemodal<?php echo $row['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Do you want to approve this appointment?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <a href="modals/appointmentapprove.php?no=<?php echo $row['id'] ?>" class="btn btn-danger">Yes</a>
            </div>
        </div>
    </div>
</div>