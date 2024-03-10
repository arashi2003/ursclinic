<div class="modal fade" id="updateaccount<?php echo $userid; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Account Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.href = '../profile.php'"></button>
            </div>
            <form method="POST" action="modals/update/update_account.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="accountid" class="form-label">Account ID:</label>
                        <input type="text" class="form-control" name="accountid" id="accountid" value="<?php echo $userid?>" readonly disabled>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="campus" class="form-label">Campus:</label>
                            <input type="text" class="form-control" name="campus" id="campus" value="<?php echo $row['campus']?>" readonly disabled>
                        </div>
                        <div class="col mb-2">
                            <label for="usertype" class="form-label">Usertype:</label>
                            <input type="text" class="form-control" name="usertype" id="usertype" value="<?php echo $row['usertype']?>" readonly disabled>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="firstname" class="form-label">First Name:</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $row['firstname']?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="middlename" class="form-label">Middle Name:</label>
                        <input type="text" class="form-control" name="middlename" id="middlename" value="<?php echo $row['middlename']?>">
                    </div>
                    <div class="mb-2">
                        <label for="lastname" class="form-label">Last Name:</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $row['lastname']?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">Email Address:</label>
                        <input type="text" class="form-control" name="email" id="email" value="<?php echo $row['email']?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="contactno" class="form-label">Contact Number:</label>
                        <input type="text" maxlength="13" class="form-control" name="contactno" id="contactno" value="<?php echo $row['contactno']?>" required>
                    </div>

                    <!-- responsive na magiging required fields ung mga password related textbox-->

                    <div class="mb-2">
                        <label for="cupassword" class="form-label">Current Password:</label>
                        <input type="password" class="form-control" name="cupassword" id="cupassword">
                    </div>
                    <div class="mb-2">
                        <label for="npassword" class="form-label">New Password:</label>
                        <input type="password" class="form-control" name="npassword" id="npassword">
                    </div>
                    <div class="mb-2">
                        <label for="copassword" class="form-label">Confirm Password:</label>
                        <input type="password" maxlength="13" class="form-control" name="copassword" id="copassword">
                    </div>


                    <div class="mb-2">
                        <label for="status" class="form-label">Status:</label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="status" id="status" required>
                            <option value="" disabled selected>-Select Status-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM user_status ORDER BY status";
                            $result = mysqli_query($conn, $sql);
                            while ($data = mysqli_fetch_array($result)) {
                                if ($row['status'] == $data['status'])
                                {
                            ?>
                                <option value="<?= $data['status']; ?>" selected><?= $data['status']; ?></option>
                            <?php } else
                            {?>
                                <option value="<?= $data['status']; ?>"><?= $data['status']; ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Update"></input>
                </div>
            </form>
        </div>
    </div>
</div>