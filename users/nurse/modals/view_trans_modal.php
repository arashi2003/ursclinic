<div class="modal fade" id="viewtrans<?php echo $data['id']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Record</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="reports/reports_medrecref.php" target="_blank" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="datetime" class="form-label">Date and Time:</label>
                        <input type="text" class="form-control" name="datetime" value="<?php echo date("F d, Y", strtotime($data['datetime'])) . " | " . date("g:i A", strtotime($data['datetime'])) ?>" id="datetime" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="transaction" class="form-label">Transaction:</label>
                        <input type="text" class="form-control" name="transaction" value="<?php echo $data['transaction'] ?>" id="transaction" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="purpose" class="form-label">Service:</label>
                        <input type="text" class="form-control" name="purpose" value="<?php echo $data['purpose'] ?>" id="purpose" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="chief_complaint" class="form-label">Chief Complaints:</label>
                        <input type="text" class="form-control" name="chief_complaint" value="<?php echo $data['chief_complaint'] ?>" id="chief_complaint" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="chief_complaint" class="form-label">Findings/Diagnosis:</label>
                        <input type="text" class="form-control" name="findiag" value="<?php echo $data['findiag'] ?>" id="findiag" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="remarks" class="form-label">Remarks:</label>
                        <input type="text" class="form-control" name="remarks" value="<?php echo $data['remarks'] ?>" id="remarks" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="referral" class="form-label">Referral:</label>
                        <input type="text" class="form-control" name="referral" value="<?php echo $data['referral'] ?>" id="referral" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="medsup" class="form-label">Issued Medicine/Medical Supplies:</label>
                        <input type="text" class="form-control" name="medsup" value="<?php echo $data['medsup'] ?>" id="medsup" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="pod_nod" class="form-label">Physician/Nurse on Duty:</label>
                        <input type="text" class="form-control" name="pod_nod" value="<?= $data['pod_nod'] ?>" id="pod_nod" disabled>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="text" class="form-control" name="medsup" value="<?php echo $data['medsup'] ?>" hidden>
                    <input type="text" class="form-control" name="cc" value="<?php echo $data['chief_complaint'] ?>" hidden>
                    <input type="text" class="form-control" name="findiag" value="<?php echo $data['findiag'] ?>" hidden>
                    <input type="text" class="form-control" name="remarks" value="<?php echo $data['remarks'] ?>" hidden>
                    <input type="text" class="form-control" name="referral" value="<?php echo $data['referral'] ?>" hidden>
                    <input type="text" class="form-control" name="pod_nod" value="<?php echo $data['pod_nod'] ?>" hidden>
                    <input type="text" class="form-control" name="datetime" value="<?php echo $data['datetime'] ?>" hidden>

                    <input type="text" class="form-control" name="patientid" value="<?php echo $data['patient'] ?>" hidden>
                    <input type="text" class="form-control" name="patient" value="<?php echo $fullname ?>" hidden>
                    <input type="text" class="form-control" name="age" value="<?php echo $data['age'] ?>" hidden>
                    <input type="text" class="form-control" name="sex" value="<?php echo $data['sex'] ?>" hidden>
                    <input type="text" class="form-control" name="pys" value="<?php echo $data['program'] . " " . $data['yearlevel'] . "-" . $data['section'] . $data['block'] ?>" hidden>
                    <input type="submit" class="btn btn-primary" value="Print"></input>
                </div>
            </form>
        </div>
    </div>
</div>