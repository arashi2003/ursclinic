<?php

session_start();
include('../../connection.php');
include('../../includes/admin-auth.php');
$module = 'buar';
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// get the total nr of rows.
$records = $conn->query("SELECT * FROM audit_trail WHERE activity LIKE '%backed up the database%' OR activity LIKE '%restored the database%'");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php') ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Backup</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">BACKUP</span>
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
            <div class="overview-boxes">
                <div class="content">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="head">
                                    <tr>
                                        <th>Date and Time</th>
                                        <th>Activity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    $sql = "SELECT * FROM audit_trail WHERE activity LIKE '%backed up the database%' LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                    if ($result) {
                                        if (mysqli_num_rows($result) > 0) {
                                    ?>
                                            <?php
                                            foreach ($result as $data) {
                                            ?>
                                                <tr>
                                                    <td><?php echo date("F d, Y  |  g:i A", strtotime($data['datetime'])) ?></td>
                                                    <td><?php echo $data['fullname'] . " " . $data['activity'] ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>

                                        <?php
                                        } else {
                                        ?>
                                            <td colspan="2">
                                                <?php
                                                include('../../includes/no-data.php');
                                                ?>
                                            </td>
                                    <?php
                                        }
                                    }
                                    mysqli_close($conn);
                                    ?>
                                </tbody>
                            </table>
                            <?php include('../../includes/pagination.php') ?>
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

</html>