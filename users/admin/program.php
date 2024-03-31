<?php

session_start();
include('../../connection.php');
include('../../includes/admin-auth.php');
$module = 'program';
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// Check if the program, department, or college filter is set
if (isset($_GET['program']) || isset($_GET['department']) || isset($_GET['college'])) {
    // Validate and sanitize input
    $program = isset($_GET['program']) ? $_GET['program'] : '';
    $department = isset($_GET['department']) ? $_GET['department'] : '';
    $college = isset($_GET['college']) ? $_GET['college'] : '';

    // Initialize the WHERE clause
    $whereClause = " WHERE 1"; // Start with a default condition that is always true

    // Add conditions based on filters
    if ($program !== '') {
        $whereClause .= " AND program LIKE '%$program%'";
    }
    if ($department !== '') {
        $whereClause .= " AND department = '$department'";
    }
    if ($college !== '') {
        $whereClause .= " AND college = '$college'";
    }

    // Construct and execute SQL query for counting total rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM program $whereClause ORDER BY department, college, program";
} else {
    // If filters are not set, count all rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM program ORDER BY department, college, program";
}

// Execute the count query
$count_result = $conn->query($sql_count);

// Check if count query was successful
if ($count_result) {
    // Fetch the total number of rows
    $count_row = $count_result->fetch_assoc();
    $nr_of_rows = $count_row['total_rows'];
} else {
    // Handle count query error
    echo "Error: " . $conn->error;
}

// Setting the number of rows to display in a page.
$rows_per_page = 10;

// determine the page
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Setting the start from, value.
$start = ($page - 1) * $rows_per_page;

// calculating the nr of pages.
$pages = ceil($nr_of_rows / $rows_per_page);

// calculate the range of page numbers to be displayed
$start_loop = max(1, $page - 2);
$end_loop = min($pages, $page + 2);

// adjust the range if the current page is near the beginning or end
if ($start_loop > 1) {
    $start_loop--;
    $end_loop++;
}

// ensure that the range is never smaller than 4
if ($end_loop - $start_loop < 4) {
    $start_loop = max(1, $end_loop - 4);
}

$previous = $page - 1;
$next = $page + 1;

// calculate the start and end loop variables
$start_loop = $page > 2 ? $page - 2 : 1;
$end_loop = $page < $pages - 2 ? $page + 2 : $pages;

// limit the number of pages displayed to a maximum of 4
if ($pages > 4) {
    if ($page > 2 && $page < $pages - 1) {
        $end_loop = $page + 1;
    } elseif ($page == 1) {
        $start_loop = 1;
        $end_loop = 4;
    } elseif ($page == $pages) {
        $start_loop = $pages - 3;
        $end_loop = $pages;
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Settings</title>
    <?php include('../../includes/header.php'); ?>
</head>

<body id="<?php echo $id ?>">
    <?php include('../../includes/sidebar.php') ?>
    <section class="home-section">
        <nav>
            <div class="sidebar-button">
                <i class='bx bx-menu sidebarBtn'></i>
                <span class="dashboard">PROGRAM</span>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addprogram">Add Entry</button>
                    <?php include('modals/addprogram_modal.php'); ?>
                </div>
                <?php
                include('../../includes/alert.php')
                ?>
                <div class="content">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="get">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group mb-2">
                                                <input type="text" name="program" value="<?= isset($_GET['program']) == true ? $_GET['program'] : '' ?>" class="form-control" placeholder="Search program">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="department" class="form-select">
                                                <option value="" disabled selected>-Select Department-</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT DISTINCT department FROM program ORDER BY department";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) { ?>
                                                        <option value="<?php echo $row["department"]; ?>" <?= isset($_GET['department']) == true ? ($_GET['department'] == $row["department"] ? 'selected' : '') : '' ?>><?php echo $row["department"]; ?></option><?php }
                                                                                                                                                                                                                                        } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="college" class="form-select">
                                                <option value="" disabled selected>-Select College-</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT * FROM college ORDER BY college";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) { ?>
                                                        <option value="<?php echo $row["college"]; ?>" <?= isset($_GET['college']) == true ? ($_GET['college'] == $row["college"] ? 'selected' : '') : '' ?>><?php echo $row["college"]; ?></option><?php }
                                                                                                                                                                                                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col mb-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="program" class="btn btn-danger">Reset</a>
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
                                            <th>Department</th>
                                            <th>College</th>
                                            <th>Program</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['program']) && $_GET['program'] != '') {
                                            $program = $_GET['program'];
                                            $count = 1;
                                            $sql = "SELECT * FROM program WHERE program LIKE '%$program%' ORDER BY department, college, program LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['department']) && $_GET['department'] != '' || isset($_GET['college']) && $_GET['college'] != '') {
                                            $department = isset($_GET['department']) ? $_GET['department'] : '';
                                            $college = isset($_GET['college']) ? $_GET['college'] : '';
                                            $count = 1;
                                            if ($department == "") {
                                                $dep = "";
                                            } else {
                                                $dep = " WHERE department = '$department'";
                                            }

                                            if ($college == "") {
                                                $col = "";
                                            } elseif ($dep == "" and $college != "") {
                                                $col = " WHERE college = '$college'";
                                            } elseif ($dep != "" and $college != "") {
                                                $col = " AND college = '$college'";
                                            }
                                            $sql = "SELECT * FROM program $dep $col ORDER BY department, college, program LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT * FROM program ORDER BY department, college, program LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                foreach ($result as $data) {

                                        ?>
                                                    <tr>
                                                        <td><?php echo $data['department']; ?></td>
                                                        <td><?php echo $data['college']; ?></td>
                                                        <td><?php echo $data['program']; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateprogram<?php echo $data['id']; ?>">Update</button>
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#removeprogram<?php echo $data['id']; ?>">Remove</button>
                                                            <?php $count++; ?>
                                                        </td>

                                                    </tr>
                                                <?php
                                                    include('modals/update_program_modal.php');
                                                    include('modals/rem_program_modal.php');
                                                } ?>

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
                                        }
                                        mysqli_close($conn);
                                        ?>
                                    </tbody>
                                </table>
                                <ul class="pagination justify-content-end">
                                    <?php
                                    if (mysqli_num_rows($result) > 0) : ?>
                                        <li class="page-item <?= $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['program']) ? 'program=' . $_GET['program'] . '&' : '', isset($_GET['department']) ? 'department=' . $_GET['department'] . '&' : '', isset($_GET['college']) ? 'college=' . $_GET['college'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['program']) ? 'program=' . $_GET['program'] . '&' : '', isset($_GET['department']) ? 'department=' . $_GET['department'] . '&' : '', isset($_GET['college']) ? 'college=' . $_GET['college'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?= isset($_GET['program']) ? 'program=' . $_GET['program'] . '&' : '', isset($_GET['department']) ? 'department=' . $_GET['department'] . '&' : '', isset($_GET['college']) ? 'college=' . $_GET['college'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['program']) ? 'program=' . $_GET['program'] . '&' : '', isset($_GET['department']) ? 'department=' . $_GET['department'] . '&' : '', isset($_GET['college']) ? 'college=' . $_GET['college'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['program']) ? 'program=' . $_GET['program'] . '&' : '', isset($_GET['department']) ? 'department=' . $_GET['department'] . '&' : '', isset($_GET['college']) ? 'college=' . $_GET['college'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
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