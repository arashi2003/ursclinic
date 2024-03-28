<div class="modal fade" id="recordppointment<?php echo $data['id'] ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Appointment Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="../add/record-app-medsup.php">
                <div class="modal-body">
                    <input type="text" name="id" value="<?= $data['id'] ?>" hidden>
                    <?php
                    $id = $data['id'];
                    $sql = "SELECT * FROM appointment a  INNER JOIN appointment_purpose p ON p.id=a.purpose INNER JOIN appointment_type t ON t.id=p.type WHERE a.id = '$id'";
                    $result = mysqli_query($conn, $sql);
                    foreach ($result as $row) {
                        $chief_complaint = $row['chiefcomplaint'];
                        $type = $row['type'];
                        $purpose = $row['purpose'];
                        $physician = $row['physician'];
                        $med_1 = $row['med_1'];
                        $mqty_1 = $row['mqty_1'];
                        $med_2 = $row['med_2'];
                        $mqty_2 = $row['mqty_2'];
                        $med_3 = $row['med_3'];
                        $mqty_3 = $row['mqty_3'];
                        $med_4 = $row['med_4'];
                        $mqty_4 = $row['mqty_4'];
                        $med_5 = $row['med_5'];
                        $mqty_5 = $row['mqty_5'];
                        $sup_1 = $row['sup_1'];
                        $sqty_1 = $row['sqty_1'];
                        $sup_2 = $row['sup_2'];
                        $sqty_2 = $row['sqty_2'];
                        $sup_3 = $row['sup_3'];
                        $sqty_3 = $row['sqty_3'];
                        $sup_4 = $row['sup_4'];
                        $sqty_4 = $row['sqty_4'];
                        $sup_5 = $row['sup_5'];
                        $sqty_5 = $row['sqty_5'];
                        $medsup0 = "";

                        if (!empty($med_1)) {
                            $sql = "SELECT * FROM inv_total WHERE stockid = '$med_1' AND type = 'medicine'";
                            $result = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($result)) {
                                $medicine = $data['stock_name'];
                                $medsup0 .= "$mqty_1 $medicine,";
                            }
                        } else {
                            $medsup0 .= "";
                        }
                        if (!empty($med_2)) {
                            $sql = "SELECT * FROM inv_total WHERE stockid = '$med_2' AND type = 'medicine'";
                            $result = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($result)) {
                                $medicine = $data['stock_name'];
                                $medsup0 .= "$mqty_2 $medicine,";
                            }
                        } else {
                            $medsup0 .= "";
                        }
                        if (!empty($med_3)) {
                            $sql = "SELECT * FROM inv_total WHERE stockid = '$med_3' AND type = 'medicine'";
                            $result = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($result)) {
                                $medicine = $data['stock_name'];
                                $medsup0 .= "$mqty_3 $medicine,";
                            }
                        } else {
                            $medsup0 .= "";
                        }
                        if (!empty($med_4)) {
                            $sql = "SELECT * FROM inv_total WHERE stockid = '$med_4' AND type = 'medicine'";
                            $result = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($result)) {
                                $medicine = $data['stock_name'];
                                $medsup0 .= "$mqty_4 $medicine,";
                            }
                        } else {
                            $medsup0 .= "";
                        }
                        if (!empty($med_5)) {
                            $sql = "SELECT * FROM inv_total WHERE stockid = '$med_5' AND type = 'medicine'";
                            $result = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($result)) {
                                $medicine = $data['stock_name'];
                                $medsup0 .= "$mqty_5 $medicine,";
                            }
                        } else {
                            $medsup0 .= "";
                        }
                        if (!empty($sup_1)) {
                            $sql = "SELECT * FROM inv_total WHERE stockid = '$sup_1' AND type = 'supply'";
                            $result = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($result)) {
                                $supply = $data['stock_name'];
                                $medsup0 .= "$sqty_1 $supply,";
                            }
                        } else {
                            $medsup0 .= "";
                        }
                        if (!empty($sup_2)) {
                            $sql = "SELECT * FROM inv_total WHERE stockid = '$sup_2' AND type = 'supply'";
                            $result = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($result)) {
                                $supply = $data['stock_name'];
                                $medsup0 .= "$sqty_2 $supply,";
                            }
                        } else {
                            $medsup0 .= "";
                        }
                        if (!empty($sup_3)) {
                            $sql = "SELECT * FROM inv_total WHERE stockid = '$sup_3' AND type = 'supply'";
                            $result = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($result)) {
                                $supply = $data['stock_name'];
                                $medsup0 .= "$sqty_3 $supply,";
                            }
                        } else {
                            $medsup0 .= "";
                        }
                        if (!empty($sup_4)) {
                            $sql = "SELECT * FROM inv_total WHERE stockid = '$sup_4' AND type = 'supply'";
                            $result = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($result)) {
                                $supply = $data['stock_name'];
                                $medsup0 .= "$sqty_4 $supply,";
                            }
                        } else {
                            $medsup0 .= "";
                        }
                        if (!empty($sup_5)) {
                            $sql = "SELECT * FROM inv_total WHERE stockid = '$sup_5' AND type = 'supply'";
                            $result = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($result)) {
                                $supply = $data['stock_name'];
                                $medsup0 .= "$sqty_5 $supply,";
                            }
                        } else {
                            $medsup0 .= "";
                        }

                        //$medsup1 = implode(", ", $medsup0);
                        $medsup = rtrim($medsup0, " , ");
                    }
                    ?>
                    <div class="col-md-6 mb-2">
                        <label for="id" class="form-label">Appointment ID:</label>
                        <input type="text" class="form-control" style="resize:none;" value="<?= $id ?>" name="idview" id="idview" disabled></input>
                    </div>
                    <div class="row">
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
                    <div class="mb-2">
                        <label for="medsup" class="form-label">Medicine/Medical Supplies:</label>
                        <textarea type="text" style="resize:none;" class="form-control" name="medsup" id="medsup" disabled><?= $medsup ?></textarea>
                    </div>
                    <div class="mb-2">
                        <label for="pod_nod" class="form-label">Physician/Nurse:</label>
                        <input type="text" class="form-control" name="pod_nod" value="<?= $physician ?>" id="pod_nod" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Record"></input>
                </div>
            </form>
        </div>
    </div>
</div>