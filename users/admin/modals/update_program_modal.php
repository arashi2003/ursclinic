<div class="modal fade" id="updateprogram<?php echo $data['id']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Program</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../admin/program.php'"></button>
            </div>
            <form method="POST" action="modals/update/program.php" id="form">
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
                                if ($data['department'] == $row['department'])
                                {
                            ?>
                                <option value="<?= $row['department']; ?>" selected><?= $row['department']; ?></option>
                            <?php } else
                            {?>
                                <option value="<?= $row['department']; ?>"><?= $row['department']; ?></option>
                            <?php }} ?>
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
                                if ($data['college'] == $row['college'])
                                {
                            ?>
                                <option value="<?= $row['college']; ?>" selected><?= $row['college']; ?></option>
                            <?php } else
                            {?>
                                <option value="<?= $row['college']; ?>"><?= $row['college']; ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="program" class="form-label">Program:</label>
                        <input type="text" name="programid" value="<?php echo $data['id']?>" hidden>
                        <input type="text" class="form-control" name="program" id="program" value="<?php echo $data['program']?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="abbrev" class="form-label">Abbreviation:</label>
                        <input type="text" class="form-control" name="abbrev" id="abbrev" value="<?php echo $data['abbrev']?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Save"></input>
                </div>
            </form>
        </div>
    </div>
</div>