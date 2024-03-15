<?php

session_start();
include('../../connection.php');
include('../../includes/nurse-auth.php');
$module = 'transaction_add';
$campus = $_SESSION['campus'];
$userid=$_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Transaction</title>
    <?php include('../../includes/header.php');?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">ADD TRANSACTION</span>
            </div>
            <div class="right-nav">
                <div class="notification-button">
                    <button type="button" class="btn btn-sm position-relative" onclick="window.location.href = 'notification'">
                        <i class='bx bx-bell'></i>
                        <?php
                        $sql = "SELECT au.id, au.user, au.campus, au.activity, au.datetime, au.status, ac.firstname, ac.middlename, ac.lastname, ac.campus, i.image 
                        FROM audit_trail au INNER JOIN account ac ON ac.accountid=au.user INNER JOIN patient_image i ON i.patient_id=au.user WHERE (au.activity LIKE '%added a walk-in schedule%' OR au.activity 
                        LIKE 'sent a request for%' OR au.activity LIKE 'uploaded medical document%' OR au.activity LIKE '%already expired') AND au.status='unread' AND au.user != '$userid'";
                        $result = mysqli_query($conn, $sql);
                        if ($row = mysqli_num_rows($result)) {
                        ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $row ?>
                        </span>
                        <?php
                        }
                        ?>
                    </button>
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
                    <form method="POST" action="add/yawa.php" id="form">
                        
                    <div class="row duplicate_med">
                        <div class="col-md-9 mb-2">
                            <div class="input-group input-group-md mb-2" id="medicine">
                                <span class="input-group-text" id="inputGroup-sizing-md">Medicine:</span>
                                <select class="form-select" aria-label=".form-select-md example" name="medicine[]" id="medicine">
                                    <option value=""  selected></option>
                                    <?php
                                    $sql = "SELECT * FROM inv_total WHERE type = 'medicine' AND qty >= 0 AND campus='$campus'";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?= $row['stockid']; ?>"><?= $row['stock_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2" id="quantity_med">
                                <span class="input-group-text" id="inputGroup-sizing-md">Quantity:</span>
                                <input type="number" class="form-control" name="quantity_med[]">
                                &ThickSpace;
                                <button type="button" class="btn btn-primary" onclick="duplicate_med()">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="row duplicate_sup">
                        <div class="col-md-9 mb-2">
                            <div class="input-group input-group-md mb-2" id="supply">
                                <span class="input-group-text" id="inputGroup-sizing-md">Medical Supply:</span>
                                <select class="form-select" aria-label=".form-select-md example" name="supply[]" id="supply">
                                    <option value=""  selected></option>
                                    <?php
                                    $sql = "SELECT * FROM inv_total WHERE type = 'supply' AND qty >= 0 AND campus='$campus'";
                                    $result = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <option value="<?= $row['stockid']; ?>"><?= $row['stock_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="input-group input-group-md mb-2" id="quantity_sup">
                                <span class="input-group-text" id="inputGroup-sizing-md">Quantity:</span>
                                <input type="number" class="form-control" name="quantity_sup[]">
                                &ThickSpace;
                                <button type="button" class="btn btn-primary" onclick="duplicate_sup()">+</button>
                            </div>
                        </div>
                    </div>
                        <input type="submit" value="Submit">
                    </form>
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
<script>
    function duplicate_med() {
        var row = $('.duplicate_med').first().clone();
        row.find('button').removeClass('btn-primary').addClass('btn-danger').text('-').attr('onclick', 'remove_med(this)');
        $('.duplicate_med').last().after(row);
    }

    function remove_med(btn) {
        $(btn).closest('.duplicate_med').remove();
    }

    $('select[name="request"]').change(function() {
        $('.duplicate:not(:first)').remove();
    });

    $(document).ready(function() {
        $('#add-request').submit(function(e) {
            e.preventDefault();
            $('#addbtn').val('Requesting...');
            $.ajax({
                url: 'action-add-request.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    window.location.href = "request";
                }
            });
        });
    });
</script>
<script>
    function duplicate_sup() {
        var row = $('.duplicate_sup').first().clone();
        row.find('button').removeClass('btn-primary').addClass('btn-danger').text('-').attr('onclick', 'remove_sup(this)');
        $('.duplicate_sup').last().after(row);
    }

    function remove_sup(btn) {
        $(btn).closest('.duplicate_sup').remove();
    }

    $('select[name="request"]').change(function() {
        $('.duplicate:not(:first)').remove();
    });

    $(document).ready(function() {
        $('#add-request').submit(function(e) {
            e.preventDefault();
            $('#addbtn').val('Requesting...');
            $.ajax({
                url: 'action-add-request.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    window.location.href = "request";
                }
            });
        });
    });
</script>

<script>
    function duplicate() {
        var row = $('.duplicate').first().clone();
        row.find('button').removeClass('btn-primary').addClass('btn-danger').text('-').attr('onclick', 'remove(this)');
        $('.duplicate').last().after(row);
    }

    function remove(btn) {
        $(btn).closest('.duplicate').remove();
    }

    $('select[name="request"]').change(function() {
        $('.duplicate:not(:first)').remove();
    });

    $(document).ready(function() {
        $('#add-request').submit(function(e) {
            e.preventDefault();
            $('#addbtn').val('Requesting...');
            $.ajax({
                url: 'action-add-request.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    window.location.href = "request";
                }
            });
        });
    });
</script>
</html>