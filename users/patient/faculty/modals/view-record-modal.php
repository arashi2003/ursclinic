<div class="modal fade" id="viewrecord<?php echo $data['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Expand</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <input type="hidden" name="patientid" value="<?php echo $data['id'] ?>" />
                    <label for="date" class="col-form-label">Date:</label>
                    <input type="text" class="form-control" name="date" value="<?php echo $data['datetime'] ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="timefrom" class="col-form-label">Time from:</label>
                    <input type="text" class="form-control" name="timefrom" value="<?php echo $data['time_from'] ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="timeto" class="col-form-label">Time to:</label>
                    <input type="text" class="form-control" name="timeto" value="<?php echo $data['time_to'] ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="physician" class="col-form-label">Physician:</label>
                    <input type="text" class="form-control" name="physician" value="<?php echo $data['pod_nod'] ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="chiefcomplaint" class="col-form-label">Chief Complaint:</label>
                    <input type="text" class="form-control" name="chiefcomplaint" value="<?php echo $data['chiefcomplaint'] ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="findings" class="col-form-label">Findings:</label>
                    <input type="text" class="form-control" name="findings" value="<?php echo $data['findings'] ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="type" class="col-form-label">Type:</label>
                    <input type="text" class="form-control" name="type" value="<?php echo $data['type'] ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="description" class="col-form-label">Description:</label>
                    <input type="text" class="form-control" name="description" value="<?php echo $data['description'] ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="issued" class="col-form-label">Issued:</label>
                    <input type="text" class="form-control" name="issued" value="<?php echo $data['issued'] ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="referral" class="col-form-label">Referral:</label>
                    <input type="text" class="form-control" name="referral" value="<?php echo $data['referral'] ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="medcase" class="col-form-label">Medical Case:</label>
                    <input type="text" class="form-control" name="medcase" value="<?php echo $data['medcase'] ?>" readonly>
                </div>
                <div class="mb-2">
                    <label for="medcase_desc" class="col-form-label">Medical Case Description:</label>
                    <input type="text" class="form-control" name="medcase_desc" value="<?php echo $data['medcase_desc'] ?>" readonly>
                </div>
            </div>
            
            <div class="modal-footer">
                <input type="reset" class="btn btn-danger" value="Close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
            </div>
        </div>
    </div>
</div>
</div>