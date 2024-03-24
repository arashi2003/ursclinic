<div class="modal fade" id="addappointment" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Appointment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="nurseappointmentadd.php">
                <div class="modal-body">
                    <div class="mb-2">
                        <?php
                        include("connection.php");
                        $query = "SELECT CONCAT(firstname, ' ', middlename, ' ', lastname) as customer_name FROM patient_info";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        }
                        ?>
                        <label for="exampleDataList" class="form-label">Patient Name:</label>
                        <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Search patient name...">
                        <datalist id="datalistOptions">
                            <option value="">Select Patient</option>
                            <?php
                            foreach ($options as $option) {
                            ?>
                                <option><?php echo $option['customer_name'] ?></option>
                            <?php
                            }
                            ?>
                        </datalist>
                    </div>
                    <div class="mb-2">
                        <label for="appointmentdate" class="col-form-label">Appointment Date:</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>
                    <div class="mb-2">
                        <label for="appointmenttime" class="col-form-label">Appointment Time:</label>
                        <input type="time" class="form-control" name="time" required>
                    </div>
                    <div class="mb-2">
                        <label for="purposes" class="col-form-label">Purpose:</label>
                        <select class="form-select form-select-md mb-2" id="slct1" aria-label=".form-select-md example" name="purposes" required>
                            <option>Choose purpose</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="complaint" class="col-form-label">Chief Complaint:</label>
                        <select class="form-select form-select-md mb-2" id="slct2" aria-label=".form-select-md example" name="complaint" required></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add"></input>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let purpose = ["Medical", "Check Up", "Dental"];
    let medical = ["Vomiting", "Diarrhea", "Headache"];
    let checkup = ["Fever", "Flu", "Sprain"];
    let dental = ["Teeth Cleaning", "Dental Fissure Sealants", "Tooth Removal (Extraction)"];

    let slct1 = document.getElementById("slct1");
    let slct2 = document.getElementById("slct2");

    purpose.forEach(function addPurposes(item) {
        let option = document.createElement("option");
        option.text = item;
        option.value = item;
        slct1.appendChild(option);
    });

    slct1.onchange = function() {
        slct2.innerHTML = "<option></option>";
        if (this.value == "Medical") {
            addToSlct2(medical);
        }
        if (this.value == "Check Up") {
            addToSlct2(checkup);
        }
        if (this.value == "Dental") {
            addToSlct2(dental);
        }
    }

    function addToSlct2(arr) {
        arr.forEach(function(item) {
            let option = document.createElement("option");
            option.text = item;
            option.value = item;
            slct2.appendChild(option);
        });
    }
</script>