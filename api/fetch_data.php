<?php
// fetch_data.php

// Assuming your API endpoint URL
$api_url = "http://smartrestaurantsolutions.com/mobileapi-v2/v3/Tigger.php?funId=600&week_year=47-2023&rest_id=57";
$token = 'eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJleHAiOjB9.5lY2yythTRWK0Hnbgl4aOjbBsFAfoBQbuhqEQCz1EmWxlMLWA3VG1vIs6mZ5lFw6cH55SefHsuQ7M9gAeIRCjA';

// Make a cURL request to the API endpoint
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Pass the Bearer token in the Authorization header
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
));

$response = curl_exec($ch);
curl_close($ch);

// Return the JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Change * to your actual allowed origin
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Authorization, Content-Type');

echo $response;
