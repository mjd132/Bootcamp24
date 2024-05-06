<?php

function GetPosts($pageSize = 5, $pageNumber = 1)
{

    include './DbContext/db.php';


    $offset = ($pageNumber - 1) * $pageSize;

    $query = "SELECT * FROM " . DB_BLOG_TABLE_NAME . " ORDER BY created_at DESC LIMIT $offset, $pageSize";
    $result = $db->query($query);

    $totalPosts = $db->query("SELECT COUNT(*) AS total FROM " . DB_BLOG_TABLE_NAME)->fetch_assoc()['total'];

    $totalPages = ceil($totalPosts / $pageSize);

    return array('result' => $result, 'totalPages' => $totalPages);
}
function GetPost($id)
{
    include './DbContext/db.php';
    $query = "SELECT * FROM " . DB_BLOG_TABLE_NAME . " WHERE id=$id";
    $result = $db->query($query);

    return $result;
}
function AddPost($title, $content, $created_at)
{
    include './DbContext/db.php';

    $query = "INSERT INTO " . DB_BLOG_TABLE_NAME . " (title, content, created_at)
VALUES ('$title', '$content', '$created_at')";
    $result = $db->query($query);

}

function UpdatePost($id, $title, $content)
{
    include './DbContext/db.php';
    $query = "UPDATE " . DB_BLOG_TABLE_NAME . " SET title='$title', content='$content' WHERE id=$id";
    $result = $db->query($query);
    return $result;
}

function DeletePost($id)
{
    include './DbContext/db.php';

    $query = "DELETE FROM " . DB_BLOG_TABLE_NAME . " WHERE id=$id";

    $result = $db->query($query);
}