<div class="modal fade" id="addaccount" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="../admin/add/account_add.php" id="form">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="accountid" class="form-label">Student/Employee ID: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="text" class="form-control" name="accountid" id="accountid" onchange="fetchAccountData()" required>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="campus" class="form-label">Campus: <i style="color: red; font-size: 20px">*</i></label>
                            <select class="form-select form-select-md mb-2" aria-label=".form-select-md example" name="campus" id="campus" required>
                                <option value="" disabled selected>-Select Campus-</option>
                                <?php
                                include('connection.php');
                                $sql = "SELECT * FROM campus ORDER BY campus";
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) { ?>
                                    <option value="<?= $row['campus']; ?>"><?= $row['campus']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="usertype" class="form-label">Usertype: <i style="color: red; font-size: 20px">*</i></label>
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
                        <label for="firstname" class="form-label">First Name: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="text" class="form-control" name="firstname" id="firstname" required>
                    </div>
                    <div class="mb-2">
                        <label for="middlename" class="form-label">Middle Name: <i style="color: gray; font-size: 14px">(optional)</i></label>
                        <input type="text" class="form-control" name="middlename" id="middlename">
                    </div>
                    <div class="mb-2">
                        <label for="lastname" class="form-label">Last Name: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="text" class="form-control" name="lastname" id="lastname" required>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">Email Address: <i style="color: red; font-size: 20px">*</i></label>
                        <input type="text" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="row">
                        <div class="col mb-2">
                            <label for="contactno" class="form-label">Contact Number: <i style="color: red; font-size: 20px">*</i></label>
                            <input type="text" maxlength="13" class="form-control" name="contactno" id="contactno" required>
                        </div>
                        <div class="col mb-2">
                            <label for="status" class="form-label">Status: <i style="color: red; font-size: 20px">*</i></label>
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
                            <label for="password" class="form-label">Password: <i style="color: red; font-size: 20px">*</i></label>
                            <input type="password" minlength="8" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="col mb-2">
                            <label for="cpassword" class="form-label">Confirm Password: <i style="color: red; font-size: 20px">*</i></label>
                            <input type="password" minlength="8" class="form-control" name="cpassword" id="cpassword" oninput="checkPasswordMatch()" required>
                            <div id="passwordMatchError" style="color: red;"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Add Account"></input>
                    &ThickSpace;
                    <input type="reset" class="btn btn-danger" value="Cancel" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></input>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function fetchAccountData() {
        var accountId = document.getElementById('accountid').value;
        console.log('Account ID:', accountId);
        if (accountId.trim() !== '') {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'modals/check_account.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        console.log(response); // Check response in console
                        if (response.error) {
                            // Account does not exist
                            document.getElementById('accountid').classList.add('is-invalid');
                            document.getElementById('accountid').setCustomValidity(response.error);
                            document.getElementById('accountid').reportValidity();
                        } else {
                            // Account exists
                            document.getElementById('accountid').classList.remove('is-invalid');
                            document.getElementById('accountid').setCustomValidity('');
                            // Additional actions if needed
                        }
                    } else {
                        console.error('Error: Unable to fetch account data');
                    }
                }
            };
            xhr.send('accountid=' + encodeURIComponent(accountId));
        } else {
            // Clear any previous errors
            document.getElementById('accountid').classList.remove('is-invalid');
            document.getElementById('accountid').setCustomValidity('');
        }
    }
</script>

<script>
    function checkPasswordMatch() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("cpassword").value;

        // Check if the passwords match
        if (password !== confirmPassword) {
            document.getElementById("passwordMatchError").innerHTML = "Passwords do not match";
        } else {
            document.getElementById("passwordMatchError").innerHTML = "";
        }
    }
</script>