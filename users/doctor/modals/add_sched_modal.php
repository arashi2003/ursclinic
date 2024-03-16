<div class="modal fade" id="addsched" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Walk-In Schedule</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../doctor/doc_visit_schedpage.php'"></button>
            </div>
            <form method="POST" action="add/sched.php" id="form">
                <div class="modal-body">
                    <div class="col mb-2">
                        <label for="campus" class="form-label">Campus:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="campus" id="campus" required>
                            <option value="" disabled selected>-Select Campus-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM campus ORDER BY campus";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {?>
                                <option value="<?= $row['campus']; ?>"><?= $row['campus']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="date" class="col-form-label">Date Pickup:</label>
                        <input type="text" class="form-control" name="date" id="showDate" placeholder="mm/dd/yyyy" required>
                    </div>
                    <div class="mb-2">
                        <label for="time_from" class="col-form-label">Time From:</label>
                        <input type="time" class="form-control" name="time_from" required>
                    </div>
                    <div class="mb-2">
                        <label for="time_to" class="col-form-label">Time To:</label>
                        <input type="time" class="form-control" name="time_to" required>
                    </div>
                    <div class="mb-2">
                        <label for="maxp" class="col-form-label">Maximum Number of Patients:</label>
                        <input type="number" class="form-control" min="1" name="maxp" required>
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