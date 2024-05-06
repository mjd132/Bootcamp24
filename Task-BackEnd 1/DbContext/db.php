<?php
require_once './Config/config.php';

$db = new mysqli(DB_HOST, DB_USER, DB_PWD, DB_NAME);

if (!$db) {
    die("Database Connection failed: " . $db->connect_error);
}

