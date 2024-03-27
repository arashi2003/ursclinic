<?php
include '../../../connection.php';

$id = $_POST['id'];
$applicant = $_POST['applicant'];
$desc = $_POST['document'];
$type = $_POST['type'];

$src = $_FILES["fileImg_update"]["tmp_name"];

$extension = pathinfo($_FILES["fileImg_update"]["name"], PATHINFO_EXTENSION);

$imageName = $type . '-' . $applicant . '-' . date('mdy-his') . $desc . '.' . $extension;

$target = "../documents/" . $imageName;

move_uploaded_file($src, $target);

$today = date('Y-m-d h:i:s');

$query = "UPDATE meddoc SET document = '$imageName', status = 'Pending', remarks = 'Uploaded a document again', dt_updated = '$today' WHERE id = '$id'";
mysqli_query($conn, $query);

header("Location: medical");
