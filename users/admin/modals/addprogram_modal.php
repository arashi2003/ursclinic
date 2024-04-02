<div class="modal fade" id="addprogram" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Program</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/settings/program.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="department" class="form-label">Department:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="department" id="department" required>
                            <option value="" disabled selected>-Select Department-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM department ORDER BY department";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <option value="<?= $row['department']; ?>"><?= $row['department']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="college" class="form-label">College:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="college" id="college">
                            <option value="" selected>-Select College-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM college ORDER BY college";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                            ?>
                                <option value="<?= $row['college']; ?>"><?= $row['college']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="program" class="form-label">Program:</label>
                        <input type="text" class="form-control" name="program" id="program" required>
                    </div>
                    <div class="mb-2">
                        <label for="abbrev" class="form-label">Abbreviation:</label>
                        <input type="text" class="form-control" name="abbrev" id="abbrev" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add Program"></input>
                    &ThickSpace;
                    <input type="submit" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#addprogram').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
        //add ung sa dropdown
    });
</script>