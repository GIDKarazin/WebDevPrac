<?php
class Db {
    public function __construct()
    {
    }
    public function getConnect() {

        $users = json_decode(file_get_contents(__DIR__ . "/database.json"), true);

        $conn = mysqli_connect($users['hostname'], $users['username'], $users['password'], $users['database']);

        if (!$conn) {
            echo "Could not connect MySQL." . "<br>";
            echo "Error code: " . mysqli_connect_errno() . "<br>";
            echo "Error text: " . mysqli_connect_error() . "<br>";
            exit;
        }
        return $conn;
    }
}
