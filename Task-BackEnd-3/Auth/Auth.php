<?php
require_once './Db/db.php';

function Login($username, $password)
{
    $user = GetUser($username);

    if ($user) {
        $hashedPassword = $user['Password'];
        if (password_verify($password, $hashedPassword)) {
            GenerateAuthCookie($user['Username']);
            return true;
        } else
            return INCORRECT_PASSWORD;
    } else
        return USER_NOT_FOUND;

}
function Register($user)
{
    $result = AddUser($user);
    if ($result === USER_EXISTS)
        return USER_EXISTS;


    if (is_numeric($result)) {
        GenerateAuthCookie($user['uname']);
        return true;
    }

}
function IsAuth()
{
    return isset($_COOKIE['auth-username']);
}
function GenerateAuthCookie($username)
{
    $exp = time() + (30 * 24 * 60 * 60);
    setcookie('auth-username', $username, $exp);
}
function GetAuthenticatedUser()
{
    if (IsAuth())
        return GetUser($_COOKIE['auth-username']);
    else
        return null;
}
function unsetAuthCookie()
{
    setcookie('auth-username', '', time() - 3600);
}