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
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="appointment" id="appointment" onchange="enableAppointment(this)" required>
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
                    <div class="mb-2 hidden" id="purposeDiv">
                        <label for="purposes" class="col-form-label">Request:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="purpose" id="purpose" required>
                            <option value="" disabled selected></option>
                        </select>
                    </div>
                    <div class="mb-2 hidden" id="physicianDiv">
                        <label for="physician" class="col-form-label">Physician:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="physician" id="physician" onchange="enablePhys(this)">
                            <option value="" disabled selected></option>
                        </select>
                    </div>
                    <div class="row hidden" id="datetimeDiv">
                        <div class="col-md-6 mb-2 hidden" id="dateNDiv">
                            <label for="date" class="col-form-label">Date:</label>
                            <input type="text" class="form-control" name="daten" id="showDate" placeholder="mm/dd/yyyy">
                        </div>

                        <div class="col-md-6 mb-2 hidden" id="datePDiv">
                            <label for="date" class="col-form-label">Date:</label>
                            <select class="form-select form-select-md" aria-label=".form-select-md example" name="datep" id="dateSelect" onchange="datepchange(this)">
                                <option value="" disabled selected></option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2 hidden" id="timeFromPDiv">
                            <label for="time_from" class="col-form-label">Time:</label>
                            <select class="form-select form-select-md" aria-label=".form-select-md example" name="time_fromp" id="time_fromp" onchange="timeToPchange(this)">
                                <option value="" disabled selected>-:-- --</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2 hidden" id="timeToPDiv">
                            <select class="form-select form-select-md" aria-label=".form-select-md example" name="time_top" id="time_top" hidden>
                                <option value="" disabled selected>-:-- --</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-2 hidden" id="timeFromNDiv">
                            <label for="time_from" class="col-form-label">Time From:</label>
                            <select class="form-select form-select-md" aria-label=".form-select-md example" name="time_fromn" id="time_fromn">
                                <option value="" disabled selected>-:-- --</option>
                                <?php
                                include('connection.php');
                                session_start();
                                $campus = $_SESSION['campus'];
                                
                                $beng = "SELECT count(id) FROM time_pickup WHERE campus = '$campus' ";
                                $result = mysqli_query($conn, $beng);
                                while ($toot = mysqli_fetch_array($result)) {
                                    $numrows = $toot['count(id)'] - 1;
                                }
                                $sql = "SELECT * FROM time_pickup WHERE campus = '$campus' LIMIT $numrows";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    $time = date('g:i A', strtotime($row['time'])); // Format time as '12:00 PM'
                                ?>
                                    <option value="<?= $row['time']; ?>"><?= $time; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2 hidden" id="timeToNDiv">
                            <select class="form-select form-select-md" aria-label=".form-select-md example" name="time_ton" id="time_ton" hidden>
                                <option value="" disabled selected>-:-- --</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-2 hidden" id="ccDiv">
                        <label for="chiefcomplaint" class="col-form-label">Chief Complaint:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="chiefcomplaint" id="chiefcomplaint" onchange="enableOther(this)" required>
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
                                $sql = "SELECT * FROM inv_total im INNER JOIN medicine m ON m.medid=im.stockid WHERE qty > 0 AND type = 'medicine' ORDER BY im.stock_name";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['stockid']; ?>"><?= $row['stock_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md hidden" id="supDupDiv">
                            <label for="supply" class="col-form-label">Medical Supply:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="supply[]" id="supply">
                                <option value="" disabled selected></option>
                                <?php
                                $sql = "SELECT * FROM inv_total i INNER JOIN supply s ON s.supid=i.stockid WHERE qty > 0  AND type = 'supply' ORDER BY i.stock_name";
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
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Request"></input>
                    &ThickSpace;
                    <input type="reset" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
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
                        document.getElementById('dateNDiv').value = "";
                        document.getElementById('datePDiv').value = "";
                        document.getElementById('timeFromNDiv').value = "";
                        document.getElementById('timeToNDiv').value = "";
                        document.getElementById('timeFromPDiv').value = "";
                        document.getElementById('timeToPDiv').value = "";
                        document.getElementById('dateNDiv').classList.add('hidden');
                        document.getElementById('datePDiv').classList.add('hidden');
                        document.getElementById('timeFromNDiv').classList.add('hidden');
                        document.getElementById('timeToNDiv').classList.add('hidden');
                        document.getElementById('timeFromPDiv').classList.add('hidden');
                        document.getElementById('timeToPDiv').classList.add('hidden');
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
                    document.getElementById('dateNDiv').value = "";
                    document.getElementById('datePDiv').value = "";
                    document.getElementById('timeFromNDiv').value = "";
                    document.getElementById('timeToNDiv').value = "";
                    document.getElementById('timeFromPDiv').value = "";
                    document.getElementById('timeToPDiv').value = "";
                    document.getElementById('dateNDiv').classList.add('hidden');
                    document.getElementById('datePDiv').classList.add('hidden');
                    document.getElementById('timeFromNDiv').classList.add('hidden');
                    document.getElementById('timeToNDiv').classList.add('hidden');
                    document.getElementById('timeFromPDiv').classList.add('hidden');
                    document.getElementById('timeToPDiv').classList.add('hidden');
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
                    document.getElementById('dateNDiv').value = "";
                    document.getElementById('datePDiv').value = "";
                    document.getElementById('timeFromNDiv').value = "";
                    document.getElementById('timeToNDiv').value = "";
                    document.getElementById('timeFromPDiv').value = "";
                    document.getElementById('timeToPDiv').value = "";
                    document.getElementById('dateNDiv').classList.add('hidden');
                    document.getElementById('datePDiv').classList.add('hidden');
                    document.getElementById('timeFromNDiv').classList.add('hidden');
                    document.getElementById('timeToNDiv').classList.add('hidden');
                    document.getElementById('timeFromPDiv').classList.add('hidden');
                    document.getElementById('timeToPDiv').classList.add('hidden');
                    $("#physician").html(data);
                }
            });
        });

        $("#physician").change(function() {
            var physician_id = $(this).val();
            console.log(physician_id);
            $.ajax({
                url: "action.php",
                method: "POST",
                data: {
                    pid: physician_id,
                    type: 'date'
                },
                success: function(data) {
                    document.getElementById('dateNDiv').value = "";
                    document.getElementById('datePDiv').value = "";
                    document.getElementById('timeFromNDiv').value = "";
                    document.getElementById('timeToNDiv').value = "";
                    document.getElementById('timeFromPDiv').value = "";
                    document.getElementById('timeToPDiv').value = "";
                    $("#dateSelect").html(data);
                }
            });
        });
    });

    function enableOther(answer) {
        console.log(answer.value);
        {
            if (answer.value == 'Others:') {
                document.getElementById('others').classList.remove('hidden');
            } else {
                document.getElementById('others').classList.add('hidden');
            }
        }
    };

    /*
    $(function() {
        // Calculate the date one week ahead from now
        var currentDate = new Date();
        var disabledDate = new Date();
        disabledDate.setDate(currentDate.getDate() - 1);

        // Initialize Datepicker
        $("#showDate").datepicker({
            dateFormat: "yy-mm-dd",
            beforeShowDay: function(date) {
                // Disable dates within the next week
                var disabled = date <= disabledDate;
                // Enable dates beyond the next week
                var enabled = date > disabledDate;
                return [enabled, enabled ? "" : "disabled", enabled ? "" : "Dates within the next week are disabled"];
            }
        });
    });
    */

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
    $(document).ready(function() {
        $("#time_fromn").change(function() {
            var time_fromnid = $(this).val();
            if (time_fromnid == '') {
                $("#time_ton").html('<option value="" disabled selected>-:-- --</option>');
            } else {
                $.ajax({
                    url: "timen.php", // Ensure this URL is correct
                    method: "POST",
                    data: {
                        time_fromn: time_fromnid
                    },
                    success: function(data) {
                        $("#time_ton").html('<option value="" disabled selected>-:-- --</option>');
                        $("#time_ton").html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Define the datepchange function
        function datepchange(answer) {
            var dateSelect = $("#dateSelect"); // Cache the jQuery object for better performance
            dateSelect.change(function() {
                var dateSelect_id = $(this).val();
                var physician_id = $("#physician").val(); // Get the value of the selected physician
                console.log(dateSelect_id);
                console.log(physician_id);
                $.ajax({
                    url: "timepfrom.php",
                    method: "POST",
                    data: {
                        date: dateSelect_id,
                        physician: physician_id // Include the physician parameter
                    },
                    success: function(data) {
                        $("#time_fromp").html(data);
                    }
                });
            });
        }

        // Call the datepchange function when the document is ready
        datepchange(); // Call the function

        // Define the timeToPchange function
        function timeToPchange(answer) {
            var time_fromp = $("#time_fromp"); // Cache the jQuery object for better performance
            time_fromp.change(function() {
                var dateSelect_id = $("#dateSelect").val();
                var physician_id = $("#physician").val();
                var time_from_id = $("#time_fromp").val(); // Get the value of the selected physician
                console.log(time_from_id);
                $.ajax({
                    url: "timepto.php",
                    method: "POST",
                    data: {
                        date: dateSelect_id,
                        physician: physician_id,
                        time_fromp: time_from_id
                    },
                    success: function(data) {
                        $("#time_top").html(data);
                    }
                });
            });
        }

        // Call the timeToPchange function when the document is ready
        timeToPchange(); // Call the function
    });
</script>

<script type="text/javascript">
    function enableAppointment(answer) {
        console.log(answer.value);
        if (answer.value == 1 || answer.value == 2 || answer.value == 3) {
            document.getElementById('dateNDiv').value = "";
            document.getElementById('datePDiv').value = "";
            document.getElementById('timeFromNDiv').value = "";
            document.getElementById('timeToNDiv').value = "";
            document.getElementById('timeFromPDiv').value = "";
            document.getElementById('timeToPDiv').value = "";
            document.getElementById('datetimeDiv').classList.remove('hidden');
            document.getElementById('purposeDiv').classList.remove('hidden');
            document.getElementById('ccDiv').classList.remove('hidden');
            document.getElementById('medDupDiv').classList.add('hidden');
            document.getElementById('supDupDiv').classList.add('hidden');
            document.getElementById('quantityDiv').classList.add('hidden');
            document.getElementById('physicianDiv').classList.remove('hidden');
            document.getElementById('others').classList.add('hidden');
        } else if (answer.value == 4) {
            document.getElementById('dateNDiv').value = "";
            document.getElementById('datePDiv').value = "";
            document.getElementById('timeFromNDiv').value = "";
            document.getElementById('timeToNDiv').value = "";
            document.getElementById('timeFromPDiv').value = "";
            document.getElementById('timeToPDiv').value = "";

            document.getElementById('datePDiv').classList.add('hidden');
            document.getElementById('dateNDiv').classList.remove('hidden');
            document.getElementById('timeToNDiv').classList.remove('hidden');
            document.getElementById('timeFromNDiv').classList.remove('hidden');
            document.getElementById('timeToPDiv').classList.add('hidden');
            document.getElementById('timeFromPDiv').classList.add('hidden');

            document.getElementById('datetimeDiv').classList.remove('hidden');
            document.getElementById('purposeDiv').classList.remove('hidden');
            document.getElementById('ccDiv').classList.remove('hidden');
            document.getElementById('supDupDiv').classList.add('hidden');
            document.getElementById('medDupDiv').classList.remove('hidden');
            document.getElementById('quantityDiv').classList.remove('hidden');
            document.getElementById('physicianDiv').classList.add('hidden');
            document.getElementById('others').classList.add('hidden');
        } else if (answer.value == 5) {
            document.getElementById('dateNDiv').value = "";
            document.getElementById('datePDiv').value = "";
            document.getElementById('timeFromNDiv').value = "";
            document.getElementById('timeToNDiv').value = "";
            document.getElementById('timeFromPDiv').value = "";
            document.getElementById('timeToPDiv').value = "";
            
            document.getElementById('datePDiv').classList.add('hidden');
            document.getElementById('dateNDiv').classList.remove('hidden');
            document.getElementById('timeToNDiv').classList.remove('hidden');
            document.getElementById('timeFromNDiv').classList.remove('hidden');
            document.getElementById('timeToPDiv').classList.add('hidden');
            document.getElementById('timeFromPDiv').classList.add('hidden');
            
            document.getElementById('datetimeDiv').classList.remove('hidden');
            document.getElementById('purposeDiv').classList.remove('hidden');
            document.getElementById('ccDiv').classList.remove('hidden');
            document.getElementById('medDupDiv').classList.add('hidden');
            document.getElementById('supDupDiv').classList.remove('hidden');
            document.getElementById('quantityDiv').classList.remove('hidden');
            document.getElementById('physicianDiv').classList.add('hidden');
            document.getElementById('others').classList.add('hidden');
        }
    };

    function enablePhys(answer) {
        console.log(answer.value);
        var physicianValue = document.getElementById('physician').value;
        if (answer.value == "NONE") {
            document.getElementById('timeFromNDiv').value = "";
            document.getElementById('timeToNDiv').value = "";
            document.getElementById('timeFromPDiv').value = "";
            document.getElementById('timeToPDiv').value = "";
            document.getElementById('dateNDiv').value = "";
            document.getElementById('datePDiv').value = "";
            document.getElementById('dateNDiv').classList.remove('hidden');
            document.getElementById('datePDiv').classList.add('hidden');
            document.getElementById('timeFromNDiv').classList.remove('hidden');
            document.getElementById('timeToNDiv').classList.remove('hidden');
            document.getElementById('timeFromPDiv').classList.add('hidden');
            document.getElementById('timeToPDiv').classList.add('hidden');
        } else {
            document.getElementById('dateNDiv').value = "";
            document.getElementById('datePDiv').value = "";
            document.getElementById('timeFromNDiv').value = "";
            document.getElementById('timeToNDiv').value = "";
            document.getElementById('timeFromPDiv').value = "";
            document.getElementById('timeToPDiv').value = "";
            document.getElementById('dateNDiv').classList.add('hidden');
            document.getElementById('datePDiv').classList.remove('hidden');
            document.getElementById('timeFromNDiv').classList.add('hidden');
            document.getElementById('timeToNDiv').classList.add('hidden');
            document.getElementById('timeFromPDiv').classList.remove('hidden');
            document.getElementById('timeToPDiv').classList.remove('hidden');
        }
    };
</script>
<script>
    var duplicateCount = 1; // Initialize the duplicate count

    function duplicate() {
        // Check if the duplicate count is less than or equal to 4 (since we start counting from 1)
        if (duplicateCount <= 4) {
            var row = $('.duplicate').first().clone();
            row.find('button').removeClass('btn-primary').addClass('btn-danger').text('-').attr('onclick', 'remove(this)');
            $('.duplicate').last().after(row);
            duplicateCount++; // Increment the duplicate count
        } else {
            // Replace the "Add" button with a "Remove" button for the last duplicate row
            var lastRow = $('.duplicate').last();
            lastRow.find('button').removeClass('btn-primary').addClass('btn-danger').text('-').attr('onclick', 'remove(this)');
        }
    }

    function remove(btn) {
        $(btn).closest('.duplicate').remove();
        duplicateCount--; // Decrement the duplicate count when removing a row
    }

    $('select[name="request"]').change(function() {
        $('.duplicate:not(:first)').remove();
    });
</script>