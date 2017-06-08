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

    public function create_access_codes(string $event_id, array $ticket_id, array $opts = []): array
    {

        $default = [
            'access_code.code'               => 'CODE'.mt_rand(0, 100), // Actual access code
            'access_code.ticket_ids'         => $ticket_id, // Ticket Type
            'access_code.quantity_available' => 1, // Number of uses.
        ];
        // Allows users to pass in an array of options and override defaults
        $options = array_merge($default, $opts);

        $client = self::eb_client();
        return $client->post_event_access_codes($event_id, $options);
    }

    public function get_event_urls(string $event_id): array
    {
        $event = self::get_event($event_id);
        $codes = self::get_access_codes($event_id);
        $roles = self::get_roles();

        $url   = $event['url'];
        $title = $event['name']['html'];

        $urls = [];
        if(!empty($codes)) {
            foreach($codes['access_codes'] as $key=>$code) {
                $access_code = $code['code'];
                $urls[$key]['url']         = "${url}?discount=${access_code}#tickets";
                $urls[$key]['title']       = $title;
                $urls[$key]['access_code'] = $access_code;
                $urls[$key]['event_url']   = $url;
            }
        }
        return $urls;
    }

    public function get_roles(): array
    {
        // Map of roles
        $roles = [
            'member',
            'communication',
            'student',
            'retired',
        ];
        return $roles;
    }

}
