<div class="modal fade" id="physician_set" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Appointment Physician</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/setnurse_appphysician.php" id="form">
                <div class="modal-body">
                    <label for="purpose" class="form-label">Appointment Purpose:</label>
                    <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="purpose" id="purpose" required>
                        <option value="" disabled selected>-Select Appointment Purpose-</option>
                        <?php
                        include('connection.php');
                        $sql = "SELECT p.id, t.type, p.purpose FROM appointment_purpose p INNER JOIN appointment_type t ON t.id=p.type ORDER BY type";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <option value="<?= $row['purpose']; ?>"><?= $row['type'] . ' - ' . $row['purpose']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="modal-body">
                    <label for="appcc" class="form-label">Physician:</label>
                    <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="physician" id="physician" required>
                        <option value="" disabled selected>-Select Physician-</option>
                        <option value="NONE">NONE</option>
                        <?php
                        include('connection.php');
                        $sql = "SELECT * FROM account WHERE usertype = 'DOCTOR' OR usertype = 'DENTIST'";
                        $result = mysqli_query($conn, $sql);
                        while ($data = mysqli_fetch_array($result)) {
                            if (count(explode(" ", $data['middlename'])) > 1) {
                                $middle = explode(" ", $data['middlename']);
                                $letter = $middle[0][0] . $middle[1][0];
                                $middleinitial = $letter . ".";
                            } else {
                                $middle = $data['middlename'];
                                if ($middle == "" or $middle == " ") {
                                    $middleinitial = "";
                                } else {
                                    $middleinitial = substr($middle, 0, 1) . ".";
                                }
                            }
                        ?>
                            <option value="<?= strtoupper(ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($data['lastname']))) ?>"><?= ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($data['lastname'])) ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add"></input>
                </div>
            </form>
        </div>
    </div>
</div>