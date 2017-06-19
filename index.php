<?php
// Initialize Composer Libraries
require_once "vendor/autoload.php";
use Industrialdev\Eventbrite\Eventbrite;

// Creates Eventbrite SDK instance
$eb = new Eventbrite(getenv('EVENTBRITE_TOKEN'));

$code          = $_GET['code'];
$client_key    = getenv('CLIENT_KEY');
$client_secret = getenv('CLIENT_SECRET');
$app_key       = getenv('APP_KEY');

// Asks for user permission
if(empty($code)) {
    $auth_url = $eb->createAuthorizeUrl($client_key);
    Header("Location: ${auth_url}");
}
// Authorize and get the access token
else {
    $oauth = $eb->authorize($code, $client_secret, $client_key);
    // Authorization: Bearer ${token}
    d($oauth);
}

