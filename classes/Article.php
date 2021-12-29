<?php
require 'includes/redirect.php';

class Article
{
    public static function getAllArticles($conn){
        try {
            $sql = "SELECT *
                FROM articles";
            $statement = $conn->query($sql);
            $articles = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $articles;
        
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function getArticleByID($conn, $id){
        try {
            $sql = "SELECT *
                    FROM articles
                    WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');
        
            if ($stmt->execute()) {
                $article = $stmt->fetch();
                return $article;
            }
        
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function newArticle($conn, $title, $content, $published_at){
        try {
            $sql = "INSERT INTO articles (title, content, published_at) VALUES (:title, :content, :published_at)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':title', $title, PDO::PARAM_STR);
            $stmt->bindValue(':content', $content, PDO::PARAM_STR);
            if ($published_at == '') {
                $stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $published_at, PDO::PARAM_STR);
            }
    
            if ($stmt->execute()) {
                $id = $conn->lastInsertId();
                redirect("/index.php");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public static function editArticle($conn, $title, $content, $published_at, $id){
        try {
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
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
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

}