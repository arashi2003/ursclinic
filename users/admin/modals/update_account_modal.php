<div class="modal fade" id="updateacc<?php echo $data['accountid']; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Account Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/update/update_account.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="accountid" class="form-label">Account ID: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="text" class="form-control" name="accountid" id="accountid" value="<?php echo $data['accountid']?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label for="campus" class="form-label">Campus: <i style="color: red; font-size: 20px">*</i></label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="campus" id="campus" required>
                                <option value="" disabled selected>-Select Campus-</option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM campus ORDER BY campus";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    if ($data['campus'] == $row['campus'])
                                    {
                                ?>
                                    <option value="<?= $row['campus']; ?>" selected><?= $row['campus']; ?></option>
                                <?php } else
                                {?>
                                    <option value="<?= $row['campus']; ?>"><?= $row['campus']; ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="usertype" class="form-label">Usertype: <i style="color: red; font-size: 20px">*</i></label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="usertype" id="usertype" required>
                                <option value="" disabled selected>-Select Usertype-</option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT DISTINCT usertype FROM account ORDER BY usertype";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    if ($data['usertype'] == $row['usertype'])
                                    {
                                ?>
                                    <option value="<?= $row['usertype']; ?>" selected><?= $row['usertype']; ?></option>
                                <?php } else
                                {?>
                                    <option value="<?= $row['usertype']; ?>"><?= $row['usertype']; ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label for="firstname" class="form-label">First Name: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $data['firstname']?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="middlename" class="form-label">Middle Name: <i style="color: gray; font-size: 14px">(optional)</i></label>
                        <input type="text" class="form-control" name="middlename" id="middlename" value="<?php echo $data['middlename']?>">
                    </div>
                    <div class="mb-2">
                        <label for="lastname" class="form-label">Last Name: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $data['lastname']?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">Email Address: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="text" class="form-control" name="email" id="email" value="<?php echo $data['email']?>" required>
                    </div>
                    <div class="mb-2">
                        <label for="contactno" class="form-label">Contact Number: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="text" maxlength="13" class="form-control" name="contactno" id="contactno" value="<?php echo $data['contactno']?>" required>
                    </div>

                    <!-- responsive na magiging required fields ung mga password related textbox-->

                    <div class="mb-2">
                        <label for="cupassword" class="form-label">Current Password: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="password" class="form-control" name="cupassword" id="cupassword">
                    </div>
                    <div class="mb-2">
                        <label for="npassword" class="form-label">New Password: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="password" class="form-control" name="npassword" id="npassword">
                    </div>
                    <div class="mb-2">
                        <label for="copassword" class="form-label">Confirm Password: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="password" maxlength="13" class="form-control" name="copassword" id="copassword" oninput="checkPasswordMatch()">
                        <div id="passwordMatchError" style="color: red;"></div>
                    </div>


                    <div class="mb-2">
                        <label for="status" class="form-label">Status: <i style="color: red; font-size: 20px">*</i></label>
                        <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="status" id="status" required>
                            <option value="" disabled selected>-Select Status-</option>
                            <?php
                            include('connection.php');
                            $sql = "SELECT * FROM user_status ORDER BY status";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                if ($data['status'] == $row['status'])
                                {
                            ?>
                                <option value="<?= $row['status']; ?>" selected><?= $row['status']; ?></option>
                            <?php } else
                            {?>
                                <option value="<?= $row['status']; ?>"><?= $row['status']; ?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Update"></input>
                    &ThickSpace;
                    <input type="reset" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function checkPasswordMatch() {
        var password = document.getElementById("npassword").value;
        var confirmPassword = document.getElementById("copassword").value;

        // Check if the passwords match
        if (password !== confirmPassword) {
            document.getElementById("passwordMatchError").innerHTML = "Passwords do not match";
        } else {
            document.getElementById("passwordMatchError").innerHTML = "";
        }
    }
</script>