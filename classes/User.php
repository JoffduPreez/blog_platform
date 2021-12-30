<?php

class User
{
    public static function authenticate($conn, $username, $password){
        $sql = "SELECT *
                FROM user
                WHERE username = :username";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

        $stmt->execute();

        $user = $stmt->fetch();
        if ($user->username == $username && $user->password == $password) {
            return true;
        } else {
            return false;
        }
    }

    public static function registerUser($conn, $username, $password, $password2){
        $errors = User::validateForm($conn, $username, $password, $password2);

        if (empty($errors)){
            $sql = "INSERT INTO user (username, password, article_id) 
            VALUES (:username, :password, :article_id)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->bindValue(':article_id', NULL, PDO::PARAM_NULL);

            $stmt->execute();

        } else {
            return $errors;
        }
    }

    public static function validateForm($conn, $username, $password, $password2){
        $sql = "SELECT *
                FROM user
                WHERE username = :username";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute();
        $user = $stmt->fetch();

        $errors = [];

        if ($username == '') {
            array_push($errors, 'Username is required');
        }
        if ($username == $user->username) {
            array_push($errors, 'Username is already taken');
        }
        if ($password == '') {
            array_push($errors, 'Password is required');
        }
        if (strlen($password) < 5) {
            array_push($errors, 'Password must be at least 5 characters');
        }
        if ($password2 != $password) {
            array_push($errors, 'Password confirmation does not match original password');
        }
        if ($username == $password) {
            array_push($errors, 'Username and password cannot be the same');
        }

        return $errors;
    }

    public static function login($conn, $username){
        session_regenerate_id(true);
        $_SESSION['is_logged_in'] = true;

        $sql = "SELECT *
                FROM user
                WHERE username = :username";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
        $stmt->execute();
        $user = $stmt->fetch();

        $_SESSION['login_id'] = $user->id;
    }

    public static function logout(){
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }
}
