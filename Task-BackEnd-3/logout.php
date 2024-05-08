<?php
require_once "./Auth/Auth.php";
unsetAuthCookie();
header('location: index.php');
exit();
?>