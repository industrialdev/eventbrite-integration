<?php
// Initialize Composer Libraries
require_once "vendor/autoload.php";
use Industrialdev\Eventbrite\Eventbrite;

// Sets up twig templates for easier testing
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader);

$eb = new Eventbrite();
$events = $eb->get_events('me');
$event_data = $events['body']['events'];

echo $twig->render('index.twig', ['events' => $event_data]);
