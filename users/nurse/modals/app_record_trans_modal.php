<form action="add/record-app-trans.php" method="POST">
    <div class="modal fade" id="recordppointment<?php echo $data['id'] ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addtransaction">Appointment Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
                </div>
                <div class="modal-body">
                    <div class="default" id="defaultDiv">
                        <input type="text" name="id" value="<?= $data['id']; ?>" hidden>
                        
                        <?php
                        $id = $data['id'];
                        $sql = "SELECT a.id, a.chiefcomplaint, t.type, p.purpose, a.patient FROM appointment a INNER JOIN appointment_purpose p ON p.id=a.purpose INNER JOIN appointment_type t ON t.id=a.type WHERE a.id = '$id'";
                        $result = mysqli_query($conn, $sql);
                        foreach ($result as $row) {
                            $chief_complaint = $row['chiefcomplaint'];
                            $type = $row['type'];
                            $purpose = $row['purpose'];
                            $patientid = $row['patient'];
                        }
                        $sql = "SELECT * FROM patient_info p INNER JOIN account a ON a.accountid=p.patientid WHERE patientid = '$patientid'";
                        $result = mysqli_query($conn, $sql);
                        while ($grr = mysqli_fetch_array($result)) {
                            if (count(explode(" ", $grr['middlename'])) > 1) {
                                $middle = explode(" ", $grr['middlename']);
                                $letter = $middle[0][0] . $middle[1][0];
                                $middleinitial = $letter . ".";
                            } else {
                                $middle = $grr['middlename'];
                                if ($middle == "" or $middle == " ") {
                                    $middleinitial = "";
                                } else {
                                    $middleinitial = substr($middle, 0, 1) . ".";
                                }
                            }
                            $patient = ucwords(strtolower($grr['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($grr['lastname']));
                            $age = floor((time() - strtotime($grr['birthday'])) / 31556926);
                            $sex = $grr['sex'];
                            $designation = $grr['designation'];
                            $pys = $grr['program'] . " " . $grr['yearlevel'] . "-" . $grr['section'] . $grr['block'];
                        }
                    
                        ?>
                        <div class="col-md-6 mb-2">
                            <label for="id" class="form-label">Appointment ID:</label>
                            <input type="text" class="form-control" style="resize:none;" value="<?= $data['id'] ?>" name="idview" id="idview" disabled></input>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="patient" class="form-label">Patient:</label>
                                <input type="text" class="form-control" name="patient" value="<?= $patient ?>" id="patient" disabled>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="age" class="form-label">Age:</label>
                                <input type="text" class="form-control" name="age" value="<?= $age ?>" id="age" disabled>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="sex" class="form-label">Sex:</label>
                                <input type="text" class="form-control" name="sex" value="<?= $sex ?>" id="sex" disabled>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="designation" class="form-label">Designation:</label>
                                <input type="text" class="form-control" name="designation" value="<?= $designation ?>" id="designation" disabled>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="pys" class="form-label">Program, Year Level and Section:</label>
                                <input type="text" class="form-control" name="pys" value="<?= $pys ?>" id="pys" disabled>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label for="transaction" class="form-label">Type:</label>
                                <input type="text" class="form-control" name="type" value="<?= $type ?>" id="type" disabled>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="purpose" class="form-label">Request:</label>
                                <input type="text" class="form-control" name="purpose" value="<?= $purpose ?>" id="purpose" disabled>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label for="chief_complaint" class="form-label">Chief Complaints:</label>
                            <textarea class="form-control" style="resize:none;" name="chief_complaint" id="chief_complaint" disabled><?= $chief_complaint ?></textarea>
                        </div>

                        <div class="vitals" id="vitalsDiv">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label for="" class="form-label">Blood Pressure:</label>
                                    <input type="text" maxlength="7" class="form-control" name="bp" id="bp">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="form-label">Pulse Rate:</label>
                                    <input type="number" min="0" maxlength="4" class="form-control" name="pr" id="pr">
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="" class="form-label">Temperature:</label>
                                    <input type="text" maxlength="4" class="form-control" name="temp" id="temp">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Respiratory Rate:</label>
                                    <input type="number" min="0" maxlength="4" class="form-control" name="respiratory" id="respiratory">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Oxygen Saturation:</label>
                                    <input type="text" maxlength="4" class="form-control" name="oxygen" id="oxygen">
                                </div>
                            </div>
                        </div>

                        <!-- responsive pag others pinili lalabas additional na textbox-->
                        <div class="mb-2" id="fdDiv">
                            <label for="" class="form-label">Findings/Diagnosis:</label>
                            <select class="form-control" aria-label=".form-select-md example" name="findiag" id="findiag" onchange="enableFd(this)">
                                <option value="" disabled selected></option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM findiag ORDER BY findiag";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) { ?>
                                    <option value="<?= $row['findiag']; ?>"><?= $row['findiag']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2 hidden" id="fdOthersDiv">
                            <label for="" class="form-label">Others:</label>
                            <input type="text" class="form-control" name="findiag_others" id="findiag_others">
                        </div>
                        <div class="mb-2" id="remarksDiv">
                            <label for="" class="form-label">Remarks:</label>
                            <input type="text" class="form-control" name="remarks" id="remarks">
                        </div>
                        <div class="row duplicate_med">
                            <div class="col-md-8 mb-2">
                                <label for="" class="form-label">Medicine:</label>
                                <select class="form-select" aria-label=".form-select-md example" name="medicine[]" id="medicine">
                                    <option value="" selected></option>
                                    <?php
                                    $sql = "SELECT * FROM inv_total WHERE type = 'medicine' AND qty >= 0 AND campus='$campus' ORDER BY stock_name";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?= $row['stockid']; ?>"><?= $row['stock_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label">Quantity:</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="number" min="0" class="form-control" name="quantity_med[]">
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn btn-primary" onclick="duplicate_med()">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row duplicate_sup">
                            <div class="col-md-8 mb-2">
                                <label for="" class="form-label">Medical Supply:</label>
                                <select class="form-select" aria-label=".form-select-md example" name="supply[]" id="supply">
                                    <option value="" selected></option>
                                    <?php
                                    $sql = "SELECT * FROM inv_total WHERE type = 'supply' AND qty >= 0 AND campus='$campus' ORDER BY stock_name";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?= $row['stockid']; ?>"><?= $row['stock_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label">Quantity:</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="number" min="0" class="form-control" name="quantity_sup[]">
                                    </div>
                                    <div class="col">
                                        <button type="button" class="btn btn-primary" onclick="duplicate_sup()">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2" id="referralDiv">
                            <label for="" class="form-label">Referral:</label>
                            <input type="text" class="form-control" name="referral" id="referral">
                        </div>

                        <!-- responsive pag others pinili lalabas additional na textbox-->
                        <div class="mb-2" id="medCaseDiv">
                            <label for="" class="form-label">Medical Case:</label>
                            <select class="form-control" aria-label=".form-select-md example" name="medcase" id="medcase" onchange="enableMedCase(this)">
                                <option value="" disabled selected></option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM med_case ORDER BY type, medcase";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) { ?>
                                    <option value="<?= $row['medcase']; ?>"><?= "(" . ucfirst(strtolower($row['type'])) . ") " . $row['medcase']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2 hidden" id="medCaseOthersDiv">
                            <label for="" class="form-label">Others:</label>
                            <input type="text" class="form-control" name="medcase_others" id="medcase_others">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Record"></input>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    function duplicate_med() {
        var row = $('.duplicate_med').first().clone();
        row.find('button').removeClass('btn-primary').addClass('btn-danger').text('-').attr('onclick', 'remove_med(this)');
        $('.duplicate_med').last().after(row);
        // Increment the index for each duplicated input
        row.find('input[type="number"]').val(''); // Clear the value of the new input
        row.find('select[name="medicine[]"]').val(''); // Clear the value of the new select
    };

    function remove_med(btn) {
        $(btn).closest('.duplicate_med').remove();
    };

    function duplicate_sup() {
        var row = $('.duplicate_sup').first().clone();
        row.find('button').removeClass('btn-primary').addClass('btn-danger').text('-').attr('onclick', 'remove_sup(this)');
        $('.duplicate_sup').last().after(row);
        // Increment the index for each duplicated input
        row.find('input[type="number"]').val(''); // Clear the value of the new input
        row.find('select[name="supply[]"]').val(''); // Clear the value of the new select
    };

    function remove_sup(btn) {
        $(btn).closest('.duplicate_sup').remove();
    };

    function enableMedCase(answer) {
        console.log(answer.value);
        if (answer.value == 'Others:') {
            document.getElementById('medCaseOthersDiv').classList.remove('hidden');
        } else {
            document.getElementById('medCaseOthersDiv').classList.add('hidden');
        }
    };

    function enableFd(answer) {
        console.log(answer.value);
        if (answer.value == 'Others:') {
            document.getElementById('fdOthersDiv').classList.remove('hidden');
        } else {
            document.getElementById('fdOthersDiv').classList.add('hidden');
        }
    };
</script>