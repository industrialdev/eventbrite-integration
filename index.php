<?php
// Initialize Composer Libraries
require_once "vendor/autoload.php";
use Industrialdev\Eventbrite\Eventbrite;
$eb = new Eventbrite();

// Sets up twig templates for easier testing
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader);

$events = $eb->get_event_urls('35146505143');
echo $twig->render('index.twig', ['events' => $events]);
