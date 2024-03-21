<?php

session_start();
include('../../connection.php');
include('../../includes/admin-auth.php');
$module = 'account_users';
//$campus = $_SESSION['campus'];
$user = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// get the total nr of rows.
$records = $conn->query("SELECT * FROM account ORDER BY accountid");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php')
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>User Accounts</title>
    <?php include('../../includes/header.php'); ?>

    <script>
        function exportToPDF() {
            let url = 'reports/reports_accounts';

            // Construct URL parameters using PHP
            <?php
            $parameters = array();
            if (isset($_GET['campus']) && $_GET['campus'] !== '') {
                $parameters[] = 'campus=' . urlencode($_GET['campus']);
            }
            if (isset($_GET['status']) && $_GET['status'] !== '') {
                $parameters[] = 'status=' . urlencode($_GET['status']);
            }
            if (isset($_GET['usertype']) && $_GET['usertype'] !== '') {
                $parameters[] = 'usertype=' . urlencode($_GET['usertype']);
            }
            if (!empty($parameters)) {
                $url .= '?' . implode('&', $parameters);
            }

            /*
            // ito naman code na nagana pag may filter na napili:
            //<button type="button" class="btn btn-primary btn-lg" onclick="window.open('reports/reports_accounts?campus=<?=$_GET['campus']?>&status=<?=$_GET['status']?>&usertype=<?=$_GET['usertype']?>')" target="_blank">Export to PDF</button>
            */

            ?>

            // Open the PDF in a new tab
            window.open(url, '_blank');
        }
    </script>
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
                <div class="schedule-button">
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addaccount">Add Account</button>
                    <?php include('modals/addaccount_modal.php'); ?>
                    &ThickSpace;
                    <button type="button" class="btn btn-primary btn-lg" onclick="exportToPDF()">Export to PDF</button>
                </div>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <form action="" method="get">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <div class="input-group mb-2">
                                                <input type="text" name="account" value="<?= isset($_GET['account']) == true ? $_GET['account'] : '' ?>" class="form-control" placeholder="Search user account">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="campus" class="form-select">
                                                <option value="">Select Campus</option>
                                                <option value="<?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>">NONE</option>
                                                <?php
                                                $sql = "SELECT * FROM campus ORDER BY campus";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $campus = $row["campus"]; ?>
                                                        <option value="<?php echo $row["campus"]; ?> <?= isset($_GET['']) == true ? ($_GET[''] == $row["campus"] ? 'selected' : '') : '' ?>"><?php echo $row["campus"]; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="status" class="form-select">
                                                <option value="">Select Status</option>
                                                <option value="<?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>">NONE</option>
                                                <?php
                                                $sql = "SELECT * FROM user_status ORDER BY status";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $status = $row["status"]; ?>
                                                        <option value="<?php echo $row["status"]; ?> <?= isset($_GET['']) == true ? ($_GET[''] == $row["status"] ? 'selected' : '') : '' ?>"><?php echo $row["status"]; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="usertype" class="form-select">
                                                <option value="">Select Usertype</option>
                                                <option value="<?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>">NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT usertype FROM account ORDER BY usertype";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $usertype = $row["usertype"]; ?>
                                                        <option value="<?php echo $row["usertype"]; ?> <?= isset($_GET['']) == true ? ($_GET[''] == $row["usertype"] ? 'selected' : '') : '' ?>"><?php echo $row["usertype"]; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col mb-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="account_users" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>

                                </div>
                        </div>
                        </form>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Campus</th>
                                            <th>Account ID</th>
                                            <th>Full Name</th>
                                            <th>Usertype</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody><?php
                                            if (isset($_GET['account']) && $_GET['account'] != '') {
                                                $account = strtoupper($_GET['account']);
                                                $sql = "SELECT * FROM account WHERE (CONCAT(firstname, ' ', middlename, ' ' , lastname) LIKE '%$account%' OR CONCAT(firstname, ' ' , lastname) LIKE '%$account%' OR accountid LIKE '%$account%') ORDER BY accountid LIMIT $start, $rows_per_page";
                                                $result = mysqli_query($conn, $sql);
                                            } elseif (isset($_GET['campus']) && $_GET['campus'] != '' || isset($_GET['status']) && $_GET['status'] != '' || isset($_GET['usertype']) && $_GET['usertype'] != '') {
                                                $campus = $_GET['campus'];
                                                $status = $_GET['status'];
                                                $usertype = $_GET['usertype'];

                                                //campus filter
                                                if ($campus == "") {
                                                    $ca = "";
                                                } else {
                                                    $ca = " WHERE campus = '$campus'";
                                                }

                                                //status filter
                                                if ($status == "") {
                                                    $stat = "";
                                                } elseif ($ca == "" and $status != "") {
                                                    $stat = " WHERE status = '$status'";
                                                } elseif ($ca != "" and $status != "") {
                                                    $stat = " AND status = '$status'";
                                                }

                                                //status filter
                                                if ($usertype == "") {
                                                    $utype = "";
                                                } elseif ($ca == "" and $stat == "" and $usertype != "") {
                                                    $utype = " WHERE usertype = '$usertype'";
                                                } elseif ($ca != "" or $stat != "" and $statususertype != "") {
                                                    $utype = " AND usertype = '$usertype'";
                                                }
                                                $sql = "SELECT * FROM account $ca $stat $utype ORDER BY accountid LIMIT $start, $rows_per_page";
                                                $result = mysqli_query($conn, $sql);
                                            } else {
                                                $sql = "SELECT * FROM account ORDER BY accountid LIMIT $start, $rows_per_page";
                                                $result = mysqli_query($conn, $sql);
                                            }
                                            if ($result) {
                                                if (mysqli_num_rows($result) > 0) {
                                                    foreach ($result as $data) {
                                                        if (count(explode(" ", $data['middlename'])) > 1) {
                                                            $middle = explode(" ", $data['middlename']);
                                                            $letter = !empty($middle[0][0]) . !empty($middle[1][0]);
                                                            $middleinitial = $letter . ".";
                                                        } else {
                                                            $middle = $data['middlename'];
                                                            if ($middle == "" or $middle == " ") {
                                                                $middleinitial = "";
                                                            } else {
                                                                $middleinitial = substr($middle, 0, 1) . ".";
                                                            }
                                                        } ?>
                                                    <tr>
                                                        <td><?php echo $data['campus'] ?></td>
                                                        <td><?php echo $data['accountid'] ?></td>
                                                        <td><?php echo ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname'])); ?></td>
                                                        <td><?php echo $data['usertype'] ?></td>
                                                        <td><?php echo $data['status'] ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateacc<?php echo $data['accountid']; ?>">Expand</button>
                                                        </td>
                                                    </tr>
                                                <?php
                                                        include('modals/update_account_modal.php');
                                                    }
                                                } else { ?>
                                                <td colspan="6">
                                                    <?php
                                                    include('../../includes/no-data.php');
                                                    ?>
                                                </td>
                                            <?php } ?>
                                    </tbody>
                                </table>
                                <?php include('../../includes/pagination.php') ?>
                            <?php
                                            } else {
                            ?>
                                <td colspan="6">
                                    <?php
                                                include('../../includes/no-data.php');
                                    ?>
                                </td>
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