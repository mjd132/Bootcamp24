<?php
require_once './db.php';

$pageNumber = isset($_POST['page']) ? (int) $_POST['page'] : 1;


// if (!isset($searchQuery))
$searchQuery = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchQuery = array('lName' => $_POST['lname'], 'nationalId' => $_POST['nationalId'], "phone" => $_POST['phone']);

    if (isset($_POST['search'])) {
        $pageNumber = 1;

    } elseif (isset($_POST['prev'])) {
        (int) $_POST['page'] - 1 <= 0 ? $pageNumber = 1 : $pageNumber = (int) $_POST['page'] - 1;

    } elseif (isset($_POST['next'])) {
        $pageNumber++;

    } elseif (isset($_POST['goPage'])) {
        (int) $_POST['page'] <= 0 ? $pageNumber = 1 : $pageNumber = (int) $_POST['page'];

    }
}
$sResult = GetPersons($pageNumber, 20, $searchQuery);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persons</title>
</head>

<body>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <input type="text" name="lname" placeholder="Last Name"
            value="<?php echo isset($_POST['lname']) ? htmlspecialchars($_POST['lname']) : ''; ?>">
        <input type="text" name="phone" placeholder="Phone Number"
            value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
        <input type="number" name="nationalId" placeholder="National Id"
            value="<?php echo isset($_POST['nationalId']) ? htmlspecialchars($_POST['nationalId']) : ''; ?>">
        <button type="submit" name="search">Search</button>
        <div class="page-nav">
            <span>
                <button type="submit" name="prev" <?php if ($pageNumber == 1)
                    echo 'disabled' ?>>Previous Page</button>
                    <input type="number" name="page" value="<?php echo $pageNumber ?>" />
                <button type="submit" name="goPage">Go to</button>

                <button type="submit" name="next">Next Page</button>

            </span>
        </div>
    </form>

    <div>
        <table>
            <thead>
                <th>No.</th>
                <th>National Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Phone Number</th>


            </thead>
            <tbody>
                <?php foreach ($sResult['data'] as $fieldName => $fieldValue): ?>
                    <tr>
                        <td> <?php echo $fieldName + 1 ?> </td>
                        <td> <?php echo htmlspecialchars($fieldValue['National Id']) ?> </td>
                        <td> <?php echo htmlspecialchars($fieldValue['First Name']) ?> </td>
                        <td> <?php echo htmlspecialchars($fieldValue['Last Name']) ?> </td>
                        <td> <?php echo htmlspecialchars($fieldValue['PhoneNumber']) ?> </td>


                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <span>

        </span>

    </div>
</body>

</html>