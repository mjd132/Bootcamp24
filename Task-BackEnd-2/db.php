<?php

try {
    $pdo = new PDO("mysql:host=localhost;dbname=big_data", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo "connection failed : " . $ex->getMessage();
}

function GetPersons($pageNumber = 1, $pageSize = 20, $searchQuery = null)
{
    global $pdo;
    $offset = ($pageNumber - 1) * $pageSize;
    $query = "SELECT * FROM persons ";

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
            // $cmd->bindValue(':search_lname', $searchQuery['lname']);
        }
        $query .= ' WHERE ' . implode(' OR ', $pQuery);
    }

    $query .= " LIMIT :offset, :pageSize";

    $cmd = $pdo->prepare($query);
    if (!empty($searchQuery))
        foreach ($params as $k => $v) {
            if (is_int($v))
                $cmd->bindValue($k, $v, PDO::PARAM_INT);
            elseif (is_string($v))
                $cmd->bindValue($k, $v);
        }
    $cmd->bindParam(':offset', $offset, PDO::PARAM_INT);
    $cmd->bindParam(':pageSize', $pageSize, PDO::PARAM_INT);

    $cmd->execute();
    $results['data'] = $cmd->fetchAll(PDO::FETCH_ASSOC);
    $results['pageNumber'] = $pageNumber;
    return $results;
}

