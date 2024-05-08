<?php
require_once './Auth/Auth.php';
if (!IsAuth()) {
    header('location: login.php');
    exit();
}
$user = GetAuthenticatedUser();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title>Dashboard</title>
</head>

<body>
    <div class="home-container">
        <h2>Welcome to dashboard <?php echo $user['Name'] ?></h2>
        <a href="logout.php">Logout</a>
    </div>

</body>

</html>