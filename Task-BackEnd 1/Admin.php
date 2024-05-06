<?php

include './Repositories/AdminRepository.php';
include './Repositories/BlogRepository.php';

session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['id']) && isset($_POST['delete'])) {
    DeletePost($_POST['id']);
}

$pageNumber = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 20;
$postsPaginated = GetPosts($pageSize, $pageNumber);
$totalPages = $postsPaginated['totalPages'];
$perviousPage = $pageNumber > 1 ? "?page=" . ($pageNumber - 1) : "#";
$nextPage = $pageNumber < $totalPages ? "?page=" . ($pageNumber + 1) : "#";

if (isset($_POST['create'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $created_at = date('Y-m-d H:i:s');
    if ($title != '')
        AddPost($title, $content, $created_at);
    header("location: admin.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
    <link rel="stylesheet" href="./style/AdminStyle.css">
</head>

<body>
    <header>
        <div>Welcome <?php echo $_SESSION['admin_name'] ?></div>
        <a href="logout.php"><small>Logout</small></a>
    </header>
    <div class="container">
        <h3>Create Post</h3>
        <form name="create-post" id="create-post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
            method="post">
            <div><label for="title">Title</label>
                <input type="text" name="title">
            </div>

            <div><label for="content">Body</label>
                <textarea name="content"></textarea>
            </div>


            <button type="submit" name="create" id="submit" value="">Create Post</button>

        </form>
        <hr>
        <h3>Posts</h3>
        <div>
            <div class="posts">
                <?php while ($post = $postsPaginated['result']->fetch_assoc()): ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="post">
                        <input type="number" class="hide" name="id" value="<?php echo $post['id']; ?>">
                        <div class="title-post"><?php echo $post['title']; ?></div>
                        <div class="body-post"><?php echo $post['content']; ?></div>
                        <small class="date-post"><?php echo $post['created_at']; ?></small>
                        <div class="btn">
                            <a class="edit-btn" href="<?php echo "editpost.php/?postId=" . $post['id']; ?>">Edit</a>
                            <input type="submit" name="delete" class="delete-btn" value="Delete">
                        </div>

                    </form>
                <?php endwhile; ?>
            </div>

        </div>
    </div>
</body>

</html>