<?php

$api_url = 'https://jsonplaceholder.typicode.com/posts';

// Read JSON file
$json_data = file_get_contents($api_url);

// Decode JSON data into PHP array
$response_data = json_decode($json_data);


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
    <a href="export_api.php">Export</a>
    <button>Save</button>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
        </tr>

        <?php
        foreach ($response_data as $data) {
        ?>
            <tr>
                <td><?php echo $data->id; ?></td>
                <td><?php echo $data->title; ?></td>
                <td><?php echo $data->body; ?></td>
            </tr>
        <?php
        }
        ?>
    </table>

    <ul>

    </ul>

</body>

</html>