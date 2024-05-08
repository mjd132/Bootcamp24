<?php
require_once './Auth/Auth.php';
if (IsAuth())
    header('location: dashboard.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    isset($_POST['uname']) ? $user['uname'] = $_POST['uname'] : $error = "Username cannot be empty!";
    $user['name'] = $_POST['name'];
    if (!isset($_POST['pwd'], $_POST['rpwd'])) {
        $error = "Password cannot be empty!";
    } elseif ($_POST['pwd'] !== $_POST['rpwd']) {
        $error = "Password and repassword not match!";

    } else {
        $user['pwd'] = $_POST['pwd'];
        $result = Register($user);
        if ($result === true) {
            header('location: dashboard.php');
        } elseif ($result === USER_EXISTS) {
            $error = $result;
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
    <title>Register</title>
</head>

<body>
    <div class="flx-p">
        <div class="login-container">

            <h1>Register</h1>

            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                <div class="input-flx ">
                    <label for="name">Name </label>
                    <input type="text" name="name">
                </div>
                <div class="input-flx ">
                    <label for="username">Username </label>
                    <input type="text" name="uname" required>
                </div>
                <div class="input-flx ">
                    <label for="password">Password </label>
                    <input type="password" name="pwd" required>
                </div>
                <div class="input-flx ">
                    <label for="password">RePassword </label>
                    <input type="password" name="rpwd" required>
                </div>

                <div id="lgn-btn">
                    <button type="submit">Register</button>
                </div>
                <a href="login.php">

                    <p>Login</p>

                </a>
            </form>
        </div>
    </div>
</body>

</html>