<?php
// Initialize Composer Libraries
require_once "vendor/autoload.php";
use Industrialdev\Eventbrite\Eventbrite;
$eb = new Eventbrite();

// Sets up twig templates for easier testing
// $loader = new Twig_Loader_Filesystem('./templates');
// $twig = new Twig_Environment($loader);

// $events = $eb->get_event_urls(getenv('TEST_EVENT_ID'));
$events = $eb->get_events_by_role();
// $events = $eb->get_event(getenv('TEST_EVENT_ID'));
d($events);
// echo $twig->render('index.twig', ['events' => $events]);
