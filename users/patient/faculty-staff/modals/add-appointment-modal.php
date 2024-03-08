<div class="modal fade" id="addappointment" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Request Appointment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="modals/add-appointment.php">
                <div class="modal-body">
                    <div class="mb-2">
                        <input type="hidden" name="patient" value="<?php echo $_SESSION['userid'] ?>" readonly>
                        <label for="patientname" class="col-form-label">Patient Name:</label>
                        <input type="text" class="form-control" name="patientname" value="<?php echo $_SESSION['name'] ?>" readonly>
                    </div>
                    <div class="mb-2">
                        <label for="appointment" class="col-form-label">Type of Appointment:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="appointment" id="appointment" required>
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
                    <div class="mb-2">
                        <label for="purposes" class="col-form-label">Purpose:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="purpose" id="purpose" required>
                            <option value="" disabled selected>-Select Purpose-</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="chiefcomplaint" class="col-form-label">Chief Complaint:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="chiefcomplaint" id="chiefcomplaint" onchange="enableOther(this)" required>
                            <option value="" disabled selected>-Select Chief Complaint-</option>
                        </select>
                    </div>
                    <div class="mb-2 hidden" id="others">
                        <label for="other" class="col-form-label">Others:</label>
                        <input type="text" class="form-control" name="others">
                    </div>
                    <div class="mb-2">
                        <label for="physician" class="col-form-label">Physician:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="physician" id="physician" required>
                            <option value="" disabled selected>-Select Physician-</option>
                            <option value="GODWIN A. OLIVAS">GODWIN A. OLIVAS</option>
                            <option value="EDNA C. MAYCACAYAN">EDNA C. MAYCACAYAN</option>
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
                $("#purpose").html('<option value="" disable selected>-Select Purpose-</option>');
                $("#chiefcomplaint").html('<option value="" disable selected>-Select Chief Complaint-</option>');
            } else {
                $("#purpose").html('<option value="" disable selected>-Select Purpose-</option>');
                $("#chiefcomplaint").html('<option value="" disable selected>-Select Chief Complaint-</option>');
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
    });

    $('#addappointment').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
        $("#purpose").html('<option value="" disable selected>-Select Purpose-</option>');
        $("#chiefcomplaint").html('<option value="" disable selected>-Select Chief Complaint-</option>');
    })

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
</script>