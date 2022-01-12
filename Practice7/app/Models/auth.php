<?php
class Authorization{
    
    private string $email;
    private string $password;

    public function __constructor($email = '', $password = '') {

        $this->email = $email;
        $this->password = $password;
    }

    public function auth($conn, $email, $password) {

        $users = self::all($conn);
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        foreach ($users as $user) {

            if ($user['email'] == $email && $user['password'] == $password) {

                $_SESSION['auth'] = true;
                return;
            }
        }
        $_SESSION['auth'] = false;
    }

    public static function all($conn) {
    
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql); //Completing the request
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

    public static function logout() {
        $_SESSION['auth'] = false;
    }
}