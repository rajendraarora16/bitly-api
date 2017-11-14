<?php
header("Access-Control-Allow-Origin: *");

$urlType = $_GET['urlType'];

if($urlType == "longurl"){
    $urlName = rawurlencode($_GET['longurl']);
    $urlS = "shorten";
}else {
    $urlName = rawurlencode($_GET['shorturl']);
    $urlS = "expand";
}

$url = 'https://api-ssl.bitly.com/v3/'.$urlS.'?access_token=b0023184f8bca0f0f5f302fe71909f27de077ab6&'.$urlType.'='.$urlName;

// Display errors
ini_set('display_errors',1);
header('Content-Type:application/json; charset=utf-8');
// Set up options
$toSet[CURLOPT_CONNECTTIMEOUT] = 20; // Time to wait for connection
$toSet[CURLOPT_TIMEOUT] = 45; // Time to wait for whole operation
$toSet[CURLOPT_RETURNTRANSFER] = true; // Return transfer instead of printing
$toSet[CURLOPT_FAILONERROR] = true;

// Forward the custom headers
if ( isset($_SERVER['HTTP_USER_AGENT']) ) $toSet[CURLOPT_USERAGENT] = $_SERVER['HTTP_USER_AGENT'];

// Show SSL without verifying
$toSet[CURLOPT_SSL_VERIFYPEER] = false;
$toSet[CURLOPT_SSL_VERIFYHOST] = false;

// Start curl
$curl = curl_init($url);

// Load options
curl_setopt_array($curl, $toSet);

// Fetch page
$return = curl_exec($curl);

// Check for curl errors
if ( $error = curl_error($curl) ) 
 echo 'ERROR: ',$error;

// Close handle
curl_close($curl);

echo str_replace('\/','/',$return);


?>
