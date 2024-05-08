<?php
require_once './Auth/Auth.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title>Home</title>
</head>

<body>
    <div class="home-container">
        <div>
            <h2>Home Page</h2>
        </div>
        <div class="bnt-container">
            <?php if (IsAuth()):
                $user = GetAuthenticatedUser(); ?>

                <h5>You logged in, <a href="dashboard.php"><?php echo $user['Name'] ?></a> </h5>

                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">
                    <div>Login</div>
                </a>
                <a href="register.php">
                    <div>Register</div>
                </a>
            <?php endif; ?>
        </div>
    </div>


</body>

</html>