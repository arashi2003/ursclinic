<div class="modal fade" id="viewtrans<?php echo $data['id']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Medical Record</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="reports/reports_vitals.php" id="form" target="_blank">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="pr" class="form-label">Date and Time:</label>
                        <input type="text" class="form-control" name="datetime" value="<?php echo date("F d, Y",strtotime($data['datetime'])) . " | " . date("g:i A",strtotime($data['datetime'])) ?>" id="datetime" disabled>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="pr" class="form-label">Blood Pressure:</label>
                            <input type="text" class="form-control" name="bp" value="<?php echo $data['bp']?>" id="bp" disabled>
                        </div>
                        <div class="col mb-2">
                            <label for="pr" class="form-label">Pulse Rate:</label>
                            <input type="text" class="form-control" name="pr" value="<?php echo $data['pr']?>" id="pr" disabled>
                        </div>
                        <div class="col mb-2">
                            <label for="te" class="form-label">Temperature:</label>
                            <input type="text" class="form-control" name="temp" value="<?php echo $data['temp']?>" id="temp" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="pr" class="form-label">Respiratory Rate:</label>
                            <input type="text" class="form-control" name="respiratory" value="<?php echo $data['respiratory']?>" id="respiratory" disabled>
                        </div>
                        <div class="col mb-2">
                            <label for="pr" class="form-label">Oxygen Saturation:</label>
                            <input type="text" class="form-control" name="oxygen" value="<?php echo $data['oxygen_saturation']?>" id="oxygen" disabled>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="pr" class="form-label">Chief Complaints:</label>
                        <input type="text" class="form-control" name="cc" value="<?php echo $data['chief_complaint']?>" id="cc" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="pr" class="form-label">Findings/Diagnosis:</label>
                        <input type="text" class="form-control" name="findiag" value="<?php echo $data['findiag']?>" id="findiag" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="pr" class="form-label">Remarks:</label>
                        <input type="text" class="form-control" name="remarks" value="<?php echo $data['remarks']?>" id="remarks" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="referral" class="form-label">Referral:</label>
                        <input type="text" class="form-control" name="referral" value="<?php echo $data['referral']?>" id="referral" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="pr" class="form-label">Medical Case:</label>
                        <input type="text" class="form-control" name="medcase" value="<?php echo $data['medcase'] . " " . $data['medcase_others']?>" id="medcase" disabled>
                    </div>
                    <div class="mb-2">
                        <label for="pr" class="form-label">Physician/Nurse on Duty:</label>
                        <input type="text" class="form-control" name="pod_nod" value="<?php echo $data['pod_nod']?>" id="pod_nod" disabled>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="text" class="form-control" name="bp" value="<?php echo $data['bp']?>" hidden>
                    <input type="text" class="form-control" name="pr" value="<?php echo $data['pr']?>" hidden>
                    <input type="text" class="form-control" name="temp" value="<?php echo $data['temp']?>" hidden>
                    <input type="text" class="form-control" name="datetime" value="<?php echo $data['datetime']?>" hidden>
                    <input type="text" class="form-control" name="oxygen" value="<?php echo $data['oxygen_saturation']?>" hidden>
                    <input type="text" class="form-control" name="respiratory" value="<?php echo $data['respiratory']?>" hidden>
                    
                    <input type="text" class="form-control" name="cc" value="<?php echo $data['chief_complaint']?>" hidden>
                    <input type="text" class="form-control" name="findiag" value="<?php echo $data['findiag']?>" hidden>
                    <input type="text" class="form-control" name="remarks" value="<?php echo $data['remarks']?>" hidden>
                    <input type="text" class="form-control" name="referral" value="<?php echo $data['referral']?>" hidden>
                    <input type="text" class="form-control" name="pod_nod" value="<?php echo $data['pod_nod']?>" hidden>

                    <input type="text" class="form-control" name="patientid" value="<?php echo $data['patient']?>" hidden>
                    <input type="text" class="form-control" name="patient" value="<?php echo $fullname?>" hidden>
                    <input type="text" class="form-control" name="age" value="<?php echo $data['age']?>" hidden>
                    <input type="text" class="form-control" name="sex" value="<?php echo $data['sex']?>" hidden>
                    <input type="text" class="form-control" name="pys" value="<?php echo $data['program'] . " " . $data['yearlevel'] . "-" . $data['section'] . $data['block'] ?>" hidden>
                    <input type="submit" class="btn btn-primary" value="Print"></input>
                </div>
            </form>
        </div>
    </div>
</div>