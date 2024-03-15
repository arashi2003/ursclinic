<?php
session_start();
include '../../connection.php';
if (isset($_FILES["fileImg"]["name"])) {
    $id = $_POST['id'];
    
    $src = $_FILES["fileImg"]["tmp_name"];

    $extension = pathinfo($_FILES["fileImg"]["name"], PATHINFO_EXTENSION);

    $imageName = $id.'-'.date('his').'.'.$extension;

    $target = "../images/" . $imageName;

    move_uploaded_file($src, $target);

    $query = "UPDATE patient_image SET image = '$imageName' WHERE patient_id = '$id'";
    mysqli_query($conn, $query);

    header("Location: profile");
}
