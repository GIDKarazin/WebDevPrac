<?php
$target_dir = "C:/xampp/htdocs/Practice7/public/images//";
$target_file = $target_dir . basename($_FILES["photo"]["name"]);
$isUploaded = false;
$filePath = '';

if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
    $filePath = $target_dir . basename($_FILES["photo"]["name"]);
    $filePath = basename($_FILES["photo"]["name"]);
    $isUploaded = true;
}