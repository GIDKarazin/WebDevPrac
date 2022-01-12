<?php
    // Code with validation will be here and saving user will be here
    // Preventing some potential security threat like SQL Injection
    filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Imports external css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!--Imports my own styles-->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .container {
            width: 400px;
        }
    </style>
    <title>Redirect</title>
</head>
<body style="padding-top: 3rem;">

<div class="container">
    <?php
        include 'uploads.php';
        require 'db.php';

        if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["gender"])) {
            // IF any field is empty THEN prints error message
            echo "<div class='redText'>Oh my, there is some invalid data here!</div>";
        }
        else {
            // Creating variables to save our result for convenience
            $name = $_POST["name"];
            $email = $_POST["email"];
            $gender = $_POST["gender"];
            
            // Prints user information
            echo "<b>A new user has been added!</b><br>";
            echo "Name of the user: "   . $name   . "<br>";
            echo "Email of the user: "  . $email  . "<br>";
            echo "Gender of the user: " . $gender . "<br>";

            if (empty($filePath)) {
                $filePath = "public/images/img.jpg";
                echo "Path to the profile photo: " . $filePath . "<br>";
                $filePath = "";
            }
            else
                echo "Path to the profile photo: " . $filePath . "<br>";

            // id is unset because of a_i
            // password will be the same for everyone
            $password = 11111;
            $sql = "
                INSERT INTO users (email, name, gender, password, path_to_img)
                VALUES ('$email', '$name','$gender', '$password', '$filePath')
            ";
            $res = mysqli_query($conn, $sql);
        }
    ?>

    <hr>
    <a class="btn" href="login.php">Return back</a>
    <a class="btn" href="table.php">User list</a>
</div>
</body>
</html>