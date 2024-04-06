<?php
session_start();
include '../../../connection.php';

$id = $_POST['id'];
$applicant = $_POST['applicant'];
$desc = $_POST['document'];
$type = $_POST['type'];

$user = $_SESSION['userid'];
$au_campus = $_SESSION['campus'];
$fullname = strtoupper($_SESSION['name']);
$activity = "uploaded a medical document again";
$au_status = "unread";

$src = $_FILES["fileImg_update"]["tmp_name"];

$extension = pathinfo($_FILES["fileImg_update"]["name"], PATHINFO_EXTENSION);

$imageName = $type . '-' . $applicant . '-' . date('mdy-his') . $desc . '.' . $extension;

$target = "../documents/" . $imageName;

move_uploaded_file($src, $target);

$today = date('Y-m-d h:i:s');

$query = "UPDATE meddoc SET document = '$imageName', status = 'Pending', remarks = 'Uploaded a document again', dt_updated = '$today' WHERE id = '$id'";
if (mysqli_query($conn, $query)) {
    echo $sql = "INSERT INTO audit_trail (user, fullname, campus, activity, status, datetime) VALUES ('$user', '$fullname', '$au_campus', '$activity', '$au_status', now())";
    if ($result = mysqli_query($conn, $sql)) {
        $_SESSION['alert'] = 'You have successfully uploaded a document again';
        header("Location: medical");
    }
} else {
    $_SESSION['alert'] = 'The document was not uploaded';
    header("Location: medical");
}
