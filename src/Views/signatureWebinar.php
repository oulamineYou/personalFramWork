<?php
use GuzzleHttp\Client;

// Install GuzzleHttp if you haven't already: composer require guzzlehttp/guzzle

$client = new Client();

// Replace "Your Address, Your City" with the address you want to check
//$address = "1600 Amphitheatre Parkway, Mountain View";
$address = "Studio DOPE à 1030 Schaerbeek, rue Waelhem 68";

//OpenStreetMap Nominatim.
// $response = $client->get('https://nominatim.openstreetmap.org/search', [
//     'query' => [
//         'q' => $address,
//         'format' => 'json',
//         'addressdetails' => 1,
//     ],
// ]);

//google maps
$response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
    'query' => [
        'address' => $address,
        'key' => $apiKey,
    ],
]);

$data = json_decode($response->getBody(), true);

if (!empty($data)) {
    // Address and city details
    $formattedAddress = $data[0]['display_name'];
    $city = $data[0]['address']['city'];

    // Do something with the address and city
    echo "Formatted Address: $formattedAddress\n";
    echo "City: $city\n";
} else {
    echo "Address not found or details not available.\n";
}