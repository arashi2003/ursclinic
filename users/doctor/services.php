<?php

session_start();
include('../../connection.php');
include('../../includes/doctor-auth.php');

$module = 'services';
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];
$campus = $_SESSION['campus'];

// get the total nr of rows.
$records = $conn->query("SELECT * FROM transaction");
$nr_of_rows = $records->num_rows;

include('../../includes/pagination-limit.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Available Services</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">AVAILABLE SERVICES</span>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addtransaction_set">Add Entry</button>
                    <?php include('modals/addtransaction_set_modal.php'); ?>
                </div>
                <?php include('../../includes/alert.php'); ?>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-3">
                                                <input type="text" name="transaction" value="<?= isset($_GET['transaction']) == true ? $_GET['transaction'] : '' ?>" class="form-control" placeholder="Search service">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <select name="ttype" class="form-select">
                                                <option value="Select Transaction">Select Transaction</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT transaction_type FROM transaction ORDER BY transaction_type";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $ttype = $row["transaction_type"]; ?>
                                                        <option value="<?php echo $ttype; ?> <?= isset($_GET['']) == true ? ($_GET[''] == $ttype ? 'selected' : '') : '' ?>"><?php echo $ttype; ?></option><?php }
                                                                                                                                                                                                    } ?>
                                            </select>
                                        </div>
                                        <div class="col mb-3">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="services.php" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="head">
                                        <tr>
                                            <th>ID</th>
                                            <th>Transaction</th>
                                            <th>Service</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['transaction']) && $_GET['transaction'] != '') {
                                            $transaction = $_GET['transaction'];
                                            $count = 1;
                                            $sql = "SELECT * FROM transaction WHERE CONCAT(transaction_type, ' - ', service) LIKE '%$transaction%' ORDER BY transaction_type, service LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['ttype']) && $_GET['ttype'] != '') {
                                            $ttype = $_GET['ttype'];
                                            $count = 1;
                                            $sql = "SELECT * FROM transaction WHERE transaction_type = '$ttype' ORDER BY transaction_type, service LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT * FROM transaction ORDER BY transaction_type, service LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                foreach ($result as $data) {
                                                    if ($data['service'] == NULL) {
                                                        $service = $data['transaction_type'];
                                                    } else {
                                                        $service =  $data['service'];
                                                    }
                                        ?>
                                                    <tr>
                                                        <td><?php echo $data['id']; ?></td>
                                                        <td><?php echo $data['transaction_type']; ?></td>
                                                        <td><?php echo $service; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updatetransaction_set<?php echo $data['id']; ?>">Update</button>
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#removetransaction_set<?php echo $data['id']; ?>">Remove</button>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    include('modals/update_transaction_set_modal.php');
                                                    include('modals/rem_transaction_set_modal.php');
                                                }
                                            } ?>
                                    </tbody>
                                </table>
                                <?php include('../../includes/pagination.php'); ?>
                            <?php
                                        } else {
                            ?>
                                <td colspan="7">
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