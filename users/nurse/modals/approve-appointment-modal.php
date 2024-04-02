<div class="modal fade" id="approveappointment<?php echo $id ?>" tabindex="-1" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Appointment Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="modals/approve-appointment.php">
                <div class="modal-body">
                    <input type="text" name="id" value="<?= $id = $data['id'] ?>" hidden>
                    <input type="text" name="name"
                        value="<?php echo ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname'])) ?>"
                        hidden>
                    <input type="text" name="date" value="<?php echo date("F d, Y", strtotime($data['date'])) ?>"
                        hidden>
                    <input type="text" name="time"
                        value="<?php echo date("g:i A", strtotime($data['time_from'])) . " - " . date("g:i A", strtotime($data['time_to'])) ?>"
                        hidden>
                    <input type="text" name="email" value="<?= $data['email'] ?>" hidden>
                    <input type="text" name="physician" value="<?= $physician ?>" hidden>
                    <div class="col-md-6 mb-2">
                        <label for="id" class="form-label">Appointment ID:</label>
                        <input type="text" class="form-control" style="resize:none;" value="<?= $id ?>" name="id"
                            id="id" disabled></input>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="transaction" class="form-label">Type:</label>
                            <input type="text" class="form-control" name="type" value="<?= $type ?>" id="type" disabled>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="purpose" class="form-label">Request:</label>
                            <input type="text" class="form-control" name="purpose" value="<?= $purpose ?>" id="purpose"
                                disabled>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="chief_complaint" class="form-label">Chief Complaints:</label>
                        <textarea class="form-control" style="resize:none;" name="chief_complaint" id="chief_complaint"
                            disabled><?= $chief_complaint ?></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="medsup" class="form-label">Medicine/Medical Supplies:</label>
                        <textarea type="text" style="resize:none;" class="form-control" name="medsup" id="medsup"
                            disabled><?= $medsup ?></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="pod_nod" class="form-label">Physician/Nurse:</label>
                        <input type="text" class="form-control" name="pod_nod" value="<?= $physician ?>" id="pod_nod"
                            disabled>
                    </div>
                </div>
                <div class="mb-2">
                    <?php
                    $apdate = $data['date'];
                    $boop = "SELECT count(id) FROM appointment WHERE physician = '$physician' AND date = '$apdate' AND status = 'APPROVED'";
                    $result = mysqli_query($conn, $boop);
                    while ($brr = mysqli_fetch_array($result)) {
                        $num_app = $brr['count(id)'];
                    }
                    $boop = "SELECT maxp FROM schedule WHERE name = '$physician' AND date = '$apdate'";
                    $result = mysqli_query($conn, $boop);
                    while ($grr = mysqli_fetch_array($result)) {
                        $maxp = $grr['maxp'];
                    }
                    if ($num_app >= $maxp) {
                        echo "<br><b><i>Notice:</i></b> The maximum patients for this day has been reached.";
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Approve"></input>
                </div>
            </form>
        </div>
    </div>
</div>