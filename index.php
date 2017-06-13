<?php
// Initialize Composer Libraries
require_once "vendor/autoload.php";
use Industrialdev\Eventbrite\Eventbrite;

// Creates Eventbrite SDK instance
$eb = new Eventbrite(getenv('EVENTBRITE_TOKEN'));

// Pulls all the events created by this user
$events = $eb->get_events('me');

// Parse the data
$event_data = $events['body']['events'];
