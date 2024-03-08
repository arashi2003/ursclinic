<?php

session_start();
include('../../../connection.php');
include('../../../includes/studentauthenticate.php');
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
    <title>Nurse Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="images/university-seal.png">
    <link rel="stylesheet" type="text/css" href="../../../css/dashboard.css?v=<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body id="<?php echo $id ?>">
<?php include ('../../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">APPOINTMENT</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <i class='bx bx-bell'></i>
                </div>
                <div class="profile-details">
                    <i class='bx bx-user-circle'></i>
                    <span class="admin_name">
                        <?php
                        echo $_SESSION['username'] ?>
                    </span>
                </div>
        </nav>
        <div class="home-content">
            <div class="overview-boxes">
                <div class="schedule-button">
                    <button type="button" class="btn-schedule" data-bs-toggle="modal" data-bs-target="#addappointment">Request Appointment</button>
                    <?php
                    ?>
                </div>
                <div class="content">
                    <div class="title">
                        <h3>Pending Appointments</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Appointment No.</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Patient name</th>
                                <th>Purpose</th>
                                <th>Chief Complaint</th>
                                <th>Status</th>
                                <th>Action</th>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM appointment WHERE status='Pending' ORDER BY date, time ASC LIMIT $start, $rows_per_page";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['appointment_no'] ?></td>
                                    <td><?php echo $row['appointment_date'] ?></td>
                                    <td><?php echo date("h:i a", strtotime($row['appointment_time'])) ?></td>
                                    <td><?php echo $row['patient_name'] ?></td>
                                    <td><?php echo $row['purpose'] ?></td>
                                    <td><?php echo $row['chief_complaint'] ?></td>
                                    <td><?php echo $row['status'] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#nurseappointmentapprovemodal<?php echo $row['appointment_no'] ?>">Approve</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#nurseappointmentdeletemodal<?php echo $row['appointment_no'] ?>">Cancel</button>
                                    </td>
                                </tr>
                            <?php
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>

                    <div class="pagination">
                        <div class="page-info">
                            <?php
                            if (!isset($_GET['page-nr'])) {
                                $page = 1;
                            } else {
                                $page = $_GET['page-nr'];
                            }
                            ?>
                            <p>Showing <?php echo $page ?> of <?php echo $pages; ?> pages</p>
                        </div>
                        <div class="pages">
                            <!-- Go to the previous page -->
                            <?php
                            if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) {
                            ?> <a href="?page-nr=<?php echo $_GET['page-nr'] - 1 ?>">Previous</a>
                            <?php
                            } else {
                            ?>
                                <a>Previous</a>
                            <?php
                            }
                            ?>
                            <!-- Output the page numbers -->
                            <div class="page-numbers">
                                <?php
                                ?> <a href="?page-nr=<?php echo $page ?>"><?php echo $page ?></a>
                                <?php
                                ?>
                            </div>
                            <!-- Go to the next page -->
                            <?php
                            if (isset($_GET['page-nr'])) {
                                if ($_GET['page-nr'] >= $pages) {
                            ?> <a>Next</a>
                                <?php
                                } else {
                                ?> <a href="?page-nr=<?php echo $_GET['page-nr'] + 1 ?>">Next</a>
                                <?php
                                }
                            } else {
                                ?>
                                <a href="?page-nr=2">Next</a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</body>

<script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function() {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
            sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else
            sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

</html>