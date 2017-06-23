<?php
// Initialize Composer Libraries
require_once "vendor/autoload.php";
use Industrialdev\Eventbrite\Eventbrite;

// Creates Eventbrite SDK instance
$eb = new Eventbrite(getenv('EVENTBRITE_TOKEN'));

$events = $eb->get_events('me');

