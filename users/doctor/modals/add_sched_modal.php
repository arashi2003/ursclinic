<div class="modal fade" id="addsched" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Walk-In Schedule</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="add/sched.php" id="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="campus" class="form-label">Campus:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="campus" id="campus" required>
                                <option value="" disabled selected></option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM campus WHERE campus != 'UNIVERSITY' ORDER BY campus";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) { ?>
                                    <option value="<?= $row['campus']; ?>"><?= $row['campus']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="maxp" class="col-form-label">Maximum Number of Patients:</label>
                            <input type="number" min="0" class="form-control" min="1" name="maxp" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="date" class="col-form-label">Date:</label>
                            <input type="text" class="form-control" name="date" id="showDate" placeholder="yyyy/mm/dd" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="time_from" class="col-form-label">Time From:</label>
                            <input type="time" class="form-control" name="time_from" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="time_to" class="col-form-label">Time To:</label>
                            <input type="time" class="form-control" name="time_to" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add"></input>
                    &ThickSpace;
                    <input type="reset" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
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
            beforeShowDay: function(date) {
                var day = date.getDay();
                return [(day != 0)]; // Disable Sundays
            }
        });
    });
</script>