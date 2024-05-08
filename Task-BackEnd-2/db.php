<?php

try {
    $pdo = new PDO("mysql:host=localhost", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS big_data");
    $pdo->exec("USE big_data");

    $pdo->exec("CREATE TABLE IF NOT EXISTS persons (
        `National Id` INT AUTO_INCREMENT PRIMARY KEY,
        `First Name` VARCHAR(255) NULL,
        `Last Name` VARCHAR(255) NOT NULL,
        `PhoneNumber` VARCHAR(20) NULL);");

    $cmd = $pdo->query("SELECT COUNT(*) FROM persons");
    if ($cmd->fetchColumn() === 0) {

        $ct = str_replace("\\", "\\\\", __DIR__) . "\\\\data.csv";
        $pdo->exec("
        LOAD DATA INFILE '$ct'
        INTO TABLE persons
        FIELDS TERMINATED BY ',' ENCLOSED BY '\"'
        LINES TERMINATED BY '\\n'
        IGNORE 1 LINES
        (`First Name`, `Last Name`, `PhoneNumber`);");
    }



} catch (PDOException $ex) {
    echo "connection failed : " . $ex->getMessage();
}

function GetPersons($pageNumber = 1, $pageSize = 20, $searchQuery = null)
{
    //init variables
    global $pdo;
    $offset = ($pageNumber - 1) * $pageSize;
    $query = "SELECT * FROM persons ";
    // check conditions and assign query 
    if ($searchQuery) {
        if (!empty($searchQuery['nationalId'])) {
            $pQuery[] = "`National Id`=:nationalId";
            $params[':nationalId'] = $searchQuery['nationalId'];

        }

        if (!empty($searchQuery['phone'])) {
            $pQuery[] = " PhoneNumber LIKE :phone_number ";
            $params[':phone_number'] = "%{$searchQuery['phone']}%";

        }
        if (!empty($searchQuery['lName'])) {
            $pQuery[] = " `Last Name` LIKE :lname ";
            $params[':lname'] = "%{$searchQuery['lName']}%";

        }
        //aggregate conditions query
        if (!empty($pQuery))
            $query .= ' WHERE ' . implode(' OR ', $pQuery);
    }
    //add limit query for pagination
    $query .= " LIMIT :offset, :pageSize";

    $cmd = $pdo->prepare($query);
    // binding values to parameters
    if (!empty($params))
        foreach ($params as $k => $v) {
            if (is_int($v))
                $cmd->bindValue($k, $v, PDO::PARAM_INT);
            elseif (is_string($v))
                $cmd->bindValue($k, $v);
        }

    $cmd->bindParam(':offset', $offset, PDO::PARAM_INT);
    $cmd->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);
    // execute query and get data
    $cmd->execute();
    $results = $cmd->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

