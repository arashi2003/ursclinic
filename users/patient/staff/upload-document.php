<?php
session_start();
include '../../../connection.php';

$id = $_POST['id'];
$applicant = $_POST['applicant'];
$desc = $_POST['document'];
$type = $_POST['type'];

$src = $_FILES["fileImg"]["tmp_name"];

$extension = pathinfo($_FILES["fileImg"]["name"], PATHINFO_EXTENSION);

$imageName = $type . '-' . $applicant . '-' . date('mdy-his') . $desc . '.' . $extension;

$target = "../documents/" . $imageName;

move_uploaded_file($src, $target);

$today = date('Y-m-d h:i:s');

$query = "UPDATE meddoc SET document = '$imageName', status = 'Pending', remarks = 'Uploaded a document', dt_uploaded = '$today' WHERE id = '$id'";
mysqli_query($conn, $query);

$_SESSION['alert'] = 'You have successfully upload a document';

header("Location: medical");
