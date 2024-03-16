<?php

session_start();
include('../../../connection.php');
include('../../../includes/student-auth.php');

$userid = $_SESSION['userid'];
$usertype = $_SESSION['usertype'];
$name = $_SESSION['username'];
$campus = $_SESSION['campus'];

// get the total nr of rows.
$records = $conn->query("select * from appointment WHERE status='Pending'");
$nr_of_rows = $records->num_rows;

include('../../../includes/pagination-limit.php');

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Appointment</title>
    <?php include('../../../includes/header.php') ?>
    <link rel="stylesheet" href="../../css/bootstrap-datepicker3.min.css" />
</head>

<body id="<?php echo $id ?>">
    <?php include('../../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">APPOINTMENT</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <button type="button" class="btn btn-sm position-relative">
                        <i class='bx bx-bell'></i>
                        <?php
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.lastname, ac.campus 
                        FROM audit_trail au INNER JOIN account ac ON ac.accountid=au.user WHERE 
                        ((au.activity LIKE 'approved a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'disapproved a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'cancelled a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'approved a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'completed a request for%' AND au.activity LIKE '%$userid') 
                        OR (au.activity LIKE 'dismissed a request for%' AND au.activity LIKE '%$userid') 
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
            <div class="overview-boxes">
                <div class="content">
                    <div class="row">
                        <div class="container-notification">
                            <header>
                                <div class="notif_box">
                                    <h3 class="title">Notifications</h3>
                                    <span id="notifes1"></span>
                                </div>
                                <p id="mark_all">Mark all as read</p>
                            </header>
                            <main>
                                <?php

                                $query = mysqli_query($conn, "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.lastname, ac.campus 
                                FROM audit_trail au INNER JOIN account ac ON ac.accountid=au.user WHERE 
                                ((au.activity LIKE 'approved a request for%' AND au.activity LIKE '%$userid') 
                                OR (au.activity LIKE 'disapproved a request for%' AND au.activity LIKE '%$userid') 
                                OR (au.activity LIKE 'cancelled a request for%' AND au.activity LIKE '%$userid') 
                                OR (au.activity LIKE 'approved a request for%' AND au.activity LIKE '%$userid') 
                                OR (au.activity LIKE 'completed a request for%' AND au.activity LIKE '%$userid') 
                                OR (au.activity LIKE 'dismissed a request for%' AND au.activity LIKE '%$userid') 
                                OR (au.activity LIKE 'added%' AND au.activity LIKE '%$userid') 
                                OR (au.activity LIKE 'added a walk-in schedule%' AND au.activity LIKE '%$campus') 
                                OR (au.activity LIKE 'cancelled a walk-in schedule%' AND au.activity LIKE '%$campus')) 
                                AND au.status = 'unread' AND au.user != '$userid' ORDER BY au.datetime DESC");
                                if ($query) {
                                    if (mysqli_num_rows($query) > 0) {
                                        foreach ($query as $data) {
                                            if (count(explode(" ", $data['middlename'])) > 1) {
                                                $middle = explode(" ", $data['middlename']);
                                                $letter = $middle[0][0] . $middle[1][0];
                                                $middleinitial = $letter . ".";
                                            } else {
                                                $middle = $data['middlename'];
                                                if ($middle == "" or $middle == " ") {
                                                    $middleinitial = "";
                                                } else {
                                                    $middleinitial = substr($middle, 0, 1) . ".";
                                                }
                                            }

                                            if ($data['datetime'] < date("Y-m-d")) {
                                                $dt = date("F d, Y", strtotime($data['datetime'])) . " | " . date("g:i A", strtotime($data['datetime']));
                                            } else {
                                                $dt = date("g:i A", strtotime($data['datetime']));
                                            }

                                            /*if($data['activity'] = "added a dental health record for $userid")
                                            {
                                                $activity = "added a new Dental Health Record in your Medical History";
                                            }*/


                                            $fullname = ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname']));

                                ?>
                                            <div class="notif_card <?= $data['status'] ?>">
                                                <img src="../../../images/noprofile.png" alt="avatar" />
                                                <div class="description" data-id="<?php echo $data['id']; ?>">
                                                    <p class="user_activity">
                                                        <strong><?= $fullname ?></strong> <?= $data['activity'] ?>
                                                    </p>
                                                    <p class="time"><?= $dt ?></p>
                                                </div>
                                            </div>
                                            <hr>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </main>
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

    const unreadMessages = document.querySelectorAll(".unread");
    const unread = document.getElementById("notifes");
    const unread1 = document.getElementById("notifes1");
    const markAll = document.getElementById("mark_all");


    // Function to update status to 'read'
    function updateStatus(id) {
        // Make an AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log(xhr.responseText); // Log response for debugging
                } else {
                    console.error("Error:", xhr.status); // Log error for debugging
                }
            }
        };
        xhr.send(`id=${id}`);
    }

    unread.innerText = unreadMessages.length;
    unread1.innerText = unreadMessages.length;

    unreadMessages.forEach((message) => {
        message.addEventListener("click", () => {
            message.classList.remove("unread");
            const newUnreadMessages = document.querySelectorAll(".unread");
            unread.innerText = newUnreadMessages.length;
            unread1.innerText = newUnreadMessages.length;

            // Get the id from the notification card's description element
            const id = message.querySelector('.description').getAttribute('data-id');
            // Update status to 'read'
            updateStatus(id);
        });
    });

    markAll.addEventListener("click", () => {
        unreadMessages.forEach((message) => {
            message.classList.remove("unread");
            const newUnreadMessages = document.querySelectorAll(".unread");
            unread.innerText = newUnreadMessages.length;
            unread1.innerText = newUnreadMessages.length;

            // Get the id from each notification card's description element
            const id = message.querySelector('.description').getAttribute('data-id');
            // Update status to 'read'
            updateStatus(id);
        });
    });
</script>

</html>