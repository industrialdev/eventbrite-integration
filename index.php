<?php
// Initialize Composer Libraries
require_once "vendor/autoload.php";
// Require EventBrite SDK (not Composer-friendly =\);
require_once "vendor/eventbrite/eventbrite-sdk-php/HttpClient.php";
// Simple custom Guzzle Wrapper for the EventBrite API
// use Industrialdev\Eventbrite\Eventbrite;

// Test Data
$token = 'S5BPGHXXE2M4FK3JKJPY';
$test_event_id = '35146505143';

$client = new HttpClient($token);

// Map of roles
$roles = [];

// Event Data
$event = $client->get_event($test_event_id);
d($event);

// Access Codes
$access_codes = $client->get_event_access_codes($test_event_id);
d($access_codes);
