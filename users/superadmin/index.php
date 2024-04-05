<?php

session_start();

$name = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Restore</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="../../images/university-seal.png">
    <link rel="stylesheet" type="text/css" href="../../css/dashboard.css?v=<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
    <section class="superadmin">
        <nav>
            <div class="sidebar-button">
                <span class="dashboard">Restore</span>
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
                            <li><a class="dropdown-item" href="logout">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="home-content">
            <div class="overview-boxes mt-5">
                <?php

                if (isset($_SESSION['alert'])) {
                ?>
                    <div class="alert-message">
                        <div class="alert alert-info alert-dismissible fade show" role="alert" id="success-alert">
                            <?= $_SESSION['alert']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>

                    <script>
                        $(document).ready(function() {
                            setTimeout(function() {
                                $(".alert").alert('close');
                            }, 5000);
                        });
                    </script>
                <?php
                    unset($_SESSION['alert']);
                }

                ?>
                <div class="container mt-5">
                    <h1 class="mb-4">Database Drop</h1>
                    <div class="input-group">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#dropmodal">Drop Database</button>
                    </div>
                    <?php include('drop-modal.php') ?>
                </div>

                <div class="container mt-5">
                    <h1>Database Restore</h1>
                    <form method="post" action="restore.php" enctype="multipart/form-data" class="mt-4">
                        <div class="input-group">
                            <input type="file" class="form-control" id="backupFile" name="backupFile" accept=".sql" onchange="checkFile()">
                            <button type="submit" name="restoreBtn" class="btn btn-primary" id="restoreButton" disabled>Restore Database</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

<script>
    function checkFile() {
        var fileInput = document.getElementById('backupFile');
        var restoreButton = document.getElementById('restoreButton');

        // Check if a file is selected
        if (fileInput.files.length > 0) {
            // Check if the selected file has a .sql extension
            var fileName = fileInput.files[0].name;
            if (fileName.endsWith('.sql')) {
                restoreButton.disabled = false; // Enable the restore button
            } else {
                alert('Please select a .sql file.');
                restoreButton.disabled = true; // Disable the restore button
                fileInput.value = ''; // Clear the file input
            }
        } else {
            restoreButton.disabled = true; // Disable the restore button
        }
    }
</script>

</html>