<div class="modal fade modal" id="removephysician_set<?php echo $data['id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
            </div>
            <div class="modal-body">
                <h5>Are you sure you want to remove this physician for appointment?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <a href="modals/remove/appphysician.php?no=<?php echo $data['id'] ?>" class="btn btn-danger">Yes</a>
            </div>
        </div>
    </div>
</div>