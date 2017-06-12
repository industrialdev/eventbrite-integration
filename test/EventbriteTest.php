<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Industrialdev\Eventbrite\Eventbrite;
use jamiehollern\eventbrite\Eventbrite as EBApi;

/**
 * @runTestsInSeparateProcesses
 */
class EventbriteTest extends TestCase
{

    public function setUp()
    {
        $this->client = new Eventbrite();
        $this->ebapi = new EBApi(getenv('EVENTBRITE_TOKEN'));
        $this->test_event = getenv('TEST_EVENT_ID');
        $this->test_ticket = getenv('TEST_TICKET_ID');
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
        $access_codes = $this->client->create_access_code($this->test_event, $this->test_ticket);

        $this->assertInternalType('array', $access_codes);
        $this->assertNotEmpty($access_codes);
        $this->assertGreaterThan(0, count($access_codes['body']['access_codes']));
        $this->assertArrayHasKey('id', $access_codes['body']['access_codes'][0]);

        $this->ebapi->delete(sprintf('events/%s/access_code/%s/', $this->test_event, $access_codes['body']['access_codes'][0]['id']));
    }

    public function testEventUrlsAreReturned()
    {
        $urls = $this->client->get_event_urls($this->test_event);
        $this->assertNotEmpty($urls);
    }

}
