<div class="modal fade" id="updatesched<?php echo $data['id'] ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Walk-In Schedule</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/update/sched.php" id="form">
                <div class="modal-body">
                    <div class="col mb-2">
                        <label for="campus" class="form-label">Campus: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="text" class="form-control" name="id" value="<?= $data['id']?>" id="id" hidden>
                        <input type="text" class="form-control" name="campus" value="<?= $data['campus']?>" id="campus" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="date" class="col-form-label">Date: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="text" class="form-control" name="date" id="date" value="<?= date("F d, Y", strtotime($data['date']))?>" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="time_from" class="col-form-label">Time From: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="time" class="form-control" name="time_from" value="<?= $data['time_from']?>"  required>
                    </div>
                    <div class="mb-2">
                        <label for="time_to" class="col-form-label">Time To: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="time" class="form-control" name="time_to" value="<?= $data['time_to']?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="maxp" class="col-form-label">Maximum Number of Patients: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="number" min="0" class="form-control" min="1" name="maxp" value="<?= $data['maxp']?>"  required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Update"></input>
                    &ThickSpace;
                    <input type="reset" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </form>
        </div>
    </div>
</div>