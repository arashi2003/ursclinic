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
                        <input type="hidden" name="patient" value="<?php echo $_SESSION['userid'] ?>" readonly>
                        <label for="patientname" class="col-form-label">Patient Name:</label>
                        <input type="text" class="form-control" name="patientname" value="<?php echo $_SESSION['name'] ?>" readonly disabled>
                    </div>
                    <div class="mb-2">
                        <label for="appointment" class="col-form-label">Type of Appointment:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="appointment" id="appointment" onchange="enableAppointment(this)">
                            <option value="" disabled selected>-Select Appointment-</option>
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
                            <label for="date" class="col-form-label">Date Pickup:</label>
                            <input type="text" class="form-control" name="date" id="showDate" placeholder="mm/dd/yyyy">
                        </div>
                        <div class="col hidden" id="timeDiv">
                            <label for="time" class="col-form-label">Time Pickup:</label>
                            <select class="form-select form-select-md" aria-label=".form-select-md example" name="time" id="time">
                                <option value="" disabled selected>-:-- --</option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM time_pickup WHERE isSelected = 'No'";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    $time = date('h:i A', strtotime($row['time'])); // Format time as '12:00 PM'
                                ?>
                                    <option value="<?= $time; ?>"><?= $time; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 hidden" id="purposeDiv">
                        <label for="purposes" class="col-form-label">Purpose:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="purpose" id="purpose">
                            <option value="" disabled selected>-Select Purpose-</option>
                        </select>
                    </div>
                    <div class="mb-2 hidden" id="ccDiv">
                        <label for="chiefcomplaint" class="col-form-label">Chief Complaint:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="chiefcomplaint" id="chiefcomplaint" onchange="enableOther(this)">
                            <option value="" disabled selected>-Select Chief Complaint-</option>
                        </select>
                    </div>
                    <div class="mb-2 hidden" id="others">
                        <label for="other" class="col-form-label">Others:</label>
                        <input type="text" class="form-control" name="others">
                    </div>
                    <div class="row duplicate">
                        <div class="col-md hidden" id="medDupDiv">
                            <label for="medicine" class="col-form-label">Medicine:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="medicine[]" id="medicine">
                                <option value="" disabled selected>-Select Medicine-</option>
                                <?php
                                $sql = "SELECT * FROM inventory_medicine im INNER JOIN medicine m ON m.medid=im.medid ";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['medid']; ?>"><?= $row['medicine'] . ' ' . $row['unit_cost']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md hidden" id="supDupDiv">
                            <label for="medical" class="col-form-label">Medical Supply:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="medical[]" id="medical">
                                <option value="" disabled selected>-Select Medical Supply-</option>
                                <?php
                                $sql = "SELECT * FROM inventory_supply i INNER JOIN supply s ON s.supid=i.supid ";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['supid']; ?>"><?= $row['supply']; ?></option>
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
                    <div class="mb-2 hidden" id="physicianDiv">
                        <label for="physician" class="col-form-label">Physician:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="physician" id="physician">
                            <option value="" disabled selected>-Select Physician-</option>
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
                $("#purpose").html('<option value="" disabled selected>-Select Purpose-</option>');
                $("#chiefcomplaint").html('<option value="" disabled selected>-Select Chief Complaint-</option>');
                $("#physician").html('<option value="" disabled selected>-Select Physician-</option>');
            } else {
                $("#purpose").html('<option value="" disabled selected>-Select Purpose-</option>');
                $("#chiefcomplaint").html('<option value="" disabled selected>-Select Chief Complaint-</option>');
                $("#physician").html('<option value="" disabled selected>-Select Physician-</option>');
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
            //altFormat: "yyyy-mm-dd",
            //format: "MM d, yyyy",
            beforeShowDay: function(date) {
                var day = date.getDay();
                return [(day != 0)]; // Disable Sundays
            }
        });
    });
</script>

<script type="text/javascript">
    function enableAppointment(answer) {
        console.log(answer.value);
        {
            if (answer.value == 1 || answer.value == 2 || answer.value == 3) {
                document.getElementById('dateDiv').classList.remove('hidden');
                document.getElementById('timeDiv').classList.remove('hidden');
                document.getElementById('purposeDiv').classList.remove('hidden');
                document.getElementById('ccDiv').classList.remove('hidden');
                document.getElementById('medDupDiv').classList.add('hidden');
                document.getElementById('supDupDiv').classList.add('hidden');
                document.getElementById('quantityDiv').classList.add('hidden');
                document.getElementById('physicianDiv').classList.remove('hidden');
                document.getElementById('others').classList.add('hidden');
            } else if (answer.value == 4) {
                document.getElementById('dateDiv').classList.add('hidden');
                document.getElementById('timeDiv').classList.add('hidden');
                document.getElementById('purposeDiv').classList.remove('hidden');
                document.getElementById('ccDiv').classList.remove('hidden');
                document.getElementById('supDupDiv').classList.add('hidden');
                document.getElementById('medDupDiv').classList.remove('hidden');
                document.getElementById('quantityDiv').classList.remove('hidden');
                document.getElementById('physicianDiv').classList.add('hidden');
                document.getElementById('others').classList.add('hidden');
            } else if (answer.value == 5) {
                document.getElementById('dateDiv').classList.add('hidden');
                document.getElementById('timeDiv').classList.add('hidden');
                document.getElementById('purposeDiv').classList.remove('hidden');
                document.getElementById('ccDiv').classList.remove('hidden');
                document.getElementById('medDupDiv').classList.add('hidden');
                document.getElementById('supDupDiv').classList.remove('hidden');
                document.getElementById('quantityDiv').classList.remove('hidden');
                document.getElementById('physicianDiv').classList.add('hidden');
                document.getElementById('others').classList.add('hidden');
            } else if (answer.value == 6 || answer.value == 7) {
                document.getElementById('dateDiv').classList.remove('hidden');
                document.getElementById('timeDiv').classList.remove('hidden');
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