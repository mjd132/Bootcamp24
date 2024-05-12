<?php

require_once "Db.php";
InsertPersons();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
</head>

<body>
    <?php
    $countAvgGender = AvgAgeBasedGender();
    if (isset($countAvgGender)):
        foreach ($countAvgGender as $g):
            ?>
            <p><?= $g['gender'] ?> column have <?= $g['count'] ?> data. With age averages : <?= $g['average'] ?></p>
        <?php endforeach;
    endif; ?>

    <?php
    $femalesRp = FemalesReport();
    ?>
    <p>Number of women over 60 years old : <?= $femalesRp['femaleOver60'] ?></p>
    <p>Number of married women over 60 years old : <?= $femalesRp['unmarriedFemaleOver60'] ?></p>
</body>

</html>