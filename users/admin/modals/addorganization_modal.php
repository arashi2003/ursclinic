<div class="modal fade" id="addorganization" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Entry</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/settings/organization.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="accountid" class="form-label">Account ID:</label>
                        <input type="text" class="form-control" name="accountid" id="accountid">
                    </div>
                    <div class="mb-2">
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
                        <label for="firstname" class="form-label">First Name:</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" required>
                    </div>
                    <div class="mb-2">
                        <label for="middlename" class="form-label">Middle Name:</label>
                        <input type="text" class="form-control" name="middlename" id="middlename" >
                    </div>
                    <div class="mb-2">
                        <label for="lastname" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" required>
                    </div>
                    <div class="mb-2">
                        <label for="extension" class="form-label">Title:</label>
                        <input type="text" class="form-control" name="extension" id="extension" required>
                    </div>
                    <div class="mb-2">
                        <label for="status" class="form-label">Position:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="position" id="position" required>
                            <option value="" disabled selected>-Select Position-</option>
                            <option value="Head, Health Services Unit">Head, Health Services Unit</option>
                            <option value="Campus Director">Campus Director</option>
                            <option value="Campus Nurse">Campus Nurse</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add Entry"></input>
                </div>
            </form>
        </div>
    </div>
    <!-- ung script na clear form pag nag close-->
</div>