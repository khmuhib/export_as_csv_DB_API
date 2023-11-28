<?php

require_once 'conn.php';

$query = "SELECT * FROM members ORDER BY id ASC";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $delimiter = ",";
    $filename = "export_" . date('Y-m-d') . ".csv";

    // Create a file pointer
    $f = fopen('php://memory', 'w');

    // Set column headers
    $fields = array('ID', 'Name', 'Age');
    fputcsv($f, $fields, $delimiter);

    // Output each row of the data, format line as csv and write to file pointer
    while ($row = $result->fetch_assoc()) {
        // $status = ($row['status'] == 1) ? "Active" : "Inactive";
        $lineData = array($row['id'], $row['name'], $row['age']);
        fputcsv($f, $lineData, $delimiter);
    }

    // Move back to beginning of file
    fseek($f, 0);

    // Set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    //output all remaining data on a file pointer
    fpassthru($f);
} else {
    echo "No records found";
}

exit;
