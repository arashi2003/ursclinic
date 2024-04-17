<div class="modal fade" id="viewtrans<?php echo $data['id']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Dental Record</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form action="reports/reports_pres_dental" method="post" target="_blank">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="datetime" class="form-label">Date and Time:</label>
                        <input type="text" class="form-control" name="datetime" value="<?php echo date("F d, Y", strtotime($data['datetime'])) . " | " . date("g:i A", strtotime($data['datetime'] . "+ 8 hours")); ?>" id="datetime" disabled>
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
                    <div class="mb-2">
                        <label for="medsup" class="form-label">Prescription:</label>
                        <textarea style="resize: none;" class="form-control" name="medsup" id="medsup" disabled><?php echo $data['medsup'] ?></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="pod_nod" class="form-label">Physician/Nurse on Duty:</label>
                        <input type="text" class="form-control" name="pod_nod" value="<?= $data['pod_nod'] ?>" id="pod_nod" disabled>
                    </div>

                    <input type="text" class="form-control" name="patientid" value="<?php echo $patientid ?>" id="patientid" hidden>
                    <input type="text" class="form-control" name="patient" value="<?php echo $fullname ?>" id="patient" hidden>
                    <input type="text" class="form-control" name="sex" value="<?php echo $data['sex'] ?>" id="sex" hidden>
                    <input type="text" class="form-control" name="medsup" value="<?php echo $data['medsup'] ?>" id="medsup" hidden>
                    <input type="text" class="form-control" name="datetime" value="<?php echo $data['datetime'] ?>" id="datetime" hidden>
                </div>
                <div class="modal-footer">

                    <?php
                    if (!empty($data['medsup'])) { ?>
                        <input type="submit" class="btn btn-primary" value="Print Prescription"></input>
                    <?php } ?>
                    <input type="button" class="btn btn-primary" value="Print Treatment Record" onclick="window.open('reports/reports_treatment_record.php?patientid=<?= $data['patient'];?>')" target="_blank"></input>
                    <input type="reset" class="btn btn-danger" value="Close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </form>
        </div>
    </div>
</div>