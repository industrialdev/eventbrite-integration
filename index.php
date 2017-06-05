<?php
require_once "vendor/autoload.php";

use jamiehollern\eventbrite\Eventbrite;

$eventbrite = new Eventbrite('S5BPGHXXE2M4FK3JKJPY');
$events = $eventbrite->get('');

print $eventbrite->canConnect();

