<?php

$apiKey = '';
$steamId = '';

// URLs for the two API endpoints
$gameStatsUrl = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=$apiKey&steamid=$steamId&include_appinfo=1&format=json";
$playerSummaryUrl = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$apiKey&steamids=$steamId";

// Fetch data from both URLs
$gameStatsResponse = file_get_contents($gameStatsUrl);
$playerSummaryResponse = file_get_contents($playerSummaryUrl);

// Decode JSON responses into associative arrays
$gameStatsData = json_decode($gameStatsResponse, true);
$playerSummaryData = json_decode($playerSummaryResponse, true);

// Combine the data into a single array
$combinedData = [
    'gameStats' => $gameStatsData['response'] ?? null, // Include game stats data (if available)
    'playerSummary' => $playerSummaryData['response']['players'][0] ?? null // Include the first player's summary (if available)
];

// Set the content type to JSON
header('Content-Type: application/json');

// Encode and return the combined data as JSON
echo json_encode($combinedData);

?>