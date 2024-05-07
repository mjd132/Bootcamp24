<?php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=big_data", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

