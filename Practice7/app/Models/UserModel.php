<?php
class User {
    private string $name;
    private string $email;
    private string $password;
    private string $gender;

    public function __construct($name = '', $email = '', $gender = '',$password = '') {

        $this->name   = $name;
        $this->email  = $email;
        $this->password  = $password;
        $this->gender = $gender;
    }

    public static function byId($conn, $id) {

        $command = "SELECT * FROM users WHERE id=$id";
        $result = $conn->query($command);
        return $result->fetch_assoc();
    }

    public static function uploadImage() : string {
        $target_dir = "C:/xampp/htdocs/Practice7/public/uploads/";
        $target_file = $target_dir . $_FILES["photo"]["name"];
        var_dump($_FILES["photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            return $_FILES["photo"]["name"];
        }

        return "";
   }

    public function add($conn) {
        $pathtoimg = self::uploadImage();
        $sql = "INSERT INTO users (email, name, gender, password, path_to_img)
           VALUES ('$this->email', '$this->name','$this->gender', '$this->password', '$pathtoimg')";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            return true;
        }
        return false;
    }

    public static function all($conn) {
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql); //completing the request
        if ($result->num_rows > 0) {
            $arr = [];
            while ( $db_field = $result->fetch_assoc() ) {
                $arr[] = $db_field;
            }
            return $arr;
        } else {
            return [];
        }
    }

    public static function update($conn, $id, $data) {

        /**
         * @var string $email
         * @var string $name
         * @var string $gender
         * @var string $pathtoimg
         */
        
        echo "ID:" . $id . "<br>Name: " . $data->name . "<br>Email: " . $data->email . "<br>Gender: " . $data->gender;

        self::deleteImageByID($conn, $id);
        $pathtoimg = self::uploadImage();
        $sql = "UPDATE `users` SET `email`='$data->email',`name`='$data->name',`password`='$data->password', `gender`='$data->gender',`path_to_img`='$pathtoimg' WHERE id=$id";

        echo $sql;
        $res = mysqli_query($conn, $sql);
        if ($res) {
            return true;
        }

        return false;
    }
    public static function delete($conn, $id) {
        self::deleteImageByID($conn, $id); // deleting image

        $sql = "DELETE FROM users WHERE id=$id"; // deleteing from DB

        echo "ID: " . $id;
        $res = mysqli_query($conn, $sql);
        if ($res) {
            return true;
        }
    }

    public static function show($conn, $id) {
        $command = "SELECT * FROM users WHERE id=$id";
        $result = $conn->query($command);
        return $result->fetch_assoc();
    }

    private static function deleteImageByID ($conn, $id) {
        $command = "SELECT * FROM users WHERE id=$id";
        $result = $conn->query($command);
        $result = $result->fetch_assoc();
        if ($result['path_to_img'] !== "") {

            unlink("C:/xampp/htdocs/Practice7/public/uploads/" . $result['path_to_img']);
        }
    }
}