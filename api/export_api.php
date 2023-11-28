<?php

$api_url = 'https://jsonplaceholder.typicode.com/posts';

// Read JSON file
$json_data = file_get_contents($api_url);

// Decode JSON data into PHP array
$response_data = json_decode($json_data);

if ($response_data) {
    $delimiter = ",";
    $filename = "export_" . date('Y-m-d') . ".csv";
    $f = fopen('php://memory', 'w');
    $fields = array('ID', 'Name', 'Age');
    fputcsv($f, $fields, $delimiter);
    foreach ($response_data as $row) {
        // $status = ($row->status == 1) ? "Active" : "Inactive";
        $lineData = array($row->id, $row->title, $row->body);
        fputcsv($f, $lineData, $delimiter);
    }
    fseek($f, 0);
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    fpassthru($f);
    // exit;
} else {
    echo 'Failed to fetch data from API.';
}
