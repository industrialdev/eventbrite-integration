<?php
// Initialize Composer Libraries
require_once "vendor/autoload.php";
use Industrialdev\Eventbrite\Eventbrite;

// Creates Eventbrite SDK instance
$eb = new Eventbrite(getenv('EVENTBRITE_TOKEN'));

$code          = $_GET('code');
$client_key    = getenv('CLIENT_KEY');
$client_secret = getenv('CLIENT_SECRET');
$app_key       = getenv('EVENTBRITE_TOKEN');

// Gets the
$auth_url = $eb->createAuthorizeUrl($client_key);

Header($auth_url);

// $oauth = $eb->authorize($code, $client_secret, $app_key);
