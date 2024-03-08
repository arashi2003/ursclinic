<?php

session_start();
include('../../connection.php');
include('../../includes/admin-auth.php');
$module = 'account_add';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>User Accounts</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">ADD ACCOUNT</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <i class='bx bx-bell'></i>
                </div>
                <div class="profile-details">
                    <i class='bx bx-user-circle'></i>
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="admin_name">
                                <?php
                                echo $_SESSION['usertype'] . ' ' . $_SESSION['username'] ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profile">Profile</a></li>
                            <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutmodal">Log Out</button></li>

                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <?php include('modals/logout_modal.php'); ?>
        <div class="home-content">
            <div class="overview-boxes">
                <div class="content">
                    <div class="row">
                        <div class="input-group input-group-md">
                            <input id="fileInput" class="form-control" type="file" name="acccsv" accept=".jpg, .jpeg, .png, .csv">
                            <button id="uploadButton" class="btn btn-primary" type="submit" disabled>Upload</button>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="row">
                        <form method="POST" action="add/account_add.php" id="form">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Account ID:</span>
                                        <input type="text" class="form-control" name="accountid" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Campus:</span>
                                        <select class="form-control" aria-label=".form-select-md example" name="campus" id="campus" required>
                                            <option value="" disabled selected></option>
                                            <?php
                                            include('connection.php');
                                            $sql = "SELECT * FROM campus ORDER BY campus";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_array($result)) { ?>
                                                <option value="<?= $row['campus']; ?>"><?= $row['campus']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Usertype:</span>
                                        <select class="form-control" aria-label=".form-select-md example" name="usertype" id="usertype" required>
                                            <option value="" disabled selected></option>
                                            <?php
                                            include('connection.php');
                                            $sql = "SELECT DISTINCT usertype FROM account ORDER BY usertype";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_array($result)) { ?>
                                                <option value="<?= $row['usertype']; ?>"><?= $row['usertype']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">First Name:</span>
                                        <input type="text" class="form-control" name="firstname" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Middle Name:</span>
                                        <input type="text" class="form-control" name="middlename">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Last Name:</span>
                                        <input type="text" class="form-control" name="lastname" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Email Address:</span>
                                        <input type="text" class="form-control" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Contact Number:</span>
                                        <input type="text" maxlength="13" class="form-control" name="contactno" id="contactno" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Password:</span>
                                        <input type="password" class="form-control" name="password" id="password" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Confirm Password:</span>
                                        <input type="password" maxlength="13" class="form-control" name="cpassword" id="cpassword" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group input-group-md mb-2">
                                        <span class="input-group-text" id="inputGroup-sizing-md">Status:</span>
                                        <select class="form-control" aria-label=".form-select-md example" name="status" id="status" required>
                                            <option value="" disabled selected></option>
                                            <?php
                                            include('connection.php');
                                            $sql = "SELECT * FROM user_status ORDER BY status";
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_array($result)) {
                                                if ($row['status'] == "ACTIVE") {
                                            ?>
                                                    <option value="<?= $row['status']; ?>" selected><?= $row['status']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?= $row['status']; ?>"><?= $row['status']; ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">

                                </div>
                            </div>









                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Add Account"></input>
                                &ThickSpace;
                                <input type="reset" class="btn btn-danger" value="Cancel"></input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </section>

</body>

<script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
            arrowParent.classList.toggle("showMenu");
        });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });

    const fileInput = document.getElementById('fileInput');
    const uploadButton = document.getElementById('uploadButton');

    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            uploadButton.disabled = false;
        } else {
            uploadButton.disabled = true;
        }
    });
</script>

</html>