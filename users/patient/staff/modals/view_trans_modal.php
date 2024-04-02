<div class="modal fade" id="viewtrans<?php echo $data['id']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Record</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = 'history'"></button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label for="datetime" class="form-label">Date and Time:</label>
                    <input type="text" class="form-control" name="datetime" value="<?php echo date("F d, Y", strtotime($data['datetime'])) . " | " . date("g:i A", strtotime($data['datetime'])) ?>" id="datetime" disabled>
                </div>
                <div class="row">
                    <div class="col mb-2">
                        <label for="transaction" class="form-label">Transaction:</label>
                        <input type="text" class="form-control" name="transaction" value="<?php echo $data['transaction'] ?>" id="transaction" disabled>
                    </div>
                    <div class="col mb-2">
                        <label for="purpose" class="form-label">Service:</label>
                        <input type="text" class="form-control" name="purpose" value="<?php echo $data['purpose'] ?>" id="purpose" disabled>
                    </div>
                </div>
                <?php
                if ($data['transaction'] == "Request for Medicine" || $data['transaction'] == "Request for Medical Supply" || $data['purpose'] == "Request for Medicine" || $data['purpose'] == "Request for Medical Supply") { ?>

                    <div class="mb-2">
                        <label for="chief_complaint" class="form-label">Chief Complaints:</label>
                        <textarea class="form-control" style="resize:none;" name="chief_complaint" id="chief_complaint" disabled><?= $data['chief_complaint'] ?></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="medsup" class="form-label">Issued Medicine/Medical Supplies:</label>
                        <textarea type="text" style="resize:none;" class="form-control" name="medsup" id="medsup" disabled><?= $data['medsup'] ?></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="medsup" class="form-label">Remarks:</label>
                        <textarea type="text" style="resize:none;" class="form-control" name="remarks" id="remarks" disabled><?= $data['remarks'] ?></textarea>
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="pr" class="form-label">Blood Pressure:</label>
                            <input type="text" class="form-control" name="bp" value="<?php echo $data['bp'] ?>" id="bp" disabled>
                        </div>
                        <div class="col mb-2">
                            <label for="pr" class="form-label">Pulse Rate:</label>
                            <input type="text" class="form-control" name="pr" value="<?php echo $data['pr'] ?>" id="pr" disabled>
                        </div>
                        <div class="col mb-2">
                            <label for="te" class="form-label">Temperature:</label>
                            <input type="text" class="form-control" name="temp" value="<?php echo $data['temp'] ?>" id="temp" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="pr" class="form-label">Respiratory Rate:</label>
                            <input type="text" class="form-control" name="respiratory" value="<?php echo $data['respiratory'] ?>" id="respiratory" disabled>
                        </div>
                        <div class="col mb-2">
                            <label for="pr" class="form-label">Oxygen Saturation:</label>
                            <input type="text" class="form-control" name="oxygen" value="<?php echo $data['oxygen_saturation'] ?>" id="oxygen" disabled>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="chief_complaint" class="form-label">Chief Complaints:</label>
                        <textarea style="resize: none;" class="form-control" name="chief_complaint" id="chief_complaint" disabled><?php echo $data['chief_complaint'] ?></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="findiag" class="form-label">Findings/Diagnosis:</label>
                        <textarea style="resize: none;" class="form-control" name="findiag" id="findiag" disabled><?php echo $data['findiag'] ?></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="remarks" class="form-label">Remarks:</label>
                        <textarea style="resize: none;" class="form-control" name="remarks" id="remarks" disabled><?php echo $data['remarks'] ?></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="referral" class="form-label">Referral:</label>
                        <textarea style="resize: none;" class="form-control" name="referral" id="referral" disabled><?php echo $data['referral'] ?></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="medsup" class="form-label">Issued Medicine/Medical Supplies:</label>
                        <textarea style="resize: none;" class="form-control" name="medsup" id="medsup" disabled><?php echo $data['medsup'] ?></textarea>
                    </div>
                <?php } ?>
                <div class="mb-2">
                    <label for="pod_nod" class="form-label">Physician/Nurse on Duty:</label>
                    <input type="text" class="form-control" name="pod_nod" value="<?= $data['pod_nod'] ?>" id="pod_nod" disabled>
                </div>
                <div class="mb-2">
                    <label for="medcase" class="form-label">Medical Case:</label>
                    <input type="text" class="form-control" name="medcase" value="<?= $data['medcase'] ?>" id="medcase" disabled>
                </div>
                <div class="mb-2">
                    <label for="medcase_others" class="form-label">Medical Case (Others):</label>
                    <input type="text" class="form-control" name="medcase_others" value="<?= $data['medcase_others'] ?>" id="medcase_others" disabled>
                </div>
            </div>
            
            <div class="modal-footer">
                <input type="reset" class="btn btn-danger" value="Close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
            </div>
        </div>
    </div>
</div>