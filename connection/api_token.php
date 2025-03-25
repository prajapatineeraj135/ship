<?php

// API endpoint
$url = 'https://www.icarry.in/api_login';

// Parameters to send
$data = [
    'username' => 'ela4708', // replace with your actual username
    'key'      => 'O41Zx2hdGB03pOJv4Ll7D5a4jUIaUeReTADJJPCYLFHsXSnCOfekxV8Xn1mENf0J6PjUTNkokASJGNO3mnkMFRIsx1xNWcoLAttAwVG5kxXtbM7PPvjC6Htoxi6g1wJwrpSPy6dvM4fSjYXftSAi5xRCRYGYYKpdqoFdrDcjIOL8H0Mm2xXR2W2ZOchXrIc1nRktIZT7ojUjlTyByDFjR3UuMfnY7YaZz5jKM4eyeiWMMSC6TDxC6BkOvvC8SDX6'   // replace with your actual API key
];

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded'
]);

// Optional: Disable SSL verification (for debugging purposes)
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Enable verbose output to catch errors
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_STDERR, fopen('php://stderr', 'w'));

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/x-www-form-urlencoded',
    'User-Agent: MyApp/1.0'
]);

// Execute the request
$response = curl_exec($ch);

// Check for cURL errors
if ($response === false) {
    $error = curl_error($ch);
    curl_close($ch);
    die('cURL Error: ' . $error);
}

// Get HTTP response code
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($httpCode !== 200) {
    echo "HTTP Error: " . $httpCode;
    die();
}

// Close the cURL session
curl_close($ch);

// Decode the response (assuming it's in JSON format)
$responseData = json_decode($response, true);

// Check if 'api_token' exists in the response and store it in $apiToken
if (isset($responseData['api_token'])) {
    $api_token = $responseData['api_token'];
    // echo "API Token  " . $api_token;
} else {
    echo "Failed to retrieve API token. Response: ";
}

?>
