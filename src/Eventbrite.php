<?php

/**
 * @file
 * A lightweight wrapper for the Eventbrite API.
 */
namespace Industrialdev\Eventbrite;

use Dotenv\Dotenv;
use Exception;

// Import Eventbrite SDK
require_once "vendor/eventbrite/eventbrite-sdk-php/HttpClient.php";

// Set up ENV vars
$realpath = realpath(__DIR__ . '/..');
$dotenv = new Dotenv($realpath);
$dotenv->load();
$dotenv->required(['API_APP_KEY', 'API_JWT_SECRET', 'PERSON_ID', 'EVENTBRITE_TOKEN']);

/**
 * Class Eventbrite
 *
 * @package Industrialdev\Eventbrite
 */
class Eventbrite
{

    const TEST_EVENT_ID = '35146505143';

    public function eb_client()
    {
        return $this->eb_client = new \HttpClient(getenv('EVENTBRITE_TOKEN'));
    }

    public function wicket_client()
    {
        return $this->wicket_client = new Wicket\Client(
            getenv('API_APP_KEY'),
            getenv('API_JWT_SECRET'),
            'https://api.wicket.io'
        );
        $wicket = self::wicket_client();
        $wicket->authorize(getenv('PERSON_ID'));
    }

    public function get_event(string $event_id): array
    {
        $client = self::eb_client();
        return $client->get_event($event_id);
    }

    public function get_access_codes(string $event_id): array
    {
        $client = self::eb_client();
        return $client->get_event_access_codes($event_id);
    }

    public function create_access_codes(string $event_id, array $ticket_id, array $opts): array
    {
        $opts = [
            'access_code.code'               => 'CODE'.mt_rand(0, 100), // Actual access code
            'access_code.ticket_ids'         => $ticket_id, // Ticket Type
            'access_code.quantity_available' => 1, // Number of uses.
        ];

        $client = self::eb_client();
        return $client->post_event_access_codes($event_id, $opts);
    }

    public function create_event_url($event_id, $access_code): array
    {
        $event = self::get_event($event_id);
        $codes = self::get_access_codes($event_id);

        $url = $event['url'];

        $urls = [];
        if(!empty($codes)) {
            foreach($codes['access_codes'] as $code) {
                $urls[] = "${url}?discount=${code['code']}#tickets";
            }
        }
        return $urls;
    }

    public function get_wicket_roles() {
        $wicket = self::wicket_client();
        $wicket->authorize(getenv('PERSON_ID'));
    }

    public function get_mapped_roles()
    {
        // Map of roles
        $roles = [];
    }

}
