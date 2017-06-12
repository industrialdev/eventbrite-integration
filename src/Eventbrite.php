<?php

/**
 * @file
 * A lightweight wrapper for the Eventbrite API.
 */
namespace Industrialdev\Eventbrite;

use Dotenv\Dotenv;
use Exception;
use jamiehollern\eventbrite\Eventbrite as EBApi;


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

    public function __construct()
    {
        $this->client = new EBApi(getenv('EVENTBRITE_TOKEN'));
        $this->token  = getenv('EVENTBRITE_TOKEN');
    }

    public function get_event(string $event_id): array
    {
        return $this->client->get(sprintf('events/%s/', $event_id));
    }

    public function get_events(string $user_id): array
    {
        return $this->client->get(sprintf('users/%s/events/', $user_id), ['status' => 'live']);
    }

    public function get_owned_events(string $user_id = 'me'): array
    {
        return $this->client->get(sprintf('users/%s/owned_events/', $user_id), ['status' => 'live']);
    }

    public function get_orders(string $user_id): array
    {
        return $this->client->get(sprintf('users/%s/orders/', $user_id));
    }

    public function get_access_codes(string $event_id): array
    {
        return $this->client->get(sprintf('events/%s/access_codes/',$event_id));
    }

    public function create_access_code(string $event_id, string $ticket_id, $opts = []): array
    {
        $default = [
            'access_code.code'               => 'CODE'.mt_rand(0, 100), // Actual access code
            'access_code.ticket_ids'         => [$ticket_id], // Ticket Type
            'access_code.quantity_available' => 1, // Number of uses.
        ];
        // Allows users to pass in an array of options and override defaults
        $options = array_merge($default, $opts);

        $endpoint = sprintf('https://www.eventbriteapi.com/v3/events/%s/access_codes?token=%s', $event_id, getenv('EVENTBRITE_TOKEN'));

        $response = $this->client->post($endpoint, [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($options)
        ]);

        // return $this->client->post(sprintf('events/%s/access_codes/', $event_id), $options);
        return $response;
    }

    public function get_event_urls(string $event_id): array
    {
        $event = $this->get_event($event_id);
        $codes = $this->get_access_codes($event_id);
        $roles = $this->get_roles();

        $url   = $event['body']['url'];
        $title = $event['body']['name']['html'];

        $urls = [];
        if(!empty($codes)) {
            foreach($codes['body']['access_codes'] as $key=>$code) {
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
