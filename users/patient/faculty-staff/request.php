<?php

session_start();
include('../../../connection.php');
include('../../../includes/faculty-staff-auth.php');
$module = 'transaction';
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
    <title>Request</title>
    <?php include('../../../includes/header.php') ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">REQUEST</span>
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
                <div class="schedule-button">
                    <button type="button" class="btn-schedule" data-bs-toggle="modal" data-bs-target="#addrequest">Request</button>
                    <?php include('modals/add-request-modal.php');
                    ?>
                </div>
                <div class="content">
                    <h3>Pending Request</h3>
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-2 mb-3">
                                            <input type="date" name="date" value="<?= isset($_GET['date']) == true ? $_GET['date'] : '' ?>" class="form-control">
                                        </div>
                                        <div class="col mb-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="appointment" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Request Type</th>
                                            <th>Date Pickup</th>
                                            <th>Time Pickup</th>
                                            <th>Status</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['date']) && $_GET['date'] != '') {
                                            $date = $_GET['date'];
                                            $count = 1;
                                            $sql = "SELECT * FROM transaction_request WHERE date_pickup='$date' AND patient='$userid' AND status IN ('PENDING', 'COMPLETED') ORDER BY date_pickup, time_pickup  LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT * FROM transaction_request tr INNER JOIN request_type rt on rt.id=tr.request_type WHERE tr.patient='$userid' ORDER BY date_pickup, time_pickup LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                        ?>

                                                <?php
                                                foreach ($result as $data) {

                                                ?>
                                                    <tr>
                                                        <td><?php echo $data['transid'] ?></td>
                                                        <td><?php echo $data['request_type'] ?></td>
                                                        <td><?php echo date("M-d-Y", strtotime($data['date_pickup'])) ?></td>
                                                        <td><?php echo date("h:i a", strtotime($data['time_pickup'])) ?></td>
                                                        <td><?php echo $data['status'] ?></td>
                                                    </tr>
                                                <?php
                                                }
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
                                                    if ($_GET['page-nr'] > $pages) {
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
                            <?php
                                            } else {
                            ?>
                                <tr>
                                    <td colspan="7">
                                        <h4>No record Found</h4>
                                    </td>
                                </tr>
                        <?php
                                            }
                                        }
                                        mysqli_close($conn);
                        ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

</html>