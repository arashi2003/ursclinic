<?php

session_start();
$campus = $_SESSION['campus'];
include('../../connection.php');
include('../../includes/dentist-auth.php');

// get the total nr of rows.
$records = $conn->query("SELECT * FROM schedule");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Doctor's Visit</title>
    <?php include('../../includes/header.php');?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">DOCTOR'S VISIT</span>
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
                            <li><a class="dropdown-item" href="../../logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="home-content">
            <div class="overview-boxes">
                <div class="content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                    $count = 1;
                                    $date = date("Y-m-d");
                                    $sql = "SELECT s.id, s.date, s.time_from, s.time_to, s.physician, s.campus, a.firstname, a.middlename, a.lastname FROM schedule s INNER JOIN account a on a.accountid=s.physician WHERE s.campus = '$campus' AND date >= '$date' ORDER BY date, time_from LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Physician</th>
                                            </thead>
                                            <tbody>

                                                <?php
                                                while($data = mysqli_fetch_array($result)){
                                                    if (count(explode(" ", $data['middlename'])) > 1)
                                                    {
                                                        $middle = explode(" ", $data['middlename']);
                                                        $letter = $middle[0][0].$middle[1][0];
                                                        $middleinitial = $letter . ".";
                                                    }
                                                    else
                                                    {
                                                        $middle = $data['middlename'];
                                                        if ($middle == "" OR $middle == " ")
                                                        {
                                                            $middleinitial = "";
                                                        }
                                                        else
                                                        {
                                                            $middleinitial = substr($middle, 0, 1) . ".";
                                                        }    
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td><?php $id = $count;
                                                            $date = date("F d, Y", strtotime($data['date']));
                                                            $time = date("g:i A", strtotime($data['time_from'])) . " - " . date("g:i A", strtotime($data['time_to']));
                                                            $physician = $data['firstname'] . " " . $middleinitial . " " . $data['lastname'];
                                                            echo $id; ?></td>
                                                        <td><?php echo $date ?></td>
                                                        <td><?php echo $time ?></td>
                                                        <td><?php echo $physician;
                                                        $count++; }?></td>
                                                    </tr>
                                                    <?php
                                                    }?>
                                            </tbody>
                                        </table>
                                        <?php include('../../includes/pagination.php');?>
                                    <?php
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="7">No record Found</td>
                                        </tr>
                                <?php
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
</html>