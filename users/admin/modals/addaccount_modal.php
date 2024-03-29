<div class="modal fade" id="addaccount" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="location.reload()"></button>
            </div>
            <form method="POST" action="../admin/add/account_add.php" id="form">
                <div class="modal-body">
                    <div class="input-group input-group-md">
                        <input class="form-control" type="file" name="acccsv" accept=".jpg, .jpeg, .png, .csv">
                    </div>
                    <br>
                    <div class="mb-2">
                        <label for="accountid" class="form-label">Account ID:</label>
                        <input type="text" class="form-control" name="accountid" id="accountid" required>
                    </div>
                    <div class="row">
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
                        <div class="col mb-2">
                            <label for="usertype" class="form-label">Usertype:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="usertype" id="usertype" required>
                                <option value="" disabled selected>-Select Usertype-</option>
                                <?php
                                $sql = "SELECT DISTINCT usertype FROM account ORDER BY usertype";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['usertype']; ?>"><?= $row['usertype']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="firstname" class="form-label">First Name:</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" required>
                    </div>
                    <div class="mb-2">
                        <label for="middlename" class="form-label">Middle Name:</label>
                        <input type="text" class="form-control" name="middlename" id="middlename">
                    </div>
                    <div class="mb-2">
                        <label for="lastname" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" required>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">Email Address:</label>
                        <input type="text" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="contactno" class="form-label">Contact Number:</label>
                            <input type="text" maxlength="13" class="form-control" name="contactno" id="contactno" required>
                        </div>
                        <div class="col mb-2">
                            <label for="status" class="form-label">Status:</label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="status" id="status" required>
                                <option value="" disabled selected>-Select Status-</option>
                                <?php
                                $sql = "SELECT * FROM user_status ORDER BY status";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?= $row['status']; ?>"><?= $row['status']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="npassword" class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="col mb-2">
                            <label for="copassword" class="form-label">Confirm Password:</label>
                            <input type="password" maxlength="13" class="form-control" name="cpassword" id="cpassword">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add Account"></input>
                </div>
            </form>
        </div>
    </div>
</div>