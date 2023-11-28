<?php

include('conn.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <button>Generate</button>
    <a href="export.php">Export</a>
    <button>Save</button>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
        </tr>

        <?php
        $query = "SELECT * FROM members";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_array($result)) {
        ?>

            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['age']; ?></td>
            </tr>

        <?php
        }

        ?>
    </table>

    <ul>

    </ul>

</body>

</html>