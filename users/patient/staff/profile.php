<?php

session_start();
include('../../../connection.php');
include('../../../includes/staff-auth.php');

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
    <?php include('../../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">PROFILE</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <button type="button" class="btn btn-sm position-relative" onclick="window.location.href = 'notification'">
                        <i class='bx bx-bell'></i>
                        <?php
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.lastname, ac.campus 
                        FROM audit_trail au INNER JOIN account ac ON ac.accountid=au.user WHERE 
                        ((au.activity LIKE 'approved%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'disapproved%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'cancelled%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'completed%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'dismissed%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'added%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'added a walk-in schedule%' AND au.activity LIKE '%$campus') 
                        OR (au.activity LIKE 'cancelled a walk-in schedule%' AND au.activity LIKE '%$campus')) 
                        AND au.status = 'unread' AND au.user != '$userid'";
                        $result = mysqli_query($conn, $sql);
                        if ($row = mysqli_num_rows($result)) {
                        ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifes">
                                <?= $row ?>
                            </span>
                        <?php
                        }
                        ?>
                    </button>
                </div>
                <div class="profile-details">
                    <?php
                    $image = "SELECT * FROM patient_image WHERE patient_id = '$userid'";
                    $result = mysqli_query($conn, $image);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <div class="profile">
                        <img src="../../../images/<?php echo $row['image']; ?>">
                    </div>
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
                            <li><a class="dropdown-item" href="../../../logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="home-content">
            <?php
            include('../../../includes/alert.php')
            ?>
            <div class="profile">
                <div class="profile-pic box">
                    <?php
                    $image = "SELECT * FROM patient_image WHERE patient_id = '$userid'";
                    $result = mysqli_query($conn, $image);
                    $row = mysqli_fetch_assoc($result);
                    ?>
                    <form class="form" id="form" action="upload.php" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['patient_id']; ?>">
                        <div class="upload">
                            <img src="../../../images/<?php echo $row['image']; ?>" id="image">
                            <div class="rightRound" id="upload">
                                <input type="file" name="fileImg" id="fileImg" accept=".jpg, .jpeg, .png">
                                <i class='bx bx-camera'></i>
                            </div>

                            <div class="leftRound" id="cancel" style="display: none;">
                                <i class='bx bx-x'></i>
                            </div>
                            <div class="rightRound" id="confirm" style="display: none;">
                                <input type="submit">
                                <i class='bx bx-check'></i>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="profile-info box">
                    <div class="row">
                        <?php
                        $sql = "SELECT p.patientid, p.address, p.designation, emcon_name, emcon_number, p.sex, p.birthday, p.department, p.campus, p.email, p.contactno, a.firstname, a.middlename, a.lastname from patient_info p INNER JOIN account a on a.accountid='$userid' WHERE patientid='$userid'";
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
                        $age = floor((time() - strtotime($row['birthday'])) / 31556926);
                        $fullname = ucwords(strtolower($row['firstname'])) . " " . strtoupper($middleinitial) . " " . ucfirst(strtolower($row['lastname']));
                        ?>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <div class="input-group input-group-md mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Employee No.:</span>
                                    <input type="text" class="form-control" name="patientid" value="<?php echo $row['patientid'] ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="col-md-8 mb-2">
                                <div class="input-group input-group-md mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Full name:</span>
                                    <input type="text" class="form-control" name="patientname" value="<?php echo $fullname ?>" readonly disabled>
                                </div>
                            </div>

                            <div class="col-md-4 mb-2">
                                <div class="input-group input-group-md mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Designation:</span>
                                    <input type="text" class="form-control" name="designation" value="<?php echo $row['designation'] ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="input-group input-group-md mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Age:</span>
                                    <input type="text" class="form-control" name="age" value="<?php echo $age ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="input-group input-group-md mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Sex:</span>
                                    <input type="text" class="form-control" name="sex" value="<?php echo $row['sex'] ?>" readonly disabled>
                                </div>
                            </div>

                            <div class="col-md-4 mb-2">
                                <div class="input-group input-group-md mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Birthday:</span>
                                    <input type="text" class="form-control" name="birthday" value="<?php echo date("F d, Y", strtotime($row['birthday'])) ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="input-group input-group-md mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Campus:</span>
                                    <input type="text" class="form-control" name="campus" value="<?php echo $row['campus'] ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="input-group input-group-md mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Department:</span>
                                    <input type="text" class="form-control" name="department" value="<?php echo $row['department'] ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="input-group input-group-md mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Contact No.:</span>
                                    <input type="text" class="form-control" name="contactno" value="<?php echo $row['contactno'] ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="col-md-8 mb-2">
                                <div class="input-group input-group-md mb-2">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Email:</span>
                                    <input type="text" class="form-control" name="email" value="<?php echo $row['email'] ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="input-group input-group-md mb-1">
                                    <span class="input-group-text" id="inputGroup-sizing-md">Address:</span>
                                    <input type="text" class="form-control" name="contactno" value="<?php echo $row['address'] ?>" readonly disabled>
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateacc<?php echo $userid; ?>">Update</button>
                                    <?php
                                    include('modals/update_account_modal.php'); ?>
                                </div>
                            </div>
                        </div>
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
</script>

<script type="text/javascript">
    document.getElementById("fileImg").onchange = function() {
        document.getElementById("image").src = URL.createObjectURL(fileImg.files[0]); // Preview new image

        document.getElementById("cancel").style.display = "block";
        document.getElementById("confirm").style.display = "block";

        document.getElementById("upload").style.display = "none";
    }

    var userImage = document.getElementById('image').src;
    document.getElementById("cancel").onclick = function() {
        document.getElementById("image").src = userImage; // Back to previous image

        document.getElementById("cancel").style.display = "none";
        document.getElementById("confirm").style.display = "none";

        document.getElementById("upload").style.display = "block";
    }
</script>

</html>