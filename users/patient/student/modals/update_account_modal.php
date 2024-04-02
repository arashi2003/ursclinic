<div class="modal fade" id="updateacc<?php echo $userid; ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Account Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload()"></button>
            </div>
            <form method="POST" action="modals/update/update_account.php" id="form">
                <div class="modal-body">
                    <div class="col-md-6 mb-2">
                        <label for="accountid" class="form-label">Account ID:</label>
                        <input type="text" class="form-control" name="accountid" id="accountid" value="<?php echo $userid?>" disabled>
                    </div>
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
                        <input type="password" maxlength="13" class="form-control" name="copassword" id="copassword" oninput="checkPasswordMatch()">
                        <div id="passwordMatchError" style="color: red;"></div>
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