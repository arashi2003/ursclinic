<?php
    include('../../../connection.php');
    $enddate=date("Y-m-t");
    $campus="BINANGONAN";
    if (isset($_POST['medicine'])) {
        $medicines = $_POST['medicine'];
        $quantities = $_POST['quantity_med'];
        foreach ($medicines as $key => $medicine) {
            $qty_m = $quantities[$key];
            // Update inventory_medicine
            echo  rtrim($medicine . ", " . $quantities[$key], ", ") . "inventory_medicine <br>";
            // Update inv_total
            echo  rtrim($medicine . ", " . $quantities[$key], ", ") . "inv_total <br>";
            // Update inventory
            echo  rtrim($medicine . ", " . $quantities[$key], ", ") . "inventory <br>";
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$medicine' AND type = 'medicine' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($data = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $qty_m;
                $aotqty = $data['tqty'];
                $aieqty = $data['eqty'];
                $aiiamt = $data['iamt'];
                $aiiqty = $data['iqty'];
                $aieamt = $data['eamt']; //buc
                $cost = $data['eamt'] / $data['eqty'];
    
                $tqty = $aotqty - $qty;
                $eqty = $data['eqty'] - $qty;
    
                if ($data['tqty'] == 0) {
                    $aobuc = 0;
                    $abuc = number_format($aobuc, 2, ".");
                } else {
                    $aobuc = ($data['eamt'] - ($qty * $cost)) / $eqty;
                    $abuc = number_format($aobuc, 2, ".");
                }
                $aeamt = $eqty * $aobuc;
                if ($data['iqty'] == 0) {
                    $iamt =  $qty * $aobuc;
                    $iqty =  $qty;
                } else {
                    $iqty = $data['iqty'] + $qty;
                    $iamt = $iqty * ($aeamt/$eqty);
                }
                echo  rtrim($medicine . ", " . $quantities[$key], ", ") . "reports <p>";
            }
        }
    }

    if (isset($_POST['supply'])) {
        $supplies = $_POST['supply'];
        $quantities_sup = $_POST['quantity_sup'];
        foreach ($supplies as $key => $supply) {
            $qty_sup = $quantities_sup[$key];
            // Update inventory_supply
            echo  rtrim($supply . ", " . $quantities_sup[$key], ", ") . " inventory_supply <br>";
            // Update inv_total
            echo  rtrim($supply . ", " . $quantities_sup[$key], ", ") . " inv_total <br>";
            // Update inventory
            echo  rtrim($supply . ", " . $quantities_sup[$key], ", ") . " inventory <br>";
            // Update report_medsupinv
            $query3 = "SELECT * FROM report_medsupinv WHERE medid = '$supply' AND type = 'supply' AND date = '$enddate' AND campus = '$campus' AND eqty > 0";
            $result = mysqli_query($conn, $query3);
            while ($data = mysqli_fetch_assoc($result)) {
                // Update report_medsupinv
                $qty = $qty_sup;
                $aotqty = $data['tqty'];
                $aieqty = $data['eqty'];
                $aiiamt = $data['iamt'];
                $aiiqty = $data['iqty'];
                $aieamt = $data['eamt']; //buc
                $cost = $data['eamt'] / $data['eqty'];
    
                $tqty = $aotqty - $qty;
                $eqty = $data['eqty'] - $qty;
    
                if ($data['tqty'] == 0) {
                    $aobuc = 0;
                    $abuc = number_format($aobuc, 2, ".");
                } else {
                    $aobuc = ($data['eamt'] - ($qty * $cost)) / $eqty;
                    $abuc = number_format($aobuc, 2, ".");
                }
                $aeamt = $eqty * $aobuc;
                if ($data['iqty'] == 0) {
                    $iamt =  $qty * $aobuc;
                    $iqty =  $qty;
                } else {
                    $iqty = $data['iqty'] + $qty;
                    $iamt = $iqty * ($aeamt/$eqty);
                }
                echo  rtrim($supply . ", " . $quantities_sup[$key], ", ") . " reports <br>";
            }
        }
    }
    
    // Combine issued medicine and supply statements into a single statement
    //$medsup = rtrim($issued_medicine_statement . ", " . $issued_supply_statement, ", ");
    //echo  rtrim($medsup, ", ");
    mysqli_close($conn);