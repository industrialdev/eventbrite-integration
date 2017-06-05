<?php

require_once "vendor/autoload.php";

$class = new \Industrialdev\Eventbrite\EventbriteClass();

echo $class->echoPhrase("It's working");
