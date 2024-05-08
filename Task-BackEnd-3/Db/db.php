<?php

const DB_NAME = 'task_back3',
    DB_HOST = 'localhost',
    DB_USER = 'root',
    DB_PWD = '',
    DB_USER_TABLE = 'Users';

const USER_NOT_FOUND = "User not found",
    USER_EXISTS = "User exists",
    INCORRECT_PASSWORD = "Incorrect password",
    USER_CREATED = "User created!";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $pdo->exec("USE " . DB_NAME);

    $pdo->exec("CREATE TABLE IF NOT EXISTS " . DB_USER_TABLE . "(
        `Id` INT AUTO_INCREMENT PRIMARY KEY,
        `Username` VARCHAR(255) NOT NULL UNIQUE,
        `Name` VARCHAR(255) NULL,
        `Password` VARCHAR(200) NOT NULL);");

} catch (PDOException $ex) {
    echo "connect to database failed: </br>" . $ex->getMessage();
}

function GetUser($username)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM " . DB_USER_TABLE . " WHERE Username=:uname");
    $stmt->bindValue(":uname", $username);

    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function IsExistsUser($username)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM " . DB_USER_TABLE . " WHERE Username=:uname");
    $stmt->bindValue(":uname", $username);

    $stmt->execute();

    if ($stmt->fetchColumn() > 0)
        return true;
    else
        return false;

}
function AddUser($user)
{
    global $pdo;


    if (IsExistsUser($user['uname']))
        return USER_EXISTS;

    $hashedPassword = password_hash($user['pwd'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO " . DB_USER_TABLE . " (Username, Name, Password) VALUES (:uname,:name,:pwd)");
    $params = array(":uname" => $user['uname'], ":name" => $user['name'], ":pwd" => $hashedPassword);

    $stmt->execute($params);
    $id = $pdo->lastInsertId();
    return $id;

}
