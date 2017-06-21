<?php

/**
 * @file
 * A lightweight wrapper for the Eventbrite API.
 */
namespace Industrialdev\Eventbrite;

use jamiehollern\eventbrite\Eventbrite as EBApi;

define("EVENTBRITE_OAUTH_BASE", "https://www.eventbrite.com/oauth/");

/**
 * Class Eventbrite
 *
 * @package Industrialdev\Eventbrite
 */
class Eventbrite
{

    public function __construct($token)
    {
        $token = getenv('EVENTBRITE_TOKEN') ?? $token;
        $this->client = new EBApi(getenv('EVENTBRITE_TOKEN'));
        $this->token  = getenv('EVENTBRITE_TOKEN');
    }

    /**
     * To authenticate a user from a server-side application,
     * first redirect them to our authorization URL:
     */
    public function createAuthorizeUrl(string $client_key): string
    {
        return EVENTBRITE_OAUTH_BASE . 'authorize?response_type=code&client_id=' . $client_key;
    }

    /**
     * The user will see an Approve/Deny page.
     * When they hit either option, they’ll be redirected back to your Redirect URI;
     * if they hit Approve, then there will be a code query parameter on the
     * end of the URL representing an access code.
     */
    public function authorize(string $code, string $client_secret, string $app_key): array
    {
        $post_args = [
            'code'          => $code,
            'client_secret' => $client_secret,
            'client_id'     => $app_key,
            'grant_type'    => 'authorization_code'
        ];

        $data = http_build_query($post_args);

        $options = [
            'http'=> [
                'method'        => 'POST',
                'header'        => "Content-type: application/x-www-form-urlencoded",
                'content'       => $data,
                'ignore_errors' => true
            ]
        ];

        $url     = EVENTBRITE_OAUTH_BASE . 'token';
        $context = stream_context_create($options);
        $result  = file_get_contents($url, false, $context);

        /**
         * This is where we will handle errors.
         * Eventbrite errors are a part of the response payload and are returned as an associative array.
         */
        return json_decode($result, true);
    }

    public function get_user_data(string $user_id = 'me'): array
    {
        return $this->client->get(sprintf('users/%s/', $user_id));
    }

    public function get_event(string $event_id): array
    {
        return $this->client->get(sprintf('events/%s/', $event_id));
    }

    public function get_events(string $user_id): array
    {
        return $this->client->get(sprintf('users/%s/events/', $user_id), ['status' => 'live']);
    }

    public function get_events_by_query(string $query): array
    {
        // XSS is handled by the API
        return $this->client->get('events/search/', ['q' => $query]);
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

        return $this->client->post(sprintf('events/%s/access_codes', $event_id), $options);
    }

    public function get_event_urls(string $event_id): array
    {
        $event = $this->get_event($event_id);
        $codes = $this->get_access_codes($event_id);

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

}
