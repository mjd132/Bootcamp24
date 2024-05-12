<?php
require_once "DataGenerator.php";
const DB_NAME = 'task_back4',
    DB_HOST = 'localhost',
    DB_USER = 'root',
    DB_PWD = '',
    DB_PERSONS_TABLE = 'persons',
    COMMIT_BATCH_SIZE = 10000,
    COUNT_DATA_GENERATE = 1000000;
const USER_NOT_FOUND = "User not found",
    USER_EXISTS = "User exists",
    INCORRECT_PASSWORD = "Incorrect password",
    USER_CREATED = "User created!";

try {
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USER, DB_PWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $pdo->exec("USE " . DB_NAME);

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS " . DB_PERSONS_TABLE . "(
                id INT AUTO_INCREMENT PRIMARY KEY,
                gender ENUM('male', 'female'),
                name VARCHAR(255),
                family VARCHAR(255),
                age INT,
                mobile VARCHAR(20),
                national_code VARCHAR(20),
                about TEXT,
                isMarried BOOLEAN,
                INDEX (gender),
                INDEX (gender,age),
                INDEX (gender,age,isMarried)
                );
                "
    );
    $cmd = $pdo->query("SELECT COUNT(*) FROM persons");
    if ($cmd->fetchColumn() === 0) {

    }

} catch (PDOException $ex) {
    echo "connect to database failed: </br>" . $ex->getMessage();
}
function checkEmptyTable($tableName)
{
    global $pdo;
    $cmd = $pdo->query("SELECT EXISTS (SELECT 1 FROM $tableName) AS notEmpty");
    $result = $cmd->fetch(PDO::FETCH_ASSOC);
    if ($result['notEmpty'] === 1) {
        return true;
    } else
        return false;
}
function AvgAgeBasedGender()
{
    global $pdo;

    $q = $pdo->prepare("SELECT gender, AVG(age) AS average ,COUNT(*) AS count FROM " . DB_PERSONS_TABLE . " GROUP BY gender");
    $q->execute();
    return $q->fetchAll(PDO::FETCH_ASSOC);
}
function FemalesReport()
{
    global $pdo;
    $query = "SELECT 
    (SELECT COUNT(*) 
     FROM " . DB_PERSONS_TABLE . " 
     WHERE gender = 'female' AND age > 60) AS femaleOver60,
    (SELECT COUNT(*) 
     FROM " . DB_PERSONS_TABLE . " 
     WHERE gender = 'female' AND age > 60 AND isMarried = false) AS unmarriedFemaleOver60;";
    $s = $pdo->prepare($query);
    $s->execute();
    $result = $s->fetch();
    return $result;
}
function InsertPersons()
{
    global $pdo;
    if (checkEmptyTable(DB_PERSONS_TABLE))
        return;
    echo 'Inserting data . . . ';
    $query = 'INSERT INTO ' . DB_PERSONS_TABLE . ' (gender, name, family,age,mobile,about,national_code,isMarried) 
    VALUES ';

    for ($i = 1; $i <= COUNT_DATA_GENERATE / COMMIT_BATCH_SIZE; $i++) {

        $q = $query;
        for ($j = 1; $j <= COMMIT_BATCH_SIZE; $j++) {

            $person = GeneratePerson();
            $q .= "(" . implode(",", $person) . "),";

        }
        $q = rtrim($q, ",");
        $pdo->exec($q);
        echo COMMIT_BATCH_SIZE . " data inserted.";
    }

    echo 'Refresh page.';

}
