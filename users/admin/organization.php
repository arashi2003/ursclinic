<?php

session_start();
include('../../connection.php');
include('../../includes/admin-auth.php');
$module = 'organization';
$userid = $_SESSION['userid'];
$name = $_SESSION['username'];
$usertype = $_SESSION['usertype'];

// Check if the organization, campus, or title filter is set
if (isset($_GET['organization']) || isset($_GET['campus']) || isset($_GET['title'])) {
    // Validate and sanitize input
    $organization = isset($_GET['organization']) ? $_GET['organization'] : '';
    $campus = isset($_GET['campus']) ? $_GET['campus'] : '';
    $title = isset($_GET['title']) ? $_GET['title'] : '';

    // Initialize the WHERE clause
    $whereClause = " WHERE 1"; // Start with a default condition that is always true

    // Add conditions based on filters
    if ($organization !== '') {
        $whereClause .= " AND (CONCAT(firstname, ' ' , middlename, ' ', lastname) LIKE '%$organization%' OR CONCAT(firstname, ' ', lastname) LIKE '%$organization%')";
    }
    if ($campus !== '') {
        $whereClause .= " AND campus = '$campus'";
    }
    if ($title !== '') {
        $whereClause .= " AND title = '$title'";
    }

    // Construct and execute SQL query for counting total rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM organization $whereClause ORDER BY campus, title";
} else {
    // If filters are not set, count all rows
    $sql_count = "SELECT COUNT(*) AS total_rows FROM organization ORDER BY campus, title";
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
                <span class="dashboard">ORGANIZATION</span>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addorganization">Add Entry</button>
                    <?php include('modals/addorganization_modal.php'); ?>
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
                                                <input type="text" name="organization" value="<?= isset($_GET['organization']) == true ? $_GET['organization'] : '' ?>" class="form-control" placeholder="Search organization">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="campus" class="form-select">
                                                <option value="" disabled selected>-Select Campus-</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <?php
                                                $sql = "SELECT * FROM campus ORDER BY campus";
                                                if ($result = mysqli_query($conn, $sql)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        if ($row["campus"] == "ALL") {
                                                            $campus = "UNIVERSITY";
                                                        } else {
                                                            $campus = $row["campus"];
                                                        }
                                                ?>
                                                        <option value="<?php echo $campus; ?>" <?= isset($_GET['campus']) == true ? ($_GET['campus'] == $row["campus"] ? 'selected' : '') : '' ?>><?php echo $campus; ?></option><?php }
                                                                                                                                                                                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <select name="title" class="form-select">
                                                <option value="" disabled selected>-Select Position-</option>
                                                <option value="" <?= isset($_GET['']) == true ? ($_GET[''] == 'NONE' ? 'selected' : '') : '' ?>>NONE</option>
                                                <option value="Head, Health Services Unit" <?= isset($_GET['title']) == true ? ($_GET['title'] == 'Head, Health Services unit' ? 'selected' : '') : '' ?>>Head, Health Services Unit</option>
                                                <option value="Campus Director" <?= isset($_GET['title']) == true ? ($_GET['title'] == 'Campus Director' ? 'selected' : '') : '' ?>>Campus Director</option>
                                                <option value="Campus Nurse" <?= isset($_GET['title']) == true ? ($_GET['title'] == 'Campus Nurse' ? 'selected' : '') : '' ?>>Campus Nurse</option>
                                            </select>
                                        </div>
                                        <div class="col mb-2">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                            <a href="organization" class="btn btn-danger">Reset</a>
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
                                            <th>Campus</th>
                                            <th>Position</th>
                                            <th>Full Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['organization']) && $_GET['organization'] != '') {
                                            $organization = $_GET['organization'];
                                            $count = 1;
                                            $sql = "SELECT * FROM organization WHERE CONCAT(firstname, ' ' , middlename, ' ', lastname) LIKE '%$organization%' OR CONCAT(firstname, ' ', lastname) LIKE '%$organization%' ORDER BY campus, title LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } elseif (isset($_GET['campus']) && $_GET['campus'] != '' || isset($_GET['title']) && $_GET['title'] != '') {
                                            $campus = isset($_GET['campus']) ? $_GET['campus'] : '';
                                            $title = isset($_GET['title']) ? $_GET['title'] : '';
                                            $count = 1;
                                            if ($campus == "") {
                                                $dep = "";
                                            } else {
                                                $dep = " WHERE campus = '$campus'";
                                            }

                                            if ($title == "") {
                                                $col = "";
                                            } elseif ($dep == "" and $title != "") {
                                                $col = " WHERE title = '$title'";
                                            } elseif ($dep != "" and $title != "") {
                                                $col = " AND title = '$title'";
                                            }
                                            $sql = "SELECT * FROM organization $dep $col ORDER BY campus, title LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        } else {
                                            $count = 1;
                                            $sql = "SELECT * FROM organization ORDER BY campus, title LIMIT $start, $rows_per_page";
                                            $result = mysqli_query($conn, $sql);
                                        }
                                        if ($result) {
                                            if (mysqli_num_rows($result) > 0) {
                                                foreach ($result as $data) {
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
                                        ?>
                                                    <tr>
                                                        <td><?php echo $data['campus']; ?></td>
                                                        <td><?php echo $data['title']; ?></td>
                                                        <td><?php echo ucwords(strtolower($data['firstname'])) . " " . strtoupper($middleinitial) . " " . ucwords(strtolower($data['lastname'])) . ", " .  $data['extension']; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateorganization<?php echo $data['id']; ?>">Update</button>
                                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#removeorganization<?php echo $data['id']; ?>">Remove</button>
                                                            <?php $count++; ?>
                                                        </td>

                                                    </tr>
                                                <?php
                                                    include('modals/update_organization_modal.php');
                                                    include('modals/rem_organization_modal.php');
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
                                            <a class="page-link" href="?<?= isset($_GET['organization']) ? 'organization=' . $_GET['organization'] . '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '', isset($_GET['title']) ? 'title=' . $_GET['title'] . '&' : '' ?>page=<?= 1; ?>">&laquo;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['organization']) ? 'organization=' . $_GET['organization'] . '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '', isset($_GET['title']) ? 'title=' . $_GET['title'] . '&' : '' ?>page=<?= $previous; ?>">&lt;</a>
                                        </li>
                                        <?php for ($i = $start_loop; $i <= $end_loop; $i++) : ?>
                                            <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                                                <a class="page-link" href="?<?= isset($_GET['organization']) ? 'organization=' . $_GET['organization'] . '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '', isset($_GET['title']) ? 'title=' . $_GET['title'] . '&' : '' ?>page=<?= $i; ?>"><?= $i; ?></a>
                                            </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['organization']) ? 'organization=' . $_GET['organization'] . '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '', isset($_GET['title']) ? 'title=' . $_GET['title'] . '&' : '' ?>page=<?= $next; ?>">&gt;</a>
                                        </li>
                                        <li class="page-item <?php echo $page == $pages ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?<?= isset($_GET['organization']) ? 'organization=' . $_GET['organization'] . '&' : '', isset($_GET['campus']) ? 'campus=' . $_GET['campus'] . '&' : '', isset($_GET['title']) ? 'title=' . $_GET['title'] . '&' : '' ?>page=<?= $pages; ?>">&raquo;</a>
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