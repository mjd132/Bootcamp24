<?php
require_once "./Repositories/BlogRepository.php";
session_start();
if
(!isset($_SESSION['admin_username'])) {
    header("location: index.php");
    exit();
}
if (isset($_POST['submit']) && isset($_POST['title'])) {
    $result = UpdatePost($_POST['id'], $_POST['title'], $_POST['content']);
    if ($result)
        $message = "successfully";
}
if (isset($_GET['postId'])) {
    $postId = $_GET['postId'];
} else {
    header("location: admin.php");
    exit();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Post</title>
</head>

<body>
    <div style="color: green;">
        <?php if (isset($message))
            echo $message ?>
        </div>

    <?php $post = GetPost($postId)->fetch_assoc();
        if (!$post)
            header("location: admin.php") ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?postId=' . $post['id']; ?>">
        <input type="text" name="id" value="<?php echo $postId ?>">
        <input type="text" name="title" value="<?php echo $post['title'] ?>" />
        <textarea name="content"><?php echo $post['content'] ?></textarea>
        <button type="submit" name="submit">Save</button>
    </form>
</body>

</html>