<?php
include('connection.php');
?>

<div class="modal fade" id="addrequest" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Request</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="modals/add-request.php">
                <div class="modal-body">
                    <div class="mb-2">
                        <input type="hidden" name="patient" value="<?php echo $_SESSION['userid'] ?>" readonly>
                        <label for="patientname" class="col-form-label">Patient Name:</label>
                        <input type="text" class="form-control" name="patientname" value="<?php echo $_SESSION['name'] ?>" readonly>
                    </div>
                    <div class="mb-2">
                        <label for="date" class="col-form-label">Date Pickup:</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>
                    <div class="mb-2">
                        <label for="time" class="col-form-label">Time Pickup:</label>
                        <input type="time" class="form-control" name="time" required>
                    </div>
                    <div class="mb-2">
                        <label for="request" class="col-form-label">Type of Request:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="request" id="request" onchange="enableOther(this)" required>
                            <option value="" disabled selected>-Select Request-</option>
                            <?php
                            $sql = "SELECT * FROM request_type";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <option value="<?= $row['id']; ?>"><?= $row['request_type']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2 hidden" id="medicine">
                        <label for="medicine" class="col-form-label">Medicine:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="medicine" id="medicine">
                            <option value="" disabled selected>-Select Medicine-</option>
                            <?php
                            $sql = "SELECT * FROM inventory_medicine im INNER JOIN medicine m ON m.medid=im.medid ";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <option value="<?= $row['medid']; ?>"><?= $row['medicine']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2 hidden" id="medical">
                        <label for="medical" class="col-form-label">Medical Supply:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="medical" id="medical">
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
                    <div class="mb-2 hidden" id="quantity">
                        <label for="quantity" class="col-form-label">Quantity:</label>
                        <input type="text" class="form-control" name="quantity" placeholder="-Quantity-" required>
                    </div>
                    <div class="mb-2 hidden" id="purpose">
                        <label for="purpose" class="col-form-label">Purpose:</label>
                        <input type="text" class="form-control" name="purpose" id="purpose" placeholder="-Purpose-" required>
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
    function enableOther(answer) {
        console.log(answer.value);
        {
            if (answer.value == 1) {
                document.getElementById('medical').classList.add('hidden');
                document.getElementById('medicine').classList.remove('hidden');
                document.getElementById('quantity').classList.remove('hidden');
                document.getElementById('purpose').classList.remove('hidden');
            } else if (answer.value == 2) {
                document.getElementById('medicine').classList.add('hidden');
                document.getElementById('medical').classList.remove('hidden');
                document.getElementById('quantity').classList.remove('hidden');
                document.getElementById('purpose').classList.remove('hidden');
            } else {
                document.getElementById('medical').classList.add('hidden');
                document.getElementById('medicine').classList.add('hidden');
                document.getElementById('quantity').classList.add('hidden');    
                document.getElementById('purpose').classList.add('hidden');
            }
        }
    };
</script>