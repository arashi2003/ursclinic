<?php

session_start();
include('../../connection.php');
include('../../includes/doctor-auth.php');

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
                <div class="notification-button">
                    <i class='bx bx-bell'></i>
                </div>
                <div class="profile-details">
                    <i class='bx bx-user-circle'></i>
                    <span class="admin_name">DOCTOR
                        <?php
                        echo $_SESSION['username'] ?>
                    </span>
                </div>
        </nav>
        <div class="home-content">
            <div class="overview-boxes">
                <div class="schedule-button">
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addtransaction_set">Add Entry</button>
                    <?php include('modals/addtransaction_set_modal.php'); ?>
                </div>
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
                                <table>
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Transaction</th>
                                            <th>Service</th>
                                            <th>Action</th>
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
                                                while ($data = mysqli_fetch_array($result)) {
                                                    if ($data['service'] == NULL) {
                                                        $service = $data['transaction_type'];
                                                    } else {
                                                        $service =  $data['service'];
                                                    }
                                        ?>
                                                    <tr>
                                                        <td><?php $id = $count;
                                                            echo $id; ?></td>
                                                        <td><?php echo $data['transaction_type']; ?></td>
                                                        <td><?php echo $service; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatetransaction_set<?php echo $data['id']; ?>">Update</button>
                                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removetransaction_set<?php echo $data['id']; ?>">Remove</button>
                                                            <?php $count++;
                                                            ?>
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
                                <td colspan="4">
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