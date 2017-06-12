<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Industrialdev\Eventbrite\Eventbrite;

/**
 * @runTestsInSeparateProcesses
 */
class EventbriteTest extends TestCase
{
    public function setUp()
    {
        $this->client = new Eventbrite();
    }

    public function testClientCanBeCreated()
    {
        $this->assertNotEmpty($this->client);
    }

    /**
      * @covers Eventbrite::create_access_codes
      */
    public function testAccessCodeCanBeCreated()
    {
        $test_event   = getenv('TEST_EVENT_ID');
        $test_ticket  = getenv('TEST_TICKET_ID');
        $access_codes = $this->client->create_access_code($test_event, $test_ticket);

        $this->assertInternalType('array', $access_codes);
        $this->assertNotEmpty($access_codes['body']['id']);

        $this->client->delete(sprintf('events/%s/access_code/%s/', $test_event, $access_codes['body']['id']));
    }

    public function testEventUrlsAreReturned()
    {
        $urls = $this->client->get_event_urls(getenv('TEST_EVENT_ID'));
        $this->assertNotEmpty($urls);
    }


}
