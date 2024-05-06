<?php
function GetAdmin($username, $password)
{
    include './DbContext/db.php';

    $query = "SELECT * FROM " . DB_ADMIN_TABLE_NAME . " WHERE username='$username'";
    $result = $db->query($query);


    if ($result->num_rows == 1) {
        $result = $result->fetch_assoc();
        $hashed_password = $result['password'];

        if (password_verify($password, $hashed_password))
            return $result;

    }
    return null;
}


