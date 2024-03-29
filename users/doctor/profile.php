<?php

session_start();
include('../../connection.php');
include('../../includes/doctor-auth.php');

$module = 'profile';
$userid = $_SESSION['userid'];
$usertype = $_SESSION['usertype'];
$name = $_SESSION['username'];
$campus = $_SESSION['campus'];

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Profile Information</title>
    <?php include('../../includes/header.php') ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">PROFILE</span>
            </div>
            <div class="right-nav">
                <div class="profile-details">
                    <i class='bx bx-user-circle'></i>
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="admin_name">
                                <?php
                                echo $name ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="usertype"><?= $usertype ?></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="profile">Profile</a></li>
                            <li><a class="dropdown-item" href="../../logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="home-content">
            <?php include('../../includes/alert.php'); ?>
            <div class="profile">
                <div class="profile-info box">
                    <?php
                    $sql = "SELECT * FROM account WHERE accountid='$userid'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    if (count(explode(" ", $row['middlename'])) > 1) {
                        $middle = explode(" ", $row['middlename']);
                        $letter = $middle[0][0] . $middle[1][0];
                        $middleinitial = $letter . ".";
                    } else {
                        $middle = $row['middlename'];
                        if ($middle == "" or $middle == " ") {
                            $middleinitial = "";
                        } else {
                            $middleinitial = substr($middle, 0, 1) . ".";
                        }
                    }
                    ?>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Campus:</span>
                        <input type="text" class="form-control" name="campus" value="<?php echo $row['campus'] ?>" readonly disabled>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Employee No.:</span>
                        <input type="text" class="form-control" name="patientid" value="<?php echo $row['accountid'] ?>" readonly disabled>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Full name:</span>
                        <input type="text" class="form-control" name="patientname" value="<?php echo ucwords(strtolower($row['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($row['lastname'])) ?>" readonly disabled>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Designation:</span>
                        <input type="text" class="form-control" name="designation" value="<?php echo $row['usertype'] ?>" readonly disabled>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Email:</span>
                        <input type="text" class="form-control" name="email" value="<?php echo $row['email'] ?>" readonly disabled>
                    </div>
                    <div class="input-group input-group-md mb-2">
                        <span class="input-group-text" id="inputGroup-sizing-md">Contact No.:</span>
                        <input type="text" class="form-control" name="contactno" value="<?php echo $row['contactno'] ?>" readonly disabled>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateaccount<?php echo $userid; ?>">Update</button>
                        <?php
                        include('modals/update_account_modal.php'); ?>
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
</script>

</html>