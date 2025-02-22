<?php

//plug userID and auth into here (Lily's as example)
$userID = '21779129';
$authToken = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJhOWNhY2ExNDI2MzI3YmQ5ZmE2MTI2NTRiNTk5NTIwNCIsIm5iZiI6MTczNzk5ODQ1OS40MDIsInN1YiI6IjY3OTdjMDdiMDljMjUyZTNhYjIzZGY2YyIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.zmcMBdlO7wllH_BvB1mZaqvydJC98yN7WuqhQePF004';

//function for reuse of cURL
function getResponse($url){
  $curl = curl_init();

  global $authToken;

  //sets cURL perameters
  curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
      "Authorization: Bearer $authToken",
      "accept: application/json"
    ],
  ]);

  $response = curl_exec($curl);
  curl_close($curl);

  //returns the response
  return $response;
}

//gets the response for each
$filmResponse = getResponse("https://api.themoviedb.org/3/account/$userID/rated/movies?language=en-US&page=1&sort_by=created_at.desc");
$userResponse = getResponse("https://api.themoviedb.org/3/account/$userID");
$favTVResponse = getResponse("https://api.themoviedb.org/3/account/$userID/favorite/tv?language=en-US&page=1&sort_by=created_at.asc");

//decodes JSON
$filmData = json_decode($filmResponse, true);
$userData = json_decode($userResponse, true);
$favTVData = json_decode($favTVResponse, true);

//combines data
$combinedData = [
    'filmData' => $filmData['results'] ?? null, 
    'userData' => $userData ?? null,
    'favTVData' => $favTVData['results'] ?? null,
];

//sets the header
header('Content-Type: application/json');

//returns data
echo json_encode($combinedData);

?>