<?php
include './Repositories/BlogRepository.php';

$pageNumber = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$pageSize = 5;
$postsPaginated = GetPosts($pageSize, $pageNumber);
$totalPages = $postsPaginated['totalPages'];
$perviousPage = $pageNumber > 1 ? "?page=" . ($pageNumber - 1) : "#";
$nextPage = $pageNumber < $totalPages ? "?page=" . ($pageNumber + 1) : "#";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title>
        <?php
        echo SITE_NAME;
        ?>

    </title>
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="header-container">
                <div class="blogName">
                    <a href="./">
                        <?php echo SITE_NAME ?>
                    </a>
                </div>
                <div class="socialMedia">

                </div>
            </div>
        </header>


        <section class="main">

            <div class="blogPosts">
                <?php while ($post = $postsPaginated['result']->fetch_assoc()): ?>
                    <div class="post">
                        <h2 class="title-post"><?php echo $post['title']; ?></h2>
                        <small class="date-post">AT: <?php echo $post['created_at']; ?></small>
                        <p class="body-post"><?php echo $post['content']; ?></p>

                    </div>
                <?php endwhile; ?>
            </div>
            <div class="paginationNav">
                <?php if ($totalPages > 0): ?>
                    <div class="pervious-page">
                        <a href="<?php echo $perviousPage ?>">Previous</a>
                    </div>
                    <div class="pages-container">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>

                            <?php if ($i == $pageNumber): ?>
                                <a href="?page=<?php echo $i; ?>" class="page-num-current page-num">
                                    <?php echo $i; ?>
                                </a>
                            <?php else: ?>
                                <a href="?page=<?php echo $i; ?>" class="page-num">
                                    <?php echo $i; ?>
                                </a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                    <div class="next-page">
                        <a href="<?php echo $nextPage ?>">Next</a>
                    </div>
                <?php endif; ?>


                <p>Total pages: <?php echo $totalPages ?> </p>
            </div>


        </section>
        <footer class="footer"></footer>
    </div>

</body>

</html>