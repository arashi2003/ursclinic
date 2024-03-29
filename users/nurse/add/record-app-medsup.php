<?php
session_start();
include('../../../connection.php');

// Patient info
$id = $_POST['id'];

$sql = "SELECT * FROM appointment WHERE id='$id'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)) {
    $patientid = $row['patientid'];
    $patient = $row['patient'];
    $transaction = $row['type'];
    $purpose = $row['purpose'];
    $chief_complaint = $row['chiefcomplaint'] . " " . $row['others'];
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

    $sql = "SELECT * FROM patient_info WHERE patientid='$patientid'";
    $result = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_array($result)) {
        $firstname = strtoupper($data['firstname']);
        $middlename = strtoupper($data['middlename']);
        $lastname = strtoupper($data['lastname']);
        $designation = strtoupper($data['designation']);
        $age = floor((time() - strtotime($data['birthday'])) / 31556926);
        $sex = strtoupper($data['sex']);
        $birthday = date("Y-m-d", strtotime($data['birthday']));
        $department = $data['department'];
        $college = $data['college'];
        $program = $data['program'];
        $yearlevel = $data['yearlevel'];
        $section = $data['section'];
        $block = strtoupper($data['block']);
    }
}


$user = $_SESSION['userid'];
$campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$au_status = "unread";
$activity = 'added a appointment record for  of ' . $patientid;
$pod_nod = $fullname;

// Logbook info
$type = "Appointment";
$datenow = date("Y-m-d");
$enddate = date("Y-m-t");

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

$med_case = $transaction;
$sql = "SELECT * FROM med_case WHERE medcase='$med_case'";
$result = mysqli_query($conn, $sql);
while ($data = mysqli_fetch_array($result)) {
    if ($data['medcase'] != 'Others:') {
        $medcase =  $data['medcase'];
        $medcase_type = $data['type'];
        $medcase_others = $purpose;
    } else {
        $medcase_type = "others";
        $medcase_others = $transaction;
        $medcase = $purpose;
    }
}

// Insert transaction history
$query = "INSERT INTO appointment?tab=approved (patient, firstname, middlename, lastname, designation, age, sex, department, college, program, yearlevel, section, block, type, transaction, purpose,  bp, pr, temp, respiratory, oxygen_saturation, chief_complaint, findiag, remarks, referral, medsup, pod_nod, medcase, medcase_others, campus, datetime) VALUES ('$patientid', '$firstname', '$middlename', '$lastname', '$designation', '$age', '$sex', '$department', '$college', '$program', '$yearlevel', '$section', '$block', '$type', '$transaction', '$purpose', '$chief_complaint', '$medsup', '$pod_nod', '$medcase', '$medcase_others', '$campus', now())";
$result = mysqli_query($conn, $query);

// Update inventory for each medicine
if (!empty($med_1)) {
    $medicine = $med_1;
    $quantity_med = $mqty_1;
    if ($medicine != "") {
        $query5 = "SELECT state FROM medicine WHERE medid = '$medicine'";
        $result = mysqli_query($conn, $query5);
        while ($data = mysqli_fetch_array($result)) {
            $mstate = $data['state'];
        }
        if ($mstate == 'per piece') {
            // Update inventory_medicine
            $query0 = "UPDATE inventory_medicine SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE campus='$campus' AND medid='$medicine' AND expiration > '$datenow' AND qty > 0";
            mysqli_query($conn, $query0);
            // Update inv_total
            $query1 = "UPDATE inv_total SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE stockid='$medicine' AND type = 'medicine' AND campus='$campus'";
            mysqli_query($conn, $query1);
            // Update inventory
            $query2 = "UPDATE inventory SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE campus='$campus' AND stock_type='medicine' AND stockid='$medicine' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
            mysqli_query($conn, $query2);
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$medicine' AND type = 'medicine' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($row = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $quantity_med;
                $eqty = $row['eqty'] - $qty;
                $aeqty = $row['iqty'];

                $query3 = "SELECT * FROM inv_total WHERE stockid = '$medicine' AND type = 'medicine' AND campus = '$campus'";
                $result = mysqli_query($conn, $query3);
                while ($data = mysqli_fetch_assoc($result)) {
                    $cost = $data['unit_cost'];
                }
                $aeamt = $eqty * $cost;
                $iamt = ($aeqty + $qty) * $cost;
                $query4 = "UPDATE report_medsupinv SET iqty = iqty + '$qty', iamt = '$iamt', eqty = eqty - '$qty', eamt = '$aeamt' WHERE medid = '$medicine' AND date = '$enddate' AND type = 'medicine' AND campus = '$campus'";
                mysqli_query($conn, $query4);
            }
        }
    }
}

if (!empty($med_2)) {
    $medicine = $med_2;
    $quantity_med = $mqty_2;
    if ($medicine != "") {
        $query5 = "SELECT state FROM medicine WHERE medid = '$medicine'";
        $result = mysqli_query($conn, $query5);
        while ($data = mysqli_fetch_array($result)) {
            $mstate = $data['state'];
        }
        if ($mstate == 'per piece') {
            // Update inventory_medicine
            $query0 = "UPDATE inventory_medicine SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE campus='$campus' AND medid='$medicine' AND expiration > '$datenow' AND qty > 0";
            mysqli_query($conn, $query0);
            // Update inv_total
            $query1 = "UPDATE inv_total SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE stockid='$medicine' AND type = 'medicine' AND campus='$campus'";
            mysqli_query($conn, $query1);
            // Update inventory
            $query2 = "UPDATE inventory SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE campus='$campus' AND stock_type='medicine' AND stockid='$medicine' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
            mysqli_query($conn, $query2);
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$medicine' AND type = 'medicine' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($row = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $quantity_med;
                $eqty = $row['eqty'] - $qty;
                $aeqty = $row['iqty'];

                $query3 = "SELECT * FROM inv_total WHERE stockid = '$medicine' AND type = 'medicine' AND campus = '$campus'";
                $result = mysqli_query($conn, $query3);
                while ($data = mysqli_fetch_assoc($result)) {
                    $cost = $data['unit_cost'];
                }
                $aeamt = $eqty * $cost;
                $iamt = ($aeqty + $qty) * $cost;
                $query4 = "UPDATE report_medsupinv SET iqty = iqty + '$qty', iamt = '$iamt', eqty = eqty - '$qty', eamt = '$aeamt' WHERE medid = '$medicine' AND date = '$enddate' AND type = 'medicine' AND campus = '$campus'";
                mysqli_query($conn, $query4);
            }
        }
    }
}

if (!empty($med_3)) {
    $medicine = $med_3;
    $quantity_med = $mqty_3;
    if ($medicine != "") {
        $query5 = "SELECT state FROM medicine WHERE medid = '$medicine'";
        $result = mysqli_query($conn, $query5);
        while ($data = mysqli_fetch_array($result)) {
            $mstate = $data['state'];
        }
        if ($mstate == 'per piece') {
            // Update inventory_medicine
            $query0 = "UPDATE inventory_medicine SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE campus='$campus' AND medid='$medicine' AND expiration > '$datenow' AND qty > 0";
            mysqli_query($conn, $query0);
            // Update inv_total
            $query1 = "UPDATE inv_total SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE stockid='$medicine' AND type = 'medicine' AND campus='$campus'";
            mysqli_query($conn, $query1);
            // Update inventory
            $query2 = "UPDATE inventory SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE campus='$campus' AND stock_type='medicine' AND stockid='$medicine' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
            mysqli_query($conn, $query2);
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$medicine' AND type = 'medicine' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($row = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $quantity_med;
                $eqty = $row['eqty'] - $qty;
                $aeqty = $row['iqty'];

                $query3 = "SELECT * FROM inv_total WHERE stockid = '$medicine' AND type = 'medicine' AND campus = '$campus'";
                $result = mysqli_query($conn, $query3);
                while ($data = mysqli_fetch_assoc($result)) {
                    $cost = $data['unit_cost'];
                }
                $aeamt = $eqty * $cost;
                $iamt = ($aeqty + $qty) * $cost;
                $query4 = "UPDATE report_medsupinv SET iqty = iqty + '$qty', iamt = '$iamt', eqty = eqty - '$qty', eamt = '$aeamt' WHERE medid = '$medicine' AND date = '$enddate' AND type = 'medicine' AND campus = '$campus'";
                mysqli_query($conn, $query4);
            }
        }
    }
}

if (!empty($med_4)) {
    $medicine = $med_4;
    $quantity_med = $mqty_4;
    if ($medicine != "") {
        $query5 = "SELECT state FROM medicine WHERE medid = '$medicine'";
        $result = mysqli_query($conn, $query5);
        while ($data = mysqli_fetch_array($result)) {
            $mstate = $data['state'];
        }
        if ($mstate == 'per piece') {
            // Update inventory_medicine
            $query0 = "UPDATE inventory_medicine SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE campus='$campus' AND medid='$medicine' AND expiration > '$datenow' AND qty > 0";
            mysqli_query($conn, $query0);
            // Update inv_total
            $query1 = "UPDATE inv_total SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE stockid='$medicine' AND type = 'medicine' AND campus='$campus'";
            mysqli_query($conn, $query1);
            // Update inventory
            $query2 = "UPDATE inventory SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE campus='$campus' AND stock_type='medicine' AND stockid='$medicine' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
            mysqli_query($conn, $query2);
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$medicine' AND type = 'medicine' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($row = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $quantity_med;
                $eqty = $row['eqty'] - $qty;
                $aeqty = $row['iqty'];

                $query3 = "SELECT * FROM inv_total WHERE stockid = '$medicine' AND type = 'medicine' AND campus = '$campus'";
                $result = mysqli_query($conn, $query3);
                while ($data = mysqli_fetch_assoc($result)) {
                    $cost = $data['unit_cost'];
                }
                $aeamt = $eqty * $cost;
                $iamt = ($aeqty + $qty) * $cost;
                $query4 = "UPDATE report_medsupinv SET iqty = iqty + '$qty', iamt = '$iamt', eqty = eqty - '$qty', eamt = '$aeamt' WHERE medid = '$medicine' AND date = '$enddate' AND type = 'medicine' AND campus = '$campus'";
                mysqli_query($conn, $query4);
            }
        }
    }
}

if (!empty($med_5)) {
    $medicine = $med_5;
    $quantity_med = $mqty_5;
    if ($medicine != "") {
        $query5 = "SELECT state FROM medicine WHERE medid = '$medicine'";
        $result = mysqli_query($conn, $query5);
        while ($data = mysqli_fetch_array($result)) {
            $mstate = $data['state'];
        }
        if ($mstate == 'per piece') {
            // Update inventory_medicine
            $query0 = "UPDATE inventory_medicine SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE campus='$campus' AND medid='$medicine' AND expiration > '$datenow' AND qty > 0";
            mysqli_query($conn, $query0);
            // Update inv_total
            $query1 = "UPDATE inv_total SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE stockid='$medicine' AND type = 'medicine' AND campus='$campus'";
            mysqli_query($conn, $query1);
            // Update inventory
            $query2 = "UPDATE inventory SET closed = closed - '$quantity_med', qty = qty - '$quantity_med' WHERE campus='$campus' AND stock_type='medicine' AND stockid='$medicine' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
            mysqli_query($conn, $query2);
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$medicine' AND type = 'medicine' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($row = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $quantity_med;
                $eqty = $row['eqty'] - $qty;
                $aeqty = $row['iqty'];

                $query3 = "SELECT * FROM inv_total WHERE stockid = '$medicine' AND type = 'medicine' AND campus = '$campus'";
                $result = mysqli_query($conn, $query3);
                while ($data = mysqli_fetch_assoc($result)) {
                    $cost = $data['unit_cost'];
                }
                $aeamt = $eqty * $cost;
                $iamt = ($aeqty + $qty) * $cost;
                $query4 = "UPDATE report_medsupinv SET iqty = iqty + '$qty', iamt = '$iamt', eqty = eqty - '$qty', eamt = '$aeamt' WHERE medid = '$medicine' AND date = '$enddate' AND type = 'medicine' AND campus = '$campus'";
                mysqli_query($conn, $query4);
            }
        }
    }
}

// Update inventory for each supply
if (!empty($sup_1)) {
    $supply = $sup_1;
    $quantity_sup = $sqty_1;
    if ($supply != "") {
        $query5 = "SELECT state FROM supply WHERE supid = '$supply'";
        $result = mysqli_query($conn, $query5);
        while ($data = mysqli_fetch_array($result)) {
            $sstate = $data['state'];
        }

        if ($sstate == 'per piece') {
            // Update inventory_supply
            $query0 = "UPDATE inventory_supply SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE campus='$campus' AND supid='$supply' AND expiration > '$datenow' AND qty > 0";
            mysqli_query($conn, $query0);
            // Update inv_total
            $query1 = "UPDATE inv_total SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE stockid='$supply' AND type = 'supply' AND campus='$campus'";
            mysqli_query($conn, $query1);
            // Update inventory
            $query2 = "UPDATE inventory SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE campus='$campus' AND stock_type='supply' AND stockid='$supply' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
            mysqli_query($conn, $query2);
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$supply' AND type = 'supply' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($data = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $quantities_sup;
                $eqty = $row['eqty'] - $qty;
                $aeqty = $row['iqty'];

                $query3 = "SELECT * FROM inv_total WHERE stockid = '$supply' AND type = 'supply' AND campus = '$campus'";
                $result = mysqli_query($conn, $query3);
                while ($data = mysqli_fetch_assoc($result)) {
                    $cost = $data['unit_cost'];
                }
                $aeamt = $eqty * $cost;
                $iamt = ($aeqty + $qty) * $cost;
                $query4 = "UPDATE report_medsupinv SET iqty = '$iqty', iamt = '$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$supply' AND date = '$enddate' AND type = 'supply' AND campus = '$campus'";
                mysqli_query($conn, $query4);
            }
        }
    }
}

if (!empty($sup_2)) {
    $supply = $sup_2;
    $quantity_sup = $sqty_2;
    if ($supply != "") {
        $query5 = "SELECT state FROM supply WHERE supid = '$supply'";
        $result = mysqli_query($conn, $query5);
        while ($data = mysqli_fetch_array($result)) {
            $sstate = $data['state'];
        }

        if ($sstate == 'per piece') {
            // Update inventory_supply
            $query0 = "UPDATE inventory_supply SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE campus='$campus' AND supid='$supply' AND expiration > '$datenow' AND qty > 0";
            mysqli_query($conn, $query0);
            // Update inv_total
            $query1 = "UPDATE inv_total SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE stockid='$supply' AND type = 'supply' AND campus='$campus'";
            mysqli_query($conn, $query1);
            // Update inventory
            $query2 = "UPDATE inventory SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE campus='$campus' AND stock_type='supply' AND stockid='$supply' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
            mysqli_query($conn, $query2);
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$supply' AND type = 'supply' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($data = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $quantities_sup;
                $eqty = $row['eqty'] - $qty;
                $aeqty = $row['iqty'];

                $query3 = "SELECT * FROM inv_total WHERE stockid = '$supply' AND type = 'supply' AND campus = '$campus'";
                $result = mysqli_query($conn, $query3);
                while ($data = mysqli_fetch_assoc($result)) {
                    $cost = $data['unit_cost'];
                }
                $aeamt = $eqty * $cost;
                $iamt = ($aeqty + $qty) * $cost;
                $query4 = "UPDATE report_medsupinv SET iqty = '$iqty', iamt = '$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$supply' AND date = '$enddate' AND type = 'supply' AND campus = '$campus'";
                mysqli_query($conn, $query4);
            }
        }
    }
}

if (!empty($sup_3)) {
    $supply = $sup_3;
    $quantity_sup = $sqty_3;
    if ($supply != "") {
        $query5 = "SELECT state FROM supply WHERE supid = '$supply'";
        $result = mysqli_query($conn, $query5);
        while ($data = mysqli_fetch_array($result)) {
            $sstate = $data['state'];
        }

        if ($sstate == 'per piece') {
            // Update inventory_supply
            $query0 = "UPDATE inventory_supply SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE campus='$campus' AND supid='$supply' AND expiration > '$datenow' AND qty > 0";
            mysqli_query($conn, $query0);
            // Update inv_total
            $query1 = "UPDATE inv_total SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE stockid='$supply' AND type = 'supply' AND campus='$campus'";
            mysqli_query($conn, $query1);
            // Update inventory
            $query2 = "UPDATE inventory SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE campus='$campus' AND stock_type='supply' AND stockid='$supply' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
            mysqli_query($conn, $query2);
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$supply' AND type = 'supply' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($data = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $quantities_sup;
                $eqty = $row['eqty'] - $qty;
                $aeqty = $row['iqty'];

                $query3 = "SELECT * FROM inv_total WHERE stockid = '$supply' AND type = 'supply' AND campus = '$campus'";
                $result = mysqli_query($conn, $query3);
                while ($data = mysqli_fetch_assoc($result)) {
                    $cost = $data['unit_cost'];
                }
                $aeamt = $eqty * $cost;
                $iamt = ($aeqty + $qty) * $cost;
                $query4 = "UPDATE report_medsupinv SET iqty = '$iqty', iamt = '$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$supply' AND date = '$enddate' AND type = 'supply' AND campus = '$campus'";
                mysqli_query($conn, $query4);
            }
        }
    }
}

if (!empty($sup_4)) {
    $supply = $sup_4;
    $quantity_sup = $sqty_4;
    if ($supply != "") {
        $query5 = "SELECT state FROM supply WHERE supid = '$supply'";
        $result = mysqli_query($conn, $query5);
        while ($data = mysqli_fetch_array($result)) {
            $sstate = $data['state'];
        }

        if ($sstate == 'per piece') {
            // Update inventory_supply
            $query0 = "UPDATE inventory_supply SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE campus='$campus' AND supid='$supply' AND expiration > '$datenow' AND qty > 0";
            mysqli_query($conn, $query0);
            // Update inv_total
            $query1 = "UPDATE inv_total SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE stockid='$supply' AND type = 'supply' AND campus='$campus'";
            mysqli_query($conn, $query1);
            // Update inventory
            $query2 = "UPDATE inventory SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE campus='$campus' AND stock_type='supply' AND stockid='$supply' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
            mysqli_query($conn, $query2);
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$supply' AND type = 'supply' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($data = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $quantities_sup;
                $eqty = $row['eqty'] - $qty;
                $aeqty = $row['iqty'];

                $query3 = "SELECT * FROM inv_total WHERE stockid = '$supply' AND type = 'supply' AND campus = '$campus'";
                $result = mysqli_query($conn, $query3);
                while ($data = mysqli_fetch_assoc($result)) {
                    $cost = $data['unit_cost'];
                }
                $aeamt = $eqty * $cost;
                $iamt = ($aeqty + $qty) * $cost;
                $query4 = "UPDATE report_medsupinv SET iqty = '$iqty', iamt = '$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$supply' AND date = '$enddate' AND type = 'supply' AND campus = '$campus'";
                mysqli_query($conn, $query4);
            }
        }
    }
}

if (!empty($sup_5)) {
    $supply = $sup_5;
    $quantity_sup = $sqty_5;
    if ($supply != "") {
        $query5 = "SELECT state FROM supply WHERE supid = '$supply'";
        $result = mysqli_query($conn, $query5);
        while ($data = mysqli_fetch_array($result)) {
            $sstate = $data['state'];
        }

        if ($sstate == 'per piece') {
            // Update inventory_supply
            $query0 = "UPDATE inventory_supply SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE campus='$campus' AND supid='$supply' AND expiration > '$datenow' AND qty > 0";
            mysqli_query($conn, $query0);
            // Update inv_total
            $query1 = "UPDATE inv_total SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE stockid='$supply' AND type = 'supply' AND campus='$campus'";
            mysqli_query($conn, $query1);
            // Update inventory
            $query2 = "UPDATE inventory SET closed = closed - '$quantities_sup', qty = qty - '$quantities_sup' WHERE campus='$campus' AND stock_type='supply' AND stockid='$supply' AND qty != 0 AND expiration > '$datenow' ORDER BY date LIMIT 1";
            mysqli_query($conn, $query2);
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$supply' AND type = 'supply' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($data = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $quantities_sup;
                $eqty = $row['eqty'] - $qty;
                $aeqty = $row['iqty'];

                $query3 = "SELECT * FROM inv_total WHERE stockid = '$supply' AND type = 'supply' AND campus = '$campus'";
                $result = mysqli_query($conn, $query3);
                while ($data = mysqli_fetch_assoc($result)) {
                    $cost = $data['unit_cost'];
                }
                $aeamt = $eqty * $cost;
                $iamt = ($aeqty + $qty) * $cost;
                $query4 = "UPDATE report_medsupinv SET iqty = '$iqty', iamt = '$iamt', eqty = '$eqty', eamt = '$aeamt' WHERE medid = '$supply' AND date = '$enddate' AND type = 'supply' AND campus = '$campus'";
                mysqli_query($conn, $query4);
            }
        }
    }
}

// check if may existing na
$enddate = date("Y-m-t");
$campus = $_SESSION['campus'];
//kunin medcase as text
$med_case = $transaction;
$sql = "SELECT * FROM med_case WHERE medcase='$med_case'";
$result = mysqli_query($conn, $sql);
while ($data = mysqli_fetch_array($result)) {
    if ($data['medcase'] != 'Others:') {
        $medcase =  $data['medcase'];
        $medcase_type = $data['type'];
        $medcase_others = $purpose;
    } else {
        $medcase_type = "others";
        $medcase_others = $transaction;
        $medcase = $purpose;
    }
}

$sql = "SELECT * FROM reports_medcase WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate' AND campus='$campus'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    // fetch data ng existing entry

    $enddate = date("Y-m-t");
    $campus = $_SESSION['campus'];

    //kunin medcase type
    $med_case = $transaction;
    $sql = "SELECT * FROM med_case WHERE medcase='$med_case'";
    $result = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_array($result)) {
        if ($data['medcase'] != 'Others:') {
            $medcase =  $data['medcase'];
            $medcase_type = $data['type'];
            $medcase_others = $purpose;
        } else {
            $medcase_type = "others";
            $medcase_others = $transaction;
            $medcase = $purpose;
        }
    }

    $sql = "SELECT * FROM reports_medcase WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate' AND campus='$campus'";
    $result = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_array($result)) {
        // check san sya i-add na column sa database
        switch (true) {
            case ($designation == "STUDENT" and $sex == "MALE"): {
                    $sm = $data['sm'] + 1;
                    $sf = $data['sf'];
                    $st = $data['st'] + 1;
                    $pm = $data['pm'];
                    $pf = $data['pf'];
                    $pt = $data['pt'];
                    $gm = $data['gm'] + 1;
                    $gf = $data['gf'];
                    $gt = $data['gt'] + 1;
                    break;
                }
            case ($designation == "STUDENT" and $sex == "FEMALE"): {
                    $sm = $data['sm'];
                    $sf = $data['sf'] + 1;
                    $st = $data['st'] + 1;
                    $pm = $data['pm'];
                    $pf = $data['pf'];
                    $pt = $data['pt'];
                    $gm = $data['gm'];
                    $gf = $data['gf'] + 1;
                    $gt = $data['gt'] + 1;
                    break;
                }
            case ($designation != "STUDENT" and $sex == "MALE"): {
                    $sm = $data['sm'];
                    $sf = $data['sf'];
                    $st = $data['st'];
                    $pm = $data['pm'] + 1;
                    $pf = $data['pf'];
                    $pt = $data['pt'] + 1;
                    $gm = $data['gm'] + 1;
                    $gf = $data['gf'];
                    $gt = $data['gt'] + 1;
                    break;
                }
            case ($designation != "STUDENT" and $sex == "FEMALE"): {
                    $sm = $data['sm'];
                    $sf = $data['sf'];
                    $st = $data['st'];
                    $pm = $data['pm'];
                    $pf = $data['pf'] + 1;
                    $pt = $data['pt'] + 1;
                    $gm = $data['gm'];
                    $gf = $data['gf'] + 1;
                    $gt = $data['gt'] + 1;
                    break;
                }
            default: {
                    break;
                }
        }
    }
    // update if meron
    $sql = "UPDATE reports_medcase SET sm='$sm', sf='$sf', st='$st', pm='$pm', pf='$pf', pt='$pt', gm='$gm', gf='$gf', gt='$gt' WHERE type='$medcase_type' AND medcase='$medcase' AND date='$enddate'";
    $result = mysqli_query($conn, $sql);
} else {
    // add pag wala

    $campus = $_SESSION['campus'];
    // check san sya i-add na column sa database
    switch (true) {
        case ($designation == "STUDENT" and $sex == "MALE"): {
                $sm = 1;
                $sf = 0;
                $st = 1;
                $pm = 0;
                $pf = 0;
                $pt = 0;
                $gm = 1;
                $gf = 0;
                $gt = 1;
                break;
            }
        case ($designation == "STUDENT" and $sex == "FEMALE"): {
                $sm = 0;
                $sf = 1;
                $st = 1;
                $pm = 0;
                $pf = 0;
                $pt = 0;
                $gm = 0;
                $gf = 1;
                $gt = 1;
                break;
            }
        case ($designation != "STUDENT" and $sex == "MALE"): {
                $sm = 0;
                $sf = 0;
                $st = 0;
                $pm = 1;
                $pf = 0;
                $pt = 1;
                $gm = 1;
                $gf = 0;
                $gt = 1;
                break;
            }
        case ($designation != "STUDENT" and $sex == "FEMALE"): {
                $sm = 0;
                $sf = 0;
                $st = 0;
                $pm = 0;
                $pf = 1;
                $pt = 1;
                $gm = 0;
                $gf = 1;
                $gt = 1;
                break;
            }
        default: {
                break;
            }
    }
    $enddate = date("Y-m-t");
    $med_case = $transaction;
    $sql = "SELECT * FROM med_case WHERE medcase='$med_case'";
    $result = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_array($result)) {
        if ($data['medcase'] != 'Others:') {
            $medcase =  $data['medcase'];
            $medcase_type = $data['type'];
            $medcase_others = $purpose;
        } else {
            $medcase_type = "others";
            $medcase_others = $transaction;
            $medcase = $purpose;
        }
    }

    $sql = "INSERT INTO reports_medcase (campus, type, medcase, sm, sf, st, pm, pf, pt, gm, gf, gt, date) VALUES ('$campus', '$medcase_type', '$medcase', '$sm', '$sf', '$st', '$pm', '$pf', '$pt', '$gm', '$gf', '$gt', '$enddate')";
    $result = mysqli_query($conn, $sql);
}

// Audit trail 
$sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$campus', '$activity', '$au_status', now())";
if ($result = mysqli_query($conn, $sql)) {
?>
    <script>
        setTimeout(function() {
            window.location = "../appointment?tab=approved";
        });
    </script>
<?php
    // modal message box saying "Transaction was recorded."
} else {
?>
    <script>
        setTimeout(function() {
            window.location = "../appointment?tab=approved";
        });
    </script>
<?php
    // modal message box saying "Transaction was recorded."
}

mysqli_close($conn);
?>