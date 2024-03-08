<?php

session_start();
include('../../../connection.php');
include('../../../includes/student-auth.php');
$module = 'medical';
$userid = $_SESSION['userid'];
$usertype = $_SESSION['usertype'];
$name = $_SESSION['username'];
// get the total nr of rows.
$records = $conn->query("select * from appointment WHERE status='Pending'");
$nr_of_rows = $records->num_rows;

// Setting the number of rows to display in a page.
$rows_per_page = 12;

// calculating the nr of pages.
$pages = ceil($nr_of_rows / $rows_per_page);

// Setting the start from, value.
$start = 0;

// If the user clicks on the pagination buttons.
if (isset($_GET['page-nr'])) {
    $page = $_GET['page-nr'] - 1;
    $start = $page * $rows_per_page;
}
// For the design of page nr
if (isset($_GET['page-nr'])) {
    $id = $_GET['page-nr'];
} else {
    $id = 1;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Medical Documents</title>
    <?php include('../../../includes/header.php') ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">MEDICAL DOCUMENTS</span>
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
                                echo $usertype . ' ' . $name ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="profile">Profile</a></li>
                            <li><a class="dropdown-item" href="../../../logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
        </nav>
        <div class="home-content">
            <div class="overview-boxes">
                <div class="content info">
                    <?php
                    $sql = "SELECT * FROM patient_info p INNER JOIN account a ON a.accountid=p.patientid WHERE p.patientid='$userid'";
                    $result = mysqli_query($conn, $sql);
                    if ($result) {
                        if (mysqli_num_rows($result) > 0) {
                            foreach ($result as $data) {
                    ?>
                                <div class="row p-2">
                                    <div class="col">
                                        <div class="input-group input-group-md">
                                            <input type="text" class="form-control" value="<?= $data['patientid'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-md">
                                            <input type="text" class="form-control" value="<?= $data['firstname'] . ' ' . $data['middlename'] . ' ' . $data['lastname'] ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-2">
                                    <div class="col">
                                        <div class="input-group input-group-md">
                                            <input type="text" class="form-control" value="<?= $data['program'] . ' ' . $data['yearlevel'] . '-' . $data['section']  . $data['block'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group input-group-md">
                                            <input type="text" class="form-control" value="<?= $data['college'] ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
                <?php
                include('medical-doc.php');
                ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

</html>