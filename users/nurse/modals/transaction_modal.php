<div class="modal fade" id="addtransaction" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Transaction</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../nurse/transaction_history.php'"></button>
            </div>
            <form method="POST" action="" id="form">
                <div class="modal-body">
                    <div class="patient_info hidden"> 
                        <div class="row">
                            <div class="mb-2">
                                <label for="patientid" class="form-label">Patient ID:</label>
                                <input type="text" class="form-control" name="patientid" id="patientid" onchange="fetchPatientData()">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">First Name:</label>
                                <input type="text" maxlength="45" class="form-control" name="firstname" id="firstname" required>
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Middle Name:</label>
                                <input type="text" maxlength="45" class="form-control" name="middlename" id="middlename">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Last Name:</label>
                                <input type="text" maxlength="45" class="form-control" name="lastname" id="lastname" required>
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Designation:</label>
                                <select class="form-control" aria-label=".form-select-md example" name="designation" id="designation" required>
                                    <option value="" disabled selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM designation ORDER BY designation";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) { ?>
                                        <option value="<?= $row['designation']; ?>"><?= $row['designation']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Age:</label>
                                <input type="text" maxlength="3" class="form-control" name="age" id="age" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Sex:</label>
                                <select class="form-control" aria-label=".form-select-md example" name="sex" id="sex" required>
                                    <option value="" disabled selected></option>
                                    <option value="MALE">MALE</option>
                                    <option value="FEMALE">FEMALE</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-2">
                                <label for="" class="form-label">Department:</label>
                                <select class="form-control" aria-label=".form-select-md example" name="department" id="department" required>
                                    <option value="" disabled selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM department ORDER BY department";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) { ?>
                                        <option value="<?= $row['department']; ?>"><?= $row['department']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">College:</label>
                                <select class="form-control" aria-label=".form-select-md example" name="college" id="college">
                                    <option value="" selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM college ORDER BY college";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) { ?>
                                        <option value="<?= $row['college']; ?>"><?= $row['college']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Program:</label>
                                <select class="form-control" aria-label=".form-select-md example" name="program" id="program">
                                    <option value="" selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM program ORDER BY program";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) { ?>
                                        <option value="<?= $row['abbrev']; ?>"><?= $row['program']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Year Level:</label>
                                <select class="form-control" aria-label=".form-select-md example" name="yearlevel" id="yearlevel">
                                    <option value="" selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM yearlevel ORDER BY yearlevel";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) { ?>
                                        <option value="<?= $row['yearlevel']; ?>"><?= $row['yearlevel']; ?></option>
                                    <?php } ?>
                                </select>
                                </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Section:</label>
                                <input type="text" class="form-control" name="section" id="section">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Block:</label>
                                <input type="text" class="form-control" name="block" id="block">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="" class="form-label">Birthday:</label>
                                <input type="date" class="form-control" name="birthday" id="birthday" required>
                            </div>
                        </div>
                    </div>

                    <div class="default hidden">
                        <form method="POST" action="add/transaction.php" id="form">
                            <div class="row">
                                <div class="mb-2">
                                    <label for="" class="form-label">Transaction:</label>
                                    <input type="text" class="form-control" name="transaction" value="Walk-In" hidden>
                                    <select class="form-control" aria-label=".form-select-md example" name="service" id="service">
                                        <option value="" disabled selected></option>
                                        <?php
                                        include('connection.php');
                                        $sql = "SELECT DISTINCT service FROM transaction WHERE transaction_type = 'Walk-In' ORDER BY service";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_array($result)) { ?>
                                            <option value="<?= $row['service']; ?>"><?= $row['service']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <!-- responsive pag others pinili lalabas additional na textbox-->
                            <div class="mb-2">
                                <label for="" class="form-label">Chief Complaints:</label>
                                <select class="form-control" aria-label=".form-select-md example" name="chief_complaint" id="chief_complaint">
                                    <option value="" disabled selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM chief_complaint ORDER BY chief_complaint";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) { ?>
                                        <option value="<?= $row['chief_complaint']; ?>"><?= $row['chief_complaint']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Others:</label>
                                <input type="text" class="form-control" name="chief_complaint_others" id="chief_complaint_others">
                            </div>
                            <!-- responsive pag others pinili lalabas additional na textbox-->
                            <div class="mb-2">
                                <label for="" class="form-label">Findings/Diagnosis:</label>
                                <select class="form-control" aria-label=".form-select-md example" name="findiag" id="findiag">
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
                            <div class="mb-2">
                                <label for="" class="form-label">Others:</label>
                                <input type="text" class="form-control" name="findiag_others" id="findiag_others">
                            </div>
                            <div class="mb-2">
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
                            <div class="mb-2">
                                <label for="" class="form-label">Referral:</label>
                                <input type="text" class="form-control" name="referral" id="referral">
                            </div>

                            <!-- responsive pag others pinili lalabas additional na textbox-->
                            <div class="mb-2">
                                <label for="" class="form-label">Medical Case:</label>
                                <select class="form-control" aria-label=".form-select-md example" name="medcase" id="medcase" required>
                                    <option value="" disabled selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM med_case ORDER BY type, medcase";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) { ?>
                                        <option value="<?= $row['id']; ?>"><?= "(" . ucfirst(strtolower($row['type'])) . ") " . $row['medcase']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Others:</label>
                                <input type="text" class="form-control" name="medcase_others" id="medcase_others">
                                <input type="text" class="form-control" name="type" value="Walk-In" id="type" hidden>
                                <input type="text" class="form-control" name="transaction" value="Walk-In" id="transaction" hidden>
                            </div>
                        </form>
                    </div>

                    <div class="medhist hidden">
                        <form method="POST" action="add/transaction_medhist.php" id="form">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Height (cm):</label>
                                    <input type="number" min="0" maxlength="7" class="form-control" name="height" id="height" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Weight:</label>
                                    <input type="text" maxlength="7" class="form-control" name="weight" id="weight" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Blood Pressure:</label>
                                    <input type="text" maxlength="7" class="form-control" name="bp" id="bp" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Pulse Rate:</label>
                                    <input type="number" min="0" maxlength="3" class="form-control" name="pr" id="pr" required>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Temperature:</label>
                                    <input type="text" maxlength="4" class="form-control" name="temp" id="temp" required>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="mb-2">
                                    <label for="" class="form-label">H.E.E.N.T.:</label>
                                    <input type="text" maxlength="65" class="form-control" name="heent" id="heent" required>
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">Chest/Lungs:</label>
                                    <input type="text" maxlength="65" class="form-control" name="chest_lungs" id="chest_lungs" required>
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">Heart:</label>
                                    <input type="text" maxlength="65" class="form-control" name="heart" id="heart" required>
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">Abdomen:</label>
                                    <input type="text" maxlength="65" class="form-control" name="abdomen" id="abdomen" required>
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">Extremities:</label>
                                    <input type="text" maxlength="65" class="form-control" name="extremities" id="extremities" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Last Menstrual Period:</label>
                                    <input type="date" class="form-control" name="lmp" id="lmp">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Bronchial Asthma:</label>
                                    <input type="date" class="form-control" name="bronchial_asthma" id="bronchial_asthma">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Surgery:</label>
                                    <input type="date" class="form-control" name="surgery" id="" surgery>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Heart Disease:</label>
                                    <input type="date" class="form-control" name="heart_disease" id="heart_disease">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Allergies:</label>
                                    <input type="date" class="form-control" name="allergies" id="allergies">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Epilepsy:</label>
                                    <input type="date" class="form-control" name="epilepsy" id="epilepsy">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="" class="form-label">Hernia:</label>
                                    <input type="date" class="form-control" name="hernia" id="hernia">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-2">
                                    <input type="text" id="ddefects" name="ddefects" value="" hidden>
                                    <input type="checkbox" id="ddefects" name="ddefects" value="x">
                                    <label for="ddefects"> No Dental Defects</label>
                                </div>
                                <div class="mb-2">
                                    <input type="text" id="dcs" name="dcs" value="" hidden>
                                    <input type="checkbox" id="dcs" name="dcs" value="x">
                                    <label for="dcs"> Presence of Oral Debris, Calculi (tartar) deposits, Stains/discoloration</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-2">
                                    <input type="text" id="gp" name="gp" value="" hidden>
                                    <input type="checkbox" id="gp" name="gp" value="x">
                                    <label for="gp"> Presence of GINGIVITIS and/or PERIODONTITIS</label>
                                </div>
                                <div class="mb-2">
                                    <input type="text" id="scaling_polish" name="scaling_polish" value="" hidden>
                                    <input type="checkbox" id="scaling_polish" name="scaling_polish" value="x">
                                    <label for="scaling_polish"> For Tooth Scaling and Polishing</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-2">
                                    <label for="" class="form-label">Other Dento-Facial Findings:</label>
                                    <input type="text" maxlength="45" class="form-control" name="dento_facial" id="dento_facial">
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">Remarks:</label>
                                    <input type="text" class="form-control" name="remarks" id="remarks">
                                </div>
                                <div class="mb-2">
                                    <label for="" class="form-label">Recommendation:</label>
                                    <input type="text" class="form-control" name="referral" id="referral">
                                </div>
                            </div>

                            <!-- responsive pag others pinili lalabas additional na textbox-->
                            <div class="mb-2">
                                <label for="" class="form-label">Medical Case:</label>
                                <select class="form-control" aria-label=".form-select-md example" name="medcase" id="medcase" required>
                                    <option value="" disabled selected></option>
                                    <?php
                                    include('connection.php');
                                    $sql = "SELECT * FROM med_case ORDER BY type, medcase";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) { ?>
                                        <option value="<?= $row['id']; ?>"><?= "(" . ucfirst(strtolower($row['type'])) . ") " . $row['medcase']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Others:</label>
                                <input type="text" maxlength="45" class="form-control" name="medcase_others" id="medcase_others">
                                <input type="text" class="form-control" value="Walk-In" name="type" hidden>
                                <input type="text" class="form-control" value="Checkup" name="transaction" hidden>
                                <input type="text" class="form-control" value="Medical History" name="service" hidden>
                            </div>
                        </form>
                    </div>

                    <div class="vitals">
                        <form method="POST" action="add/transaction_vitals.php" id="form">
                        <!-- responsive pag others pinili lalabas additional na textbox-->
                        <div class="mb-2">
                            <label for="" class="form-label">Chief Complaints:</label>
                            <select class="form-control" aria-label=".form-select-md example" name="chief_complaint" id="chief_complaint">
                                <option value="" selected></option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM chief_complaint ORDER BY chief_complaint";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) { ?>
                                    <option value="<?= $row['chief_complaint']; ?>"><?= $row['chief_complaint']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="" class="form-label">Others:</label>
                            <input type="text" class="form-control" name="chief_complaint_others" id="chief_complaint_others">
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label">Blood Pressure:</label>
                                <input type="text" maxlength="7" class="form-control" name="bp" id="bp" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label">Pulse Rate:</label>
                                <input type="number" min="0" maxlength="3" class="form-control" name="pr" id="pr" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label">Temperature:</label>
                                <input type="text" maxlength="3" class="form-control" name="temp" id="temp" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label">Respiratory Rate:</label>
                                <input type="number" min="0" maxlength="3" class="form-control" name="respiratory" id="respiratory" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="" class="form-label">Oxygen Saturation:</label>
                                <input type="text" maxlength="4" class="form-control" name="oxygen" id="oxygen" required>
                            </div>
                        </div>

                        <!-- responsive pag others pinili lalabas additional na textbox-->
                        <div class="mb-2">
                            <label for="" class="form-label">Findings/Diagnosis:</label>
                            <select class="form-control" aria-label=".form-select-md example" name="findiag" id="findiag">
                                <option value="" selected></option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM findiag ORDER BY findiag";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) { ?>
                                    <option value="<?= $row['findiag']; ?>"><?= $row['findiag']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="" class="form-label">Others:</label>
                            <input type="text" class="form-control" name="findiag_others" id="findiag_others">
                        </div>
                        <div class="mb-2">
                            <label for="" class="form-label">Remarks:</label>
                            <input type="text" class="form-control" name="remarks" id="remarks">
                        </div>
                        <div class="mb-2">
                            <label for="" class="form-label">Referral:</label>
                            <input type="text" class="form-control" name="referral" id="referral">
                        </div>

                        <!-- responsive pag others pinili lalabas additional na textbox-->
                        <div class="mb-2">
                            <label for="" class="form-label">Medical Case:</label>
                            <select class="form-control" aria-label=".form-select-md example" name="medcase" id="medcase" required>
                                <option value="" disabled selected></option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM med_case ORDER BY type, medcase";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) { ?>
                                    <option value="<?= $row['id']; ?>"><?= "(" . ucfirst(strtolower($row['type'])) . ") " . $row['medcase']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label for="" class="form-label">Others:</label>
                            <input type="text" class="form-control" name="medcase_others" id="medcase_others">
                            <input type="text" class="form-control" name="service" value="Vitals" hidden>
                            <input type="text" class="form-control" name="type" value="Checkup" hidden>
                            <input type="text" class="form-control" name="transaction" value="Walk-In" hidden>
                        </div>
                        </form>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Record"></input>
                    <input type="reset" class="btn btn-danger" value="Cancel"></input>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function duplicate_med() {
        var row = $('.duplicate_med').first().clone();
        row.find('button').removeClass('btn-primary').addClass('btn-danger').text('-').attr('onclick', 'remove_med(this)');
        $('.duplicate_med').last().after(row);
        // Increment the index for each duplicated input
        row.find('input[type="number"]').val(''); // Clear the value of the new input
        row.find('select[name="medicine[]"]').val(''); // Clear the value of the new select
    }

    function remove_med(btn) {
        $(btn).closest('.duplicate_med').remove();
    }

    function duplicate_sup() {
        var row = $('.duplicate_sup').first().clone();
        row.find('button').removeClass('btn-primary').addClass('btn-danger').text('-').attr('onclick', 'remove_sup(this)');
        $('.duplicate_sup').last().after(row);
        // Increment the index for each duplicated input
        row.find('input[type="number"]').val(''); // Clear the value of the new input
        row.find('select[name="supply[]"]').val(''); // Clear the value of the new select
    }

    function remove_sup(btn) {
        $(btn).closest('.duplicate_sup').remove();
    }
</script>

<script>
    function fetchPatientData() {
        var patientId = document.getElementById('patientid').value;
        if (patientId.trim() !== '') {
            // Perform AJAX request to fetch patient data
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'add/get_patientid.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Process the response
                        var response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            // Display Bootstrap form validation error message
                            document.getElementById('patientid').classList.add('is-invalid');
                            document.getElementById('patientid').setCustomValidity(response.error);
                            document.getElementById('patientid').reportValidity();
                        } else {
                            // Update form fields with fetched patient data
                            document.getElementById('firstname').value = response.firstname;
                            document.getElementById('middlename').value = response.middlename;
                            document.getElementById('lastname').value = response.lastname;
                            document.getElementById('designation').value = response.designation;
                            document.getElementById('age').value = response.age;
                            document.getElementById('sex').value = response.sex;
                            document.getElementById('department').value = response.department;
                            document.getElementById('college').value = response.college;
                            document.getElementById('program').value = response.program;
                            document.getElementById('yearlevel').value = response.yearlevel;
                            document.getElementById('section').value = response.section;
                            document.getElementById('block').value = response.block;

                            // Reset form validation state
                            document.getElementById('patientid').classList.remove('is-invalid');
                            document.getElementById('patientid').setCustomValidity('');
                        }
                    } else {
                        // Handle error if AJAX request fails
                        console.error('Error: Unable to fetch patient data');
                    }
                }
            };
            xhr.send('action=fetch_patient_data&patientid=' + encodeURIComponent(patientId));
        } else {
            // Clear form fields if patient ID is empty
            // Also reset form validation state
            document.getElementById('firstname').value = '';
            document.getElementById('middlename').value = '';
            document.getElementById('lastname').value = '';
            document.getElementById('designation').value = '';
            document.getElementById('age').value = '';
            document.getElementById('sex').value = '';
            document.getElementById('department').value = '';
            document.getElementById('college').value = '';
            document.getElementById('program').value = '';
            document.getElementById('yearlevel').value = '';
            document.getElementById('section').value = '';
            document.getElementById('block').value = '';
            document.getElementById('patientid').classList.remove('is-invalid');
            document.getElementById('patientid').setCustomValidity('');
        }
    }
</script>