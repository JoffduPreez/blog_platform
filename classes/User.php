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
            $sql = "INSERT INTO user (username, password) 
            VALUES (:username, :password)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);

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

    public static function getAllUsers($conn, $currentUserId){
        $sql = "SELECT *
                FROM user
                WHERE NOT (id = " . $currentUserId . ")";

        $stmt = $conn->prepare($sql);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            // return $stmt->fetch();
        }
    }

    public static function getCurrentUser($conn, $currentUserId){
        $sql = "SELECT *
                FROM user
                WHERE id = :currentUserId";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':currentUserId', $currentUserId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public static function followUser($conn, $currentUser, $newFollowId){
        $sql = "INSERT INTO user_relationships (follower, following) 
                VALUES (:currentUser, :newFollowId)";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':currentUser', $currentUser, PDO::PARAM_INT);
        $stmt->bindValue(':newFollowId', $newFollowId, PDO::PARAM_INT);

        $stmt->execute();
    }

    public static function unfollowUser($conn, $currentUser, $followId){
        $sql = "DELETE FROM user_relationships
                WHERE (follower = :currentUser AND following = :followId)";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':currentUser', $currentUser, PDO::PARAM_INT);
        $stmt->bindValue(':followId', $followId, PDO::PARAM_INT);

        $stmt->execute();
    }

    public static function checkFollow($conn, $currentUser, $otherUserId){
        $sql = "SELECT *
                FROM user_relationships
                WHERE (follower = ".$currentUser." AND following = ".$otherUserId.")";

        $stmt = $conn->prepare($sql);

        if ($stmt->execute()) {
            $userRelationship = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        if ($userRelationship == NULL) {
            return false;
        } else {
            return true;
        }
    }

    public static function getFollowing($conn, $currentUser){
        $sql = "SELECT *
                FROM user_relationships
                WHERE (follower = ".$currentUser.")";

        $stmt = $conn->prepare($sql);

        if ($stmt->execute()) {
            $following = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $sql = "SELECT *
                FROM user
                WHERE (";

        for ($i = 0; $i < count($following); $i++) {
            if ($i == count($following) - 1) {
                $sql .= "id = " . $following[$i]['following'] . ")";
            } else {
                $sql .= "id = " . $following[$i]['following'] . " OR ";
            }
        }

        $stmt = $conn->prepare($sql);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
