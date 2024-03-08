<?php

session_start();
include('../../connection.php');
include('../../includes/admin-auth.php');
$module = 'account_users';
$campus = $_SESSION['campus'];
$user = $_SESSION['userid'];

// get the total nr of rows.
$records = $conn->query("SELECT * FROM account WHERE campus = '$campus' AND accountid !='$user' ORDER BY accountid");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php') 
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>User Accounts</title>
    <?php include('../../includes/header.php');?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">USER ACCOUNTS</span>
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
                
            <div class="schedule-button">
                    <button type="button" class="btn btn-primary btn-lg" onclick="window.open('reports/reports_accounts.php');">Export to PDF</button>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-3">
                                                <input type="text" name="account" value="<?= isset($_GET['account']) == true ? $_GET['account'] : '' ?>" class="form-control" placeholder="Search user account">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <select name="status" class="form-select">
                                                <option value="">Select Status</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT * FROM user_status ORDER BY status";
                                                if($result = mysqli_query($conn, $sql))
                                                {   while($row = mysqli_fetch_array($result) )
                                                    {   $admin = $row["status"];?>
                                                <option value="<?php echo $row["status"];?> <?= isset($_GET['']) == true ? ($_GET[''] == $row["status"] ? 'selected' : '') : '' ?>"><?php echo $row["status"];?></option><?php }}?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <select name="usertype" class="form-select">
                                                <option value="">Select Usertype</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT usertype FROM account ORDER BY usertype";
                                                if($result = mysqli_query($conn, $sql))
                                                {   while($row = mysqli_fetch_array($result) )
                                                    {   $admin = $row["usertype"];?>
                                                <option value="<?php echo $row["usertype"];?> <?= isset($_GET['']) == true ? ($_GET[''] == $row["usertype"] ? 'selected' : '') : '' ?>"><?php echo $row["usertype"];?></option><?php }}?>
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="account_users" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <?php
                                if (isset($_GET['account']) && $_GET['account'] != '') {
                                    $account = strtoupper($_GET['account']);
                                    $count = 1;
                                    $sql = "SELECT * FROM account WHERE CONCAT(firstname, ' ', middlename, ' ' , lastname) LIKE '%$account%' OR CONCAT(firstname, ' ' , lastname) LIKE '%$account%' OR accountid LIKE '%$account%' WHERE campus = '$campus' AND accountid !='$user' ORDER BY accountid LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } elseif (isset($_GET['status']) && $_GET['status'] != '' || isset($_GET['usertype']) && $_GET['usertype'] != '' ) {
                                    //$campus = $_GET['campus'];
                                    $status = $_GET['status'];
                                    $usertype = $_GET['usertype'];
                                    
                                    if($status == "")
                                    {
                                        $stat = "";
                                    }
                                    elseif ($status != "" AND $usertype == "")
                                    {
                                        $stat = " AND status = '$status'";
                                    }
                                    elseif ($status != "" AND $usertype != "")
                                    {
                                        $stat = " AND status = '$status'";
                                    }

                                    if ($usertype == "")
                                    {
                                        $utype = "";
                                    }
                                    elseif ($stat != "" AND $usertype != "")
                                    {
                                        $utype = " AND usertype = '$usertype'";
                                    }
                                    elseif ($stat == "" AND $usertype != "")
                                    {
                                        $utype = " AND usertype = '$usertype'";
                                    }
                                    

                                    $count = 1;
                                    $sql = "SELECT * FROM account WHERE campus = '$campus' $stat $utype AND accountid !='$user' ORDER BY accountid LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                } else {
                                    $count = 1;
                                    $sql = "SELECT * FROM account WHERE campus = '$campus' AND accountid !='$user' ORDER BY accountid LIMIT $start, $rows_per_page";
                                    $result = mysqli_query($conn, $sql);
                                }
                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                ?>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Account ID</th>
                                                    <th>Full Name</th>
                                                    <th>Usertype</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                            </thead>
                                            <tbody>

                                                <?php
                                                foreach($result as $data){
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
                                                    }?>
                                                    <tr>
                                                        <td><?php echo $data['accountid'] ?></td>
                                                        <td><?php echo ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " .ucwords(strtolower($data['lastname']));?></td>
                                                        <td><?php echo $data['usertype'] ?></td>
                                                        <td><?php echo $data['status'] ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateacc<?php echo $data['accountid']; ?>">Expand</button>
                                                        <?php $count++; ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    include('modals/update_account_modal.php');
                                                    }}?>
                                            </tbody>
                                        </table>
                                        <?php include('../../includes/pagination.php') ?>
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