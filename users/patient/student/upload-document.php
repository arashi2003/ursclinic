<?php
include '../../../connection.php';

$id = $_POST['id'];
$applicant = $_POST['applicant'];
$desc = $_POST['document'];
$type = $_POST['type'];

$src = $_FILES["fileImg"]["tmp_name"];

$extension = pathinfo($_FILES["fileImg"]["name"], PATHINFO_EXTENSION);

$imageName = $type . '-' . $applicant . '-' . date('his') . $desc . '.' . $extension;

$target = "../documents/" . $imageName;

move_uploaded_file($src, $target);

$query = "UPDATE meddoc SET document = '$imageName' WHERE id = '$id'";
mysqli_query($conn, $query);

header("Location: medical");
