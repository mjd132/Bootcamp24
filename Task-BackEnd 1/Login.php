<?php

session_start();
if (isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

include './Repositories/AdminRepository.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $admin = GetAdmin($username, $password);

    if ($admin) {

        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_name'] = $admin['name'];
        header("Location: admin.php");
        exit();

    } else {

        $error = "Invalid username or password";

    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>

</html>