<?php
// Initialize Composer Libraries
require_once "vendor/autoload.php";
use Industrialdev\Eventbrite\Eventbrite;

$eb = new Eventbrite();

$events = $eb->get_event('35146505143');
d($events);
