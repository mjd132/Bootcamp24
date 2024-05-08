<?php
require_once './Auth/Auth.php';
if (IsAuth())
    header('location: dashboard.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (!isset($_POST['pwd'], $_POST['uname'])) {
        $error = "Username or Password is empty!";
    } else {

        $result = Login($_POST['uname'], $_POST['pwd']);
        switch (true) {
            case $result === true:
                header('location: dashboard.php');
                break;
            case $result === USER_NOT_FOUND:
                $error = USER_NOT_FOUND;
                break;
            case $result === INCORRECT_PASSWORD:
                $error = INCORRECT_PASSWORD;
                break;
            default:
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <title>Login</title>
</head>

<body>
    <div class="flx-p">
        <div class="login-container">
            <h1>Login</h1>

            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="input-flx ">
                    <label for="username">Username:</label>
                    <input type="text" name="uname" required>
                </div>
                <div class="input-flx ">
                    <label for="password">Password:</label>
                    <input type="password" name="pwd" required>
                </div>

                <div id="lgn-btn">
                    <button type="submit">Login</button>

                </div><a href="register.php">

                    <p>Register</p>

                </a>
            </form>

        </div>
    </div>


</body>

</html>