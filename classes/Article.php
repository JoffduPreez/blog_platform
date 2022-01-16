<?php
require 'includes/redirect.php';

class Article
{
    public static function getAllArticles($conn, $id){
        $sql = "SELECT *
                FROM articles
                WHERE user_id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    
        // $stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');
    
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            // return $stmt->fetch();
        }
    }

    public static function getUsersArticles($conn, $id){
        $sql = "SELECT *
                FROM articles
                WHERE user_id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    
        // $stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');
    
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            // return $stmt->fetch();
        }
    }

    public static function getArticleByID($conn, $id){
        $sql = "SELECT *
                FROM articles
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
    
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');
    
        if ($stmt->execute()) {
            return $stmt->fetch();
        }
    }

    public static function newArticle($conn, $title, $content, $published_at, $userID){
        $errors = Article::validateForm($title, $content, $published_at);

        if (empty($errors)) {
            $sql = "INSERT INTO articles (title, content, published_at, user_id) 
                    VALUES (:title, :content, :published_at, :user_id)";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':title', $title, PDO::PARAM_STR);
            $stmt->bindValue(':content', $content, PDO::PARAM_STR);
            if ($published_at == '') {
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $published_at, PDO::PARAM_STR);
            }
            $stmt->bindValue(':user_id', $userID, PDO::PARAM_INT);

            if ($stmt->execute()) {
                redirect("/article_list.php");
            }
        } else {
            return $errors;
        }
    }

    public static function editArticle($conn, $title, $content, $published_at, $id){
        $errors = Article::validateForm($title, $content, $published_at);

        if (empty($errors)){
            $sql = "UPDATE articles
                    SET title = :title,
                        content = :content,
                        published_at = :published_at
                    WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':title', $title, PDO::PARAM_STR);
            $stmt->bindValue(':content', $content, PDO::PARAM_STR);
            if ($published_at == '') {
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $published_at, PDO::PARAM_STR);
            }
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                redirect("/article.php?id={$id}");
            }
        } else {
            return $errors;
        }
    }

    public static function deleteArticle($conn, $id){
        $sql = "DELETE FROM articles
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            redirect("/");
        }
    }

    public static function validateForm($title, $content, $published_at){
        $errors = [];

        if ($title == '') {
            array_push($errors, 'Title is required');
        }
        if ($content == '') {
            array_push($errors, 'Content is required');
        }

        return $errors;
    }

}