<div class="modal fade" id="addappointment" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Request Appointment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload();"></button>
            </div>
            <form method="POST" action="modals/add-appointment.php">
                <div class="modal-body">
                    <div class="mb-2">
                        <input type="text" name="patient" value="<?php echo $_SESSION['userid'] ?>" hidden>
                        <label for="patientname" class="col-form-label">Patient Name:</label>
                        <input type="text" class="form-control" name="patientname" value="<?php echo $_SESSION['name'] ?>" readonly disabled>
                    </div>
                    <div class="mb-2">
                        <label for="appointment" class="col-form-label">Type of Appointment:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="appointment" id="appointment" onchange="enableAppointment(this)">
                            <option value="" disabled selected></option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM appointment_type";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <option value="<?= $row['id']; ?>"><?= $row['type']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col hidden" id="dateDiv">
                            <label for="date" class="col-form-label">Date:</label>
                            <input type="text" class="form-control" name="date" id="showDate" placeholder="mm/dd/yyyy">
                        </div>
                        <div class="col hidden" id="timeFromDiv">
                            <label for="time_from" class="col-form-label">Time From:</label>
                            <select class="form-select form-select-md" aria-label=".form-select-md example" name="time_from" id="time_from">
                                <option value="" disabled selected>-:-- --</option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM time_pickup";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    $time = date('g:i A', strtotime($row['time'])); // Format time as '12:00 PM'
                                ?>
                                    <option value="<?= $row['time']; ?>"><?= $time; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col hidden" id="timeToDiv">
                            <label for="time_to" class="col-form-label">Time To:</label>
                            <select class="form-select form-select-md" aria-label=".form-select-md example" name="time_to" id="time_to">
                                <option value="" disabled selected>-:-- --</option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM time_pickup";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    $time = date('g:i A', strtotime($row['time'])); // Format time as '12:00 PM'
                                ?>
                                    <option value="<?= $row['time']; ?>"><?= $time; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 hidden" id="purposeDiv">
                        <label for="purposes" class="col-form-label">Request:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="purpose" id="purpose">
                            <option value="" disabled selected></option>
                        </select>
                    </div>
                    <div class="mb-2 hidden" id="ccDiv">
                        <label for="chiefcomplaint" class="col-form-label">Chief Complaint:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="chiefcomplaint" id="chiefcomplaint" onchange="enableOther(this)">
                            <option value="" disabled selected></option>
                        </select>
                    </div>
                    <div class="mb-2 hidden" id="others">
                        <label for="other" class="col-form-label">Others:</label>
                        <input type="text" class="form-control" name="others">
                    </div>

                    <div class="row duplicate hidden">
                        <div class="col-md hidden" id="medDupDiv">
                            <label for="medicine" class="col-form-label">Medicine:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="medicine[]" id="medicine">
                                <option value="" disabled selected></option>
                                <?php
                                $sql = "SELECT * FROM inv_total im INNER JOIN medicine m ON m.medid=im.stockid WHERE qty > 0 ORDER BY im.stock_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['stockid']; ?>"><?= $row['stock_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md hidden" id="supDupDiv">
                            <label for="medical" class="col-form-label">Medical Supply:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="medical[]" id="medical">
                                <option value="" disabled selected></option>
                                <?php
                                $sql = "SELECT * FROM inv_total i INNER JOIN supply s ON s.supid=i.stockid WHERE qty > 0 ORDER BY i.stock_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['stockid']; ?>"><?= $row['stock_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4 hidden" id="quantityDiv">
                            <label for="quantity" class="col-form-label">Quantity:</label>
                            <div class="row">
                                <div class="col-sm-7 mb-2">
                                    <input type="number" class="form-control" name="quantity[]">
                                </div>
                                <div class="col-sm mb-2">
                                    <button type="button" class="btn btn-primary" onclick="duplicate()">+</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- MED 1 -->
                    <div class="row">
                        <div class="col-md" id="medDupDiv">
                            <label for="medicine" class="col-form-label">Medicine:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="med_1" id="med_1">
                                <option value="" disabled selected></option>
                                <?php
                                $sql = "SELECT * FROM inv_total im INNER JOIN medicine m ON m.medid=im.stockid WHERE qty > 0 AND type='medicine' ORDER BY im.stock_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['stockid']; ?>"><?= $row['stock_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md" id="supDupDiv">
                            <label for="medical" class="col-form-label">Medical Supply:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="sup_1" id="sup_1">
                                <option value="" disabled selected></option>
                                <?php
                                $sql = "SELECT * FROM inv_total i INNER JOIN supply s ON s.supid=i.stockid  WHERE qty > 0 AND type='supply' ORDER BY i.stock_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['stockid']; ?>"><?= $row['stock_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4" id="quantityDiv">
                            <label for="quantity" class="col-form-label">Quantity:</label>
                            <div class="row">
                                <div class="col-sm-7 mb-2">
                                    <input type="number" class="form-control" min="1" name="qty_1" id="qty_1">
                                </div>
                                <div class="col-sm mb-2">
                                    <button type="button" class="btn btn-primary">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MED 2 -->
                    <div class="row">
                        <div class="col-md" id="medDupDiv">
                            <label for="medicine" class="col-form-label">Medicine:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="med_2" id="med_2">
                                <option value="" disabled selected></option>
                                <?php
                                $sql = "SELECT * FROM inv_total im INNER JOIN medicine m ON m.medid=im.stockid WHERE qty > 0 AND type='medicine' ORDER BY im.stock_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['stockid']; ?>"><?= $row['stock_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md" id="supDupDiv">
                            <label for="medical" class="col-form-label">Medical Supply:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="sup_2" id="sup_2">
                                <option value="" disabled selected></option>
                                <?php
                                $sql = "SELECT * FROM inv_total i INNER JOIN supply s ON s.supid=i.stockid  WHERE qty > 0 AND type='supply' ORDER BY i.stock_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['stockid']; ?>"><?= $row['stock_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4" id="quantityDiv">
                            <label for="quantity" class="col-form-label">Quantity:</label>
                            <div class="row">
                                <div class="col-sm-7 mb-2">
                                    <input type="number" class="form-control" min="1" name="qty_2" id="qty_2">
                                </div>
                                <div class="col-sm mb-2">
                                    <button type="button" class="btn btn-primary">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MED 3 -->
                    <div class="row">
                        <div class="col-md" id="medDupDiv">
                            <label for="medicine" class="col-form-label">Medicine:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="med_3" id="med_3">
                                <option value="" disabled selected></option>
                                <?php
                                $sql = "SELECT * FROM inv_total im INNER JOIN medicine m ON m.medid=im.stockid WHERE qty > 0 AND type='medicine' ORDER BY im.stock_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['stockid']; ?>"><?= $row['stock_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md" id="supDupDiv">
                            <label for="medical" class="col-form-label">Medical Supply:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="sup_3" id="sup_3">
                                <option value="" disabled selected></option>
                                <?php
                                $sql = "SELECT * FROM inv_total i INNER JOIN supply s ON s.supid=i.stockid  WHERE qty > 0 AND type='supply' ORDER BY i.stock_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['stockid']; ?>"><?= $row['stock_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4" id="quantityDiv">
                            <label for="quantity" class="col-form-label">Quantity:</label>
                            <div class="row">
                                <div class="col-sm-7 mb-2">
                                    <input type="number" class="form-control" min="1" name="qty_3" id="qty_3">
                                </div>
                                <div class="col-sm mb-2">
                                    <button type="button" class="btn btn-primary">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- MED 4 -->
                    <div class="row">
                        <div class="col-md" id="medDupDiv">
                            <label for="medicine" class="col-form-label">Medicine:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="med_4" id="med_4">
                                <option value="" disabled selected></option>
                                <?php
                                $sql = "SELECT * FROM inv_total im INNER JOIN medicine m ON m.medid=im.stockid WHERE qty > 0 AND type='medicine' ORDER BY im.stock_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['stockid']; ?>"><?= $row['stock_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md" id="supDupDiv">
                            <label for="medical" class="col-form-label">Medical Supply:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="sup_4" id="sup_4">
                                <option value="" disabled selected></option>
                                <?php
                                $sql = "SELECT * FROM inv_total i INNER JOIN supply s ON s.supid=i.stockid  WHERE qty > 0 AND type='supply' ORDER BY i.stock_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['stockid']; ?>"><?= $row['stock_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4" id="quantityDiv">
                            <label for="quantity" class="col-form-label">Quantity:</label>
                            <div class="row">
                                <div class="col-sm-7 mb-2">
                                    <input type="number" class="form-control" min="1" name="qty_4" id="qty_4">
                                </div>
                                <div class="col-sm mb-2">
                                    <button type="button" class="btn btn-primary">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- MED 5 -->
                    <div class="row">
                        <div class="col-md" id="medDupDiv">
                            <label for="medicine" class="col-form-label">Medicine:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="med_5" id="med_5">
                                <option value="" disabled selected></option>
                                <?php
                                $sql = "SELECT * FROM inv_total im INNER JOIN medicine m ON m.medid=im.stockid WHERE qty > 0 AND type='medicine' ORDER BY im.stock_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['stockid']; ?>"><?= $row['stock_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md" id="supDupDiv">
                            <label for="medical" class="col-form-label">Medical Supply:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="sup_5" id="sup_5">
                                <option value="" disabled selected></option>
                                <?php
                                $sql = "SELECT * FROM inv_total i INNER JOIN supply s ON s.supid=i.stockid  WHERE qty > 0 AND type='supply' ORDER BY i.stock_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['stockid']; ?>"><?= $row['stock_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4" id="quantityDiv">
                            <label for="quantity" class="col-form-label">Quantity:</label>
                            <div class="row">
                                <div class="col-sm-7 mb-2">
                                    <input type="number" class="form-control" min="1" name="qty_5" id="qty_5">
                                </div>
                                <div class="col-sm mb-2">
                                    <button type="button" class="btn btn-primary">+</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2 hidden" id="physicianDiv">
                        <label for="physician" class="col-form-label">Physician:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="physician" id="physician">
                            <option value="" disabled selected></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Request"></input>
                </div>
            </form>
        </div>
    </div>
</div>




<script type="text/javascript">
    $(document).ready(function() {
        $("#appointment").change(function() {
            var appointment_id = $(this).val();
            if (appointment_id == '') {
                $("#purpose").html('<option value="" disabled selected></option>');
                $("#chiefcomplaint").html('<option value="" disabled selected></option>');
                $("#physician").html('<option value="" disabled selected></option>');
            } else {
                $("#purpose").html('<option value="" disabled selected></option>');
                $("#chiefcomplaint").html('<option value="" disabled selected></option>');
                $("#physician").html('<option value="" disabled selected></option>');
                $.ajax({
                    url: "action.php",
                    method: "POST",
                    data: {
                        aid: appointment_id
                    },
                    success: function(data) {
                        $("#purpose").html(data);
                    }
                });
            }
        });
        $("#purpose").change(function() {
            var purpose_id = $(this).val();
            $.ajax({
                url: "action.php",
                method: "POST",
                data: {
                    pid: purpose_id,
                    type: 'purpose'
                },
                success: function(data) {
                    $("#chiefcomplaint").html(data);
                }
            });
        });
        $("#purpose").change(function() {
            var purpose_id = $(this).val();
            $.ajax({
                url: "action.php",
                method: "POST",
                data: {
                    pid: purpose_id,
                    type: 'physician'
                },
                success: function(data) {
                    $("#physician").html(data);
                }
            });
        });
    });

    function enableOther(answer) {
        console.log(answer.value);
        {
            if (answer.value == 'Others') {
                document.getElementById('others').classList.remove('hidden');
            } else {
                document.getElementById('others').classList.add('hidden');
            }
        }
    };

    $(document).ready(function() {
        $('#showDate').datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0, // Disable past dates
            beforeShowDay: function(date) {
                var day = date.getDay();
                return [(day != 0)]; // Disable Sundays
            }
        });
    });
</script>
<script>
    /*
    $(document).ready(function() {
        $("#time_from").change(function() {
            var time_fromid = $(this).val();
            if (time_from == '') {
                $("#time_to").html('<option value="" disabled selected>-:-- --</option>');
            } else {
                $("#time_to").html('<option value="" disabled selected>-:-- --</option>');
                $.ajax({
                    url: "time.php",
                    method: "POST",
                    data: {
                        time_from: time_fromid
                    },
                    success: function(data) {
                        $("#time_to").html(data);
                        $("#time_to").trigger("change");
                    }
                });
            }
        });
    });*/
</script>
<script type="text/javascript">
    function enableAppointment(answer) {
        console.log(answer.value);
        {
            if (answer.value == 1 || answer.value == 2 || answer.value == 3) {
                document.getElementById('dateDiv').classList.remove('hidden');
                document.getElementById('timeFromDiv').classList.remove('hidden');
                document.getElementById('timeToDiv').classList.remove('hidden');
                document.getElementById('purposeDiv').classList.remove('hidden');
                document.getElementById('ccDiv').classList.remove('hidden');
                document.getElementById('medDupDiv').classList.add('hidden');
                document.getElementById('supDupDiv').classList.add('hidden');
                document.getElementById('quantityDiv').classList.add('hidden');
                document.getElementById('physicianDiv').classList.remove('hidden');
                document.getElementById('others').classList.add('hidden');
            } else if (answer.value == 4) {
                document.getElementById('dateDiv').classList.remove('hidden');
                document.getElementById('timeFromDiv').classList.remove('hidden');
                document.getElementById('timeToDiv').classList.remove('hidden');
                document.getElementById('purposeDiv').classList.remove('hidden');
                document.getElementById('ccDiv').classList.remove('hidden');
                document.getElementById('supDupDiv').classList.add('hidden');
                document.getElementById('medDupDiv').classList.remove('hidden');
                document.getElementById('quantityDiv').classList.remove('hidden');
                document.getElementById('physicianDiv').classList.add('hidden');
                document.getElementById('others').classList.add('hidden');
            } else if (answer.value == 5) {
                document.getElementById('dateDiv').classList.remove('hidden');
                document.getElementById('timeFromDiv').classList.remove('hidden');
                document.getElementById('timeToDiv').classList.remove('hidden');
                document.getElementById('purposeDiv').classList.remove('hidden');
                document.getElementById('ccDiv').classList.remove('hidden');
                document.getElementById('medDupDiv').classList.add('hidden');
                document.getElementById('supDupDiv').classList.remove('hidden');
                document.getElementById('quantityDiv').classList.remove('hidden');
                document.getElementById('physicianDiv').classList.add('hidden');
                document.getElementById('others').classList.add('hidden');
            } else if (answer.value == 6 || answer.value == 7) {
                document.getElementById('dateDiv').classList.remove('hidden');
                document.getElementById('timeFromDiv').classList.remove('hidden');
                document.getElementById('timeToDiv').classList.remove('hidden');
                document.getElementById('purposeDiv').classList.remove('hidden');
                document.getElementById('ccDiv').classList.add('hidden');
                document.getElementById('medDupDiv').classList.add('hidden');
                document.getElementById('supDupDiv').classList.add('hidden');
                document.getElementById('quantityDiv').classList.add('hidden');
                document.getElementById('physicianDiv').classList.add('hidden');
                document.getElementById('others').classList.add('hidden');
            }
        }
    };
</script>

<script>
    function duplicate() {
        var row = $('.duplicate').first().clone();
        row.find('button').removeClass('btn-primary').addClass('btn-danger').text('-').attr('onclick', 'remove(this)');
        $('.duplicate').last().after(row);
    }

    function remove(btn) {
        $(btn).closest('.duplicate').remove();
    }

    $('select[name="request"]').change(function() {
        $('.duplicate:not(:first)').remove();
    });
</script>