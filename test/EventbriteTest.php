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
        $this->eb = new Eventbrite();
        $this->client = $this->eb->eb_client(getenv('EVENTBRITE_TOKEN'));
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
        $access_codes = $this->eb->create_access_code(getenv('TEST_EVENT_ID'), [getenv('TEST_TICKET_ID')]);
        $this->assertNotEmpty($access_codes['id']);
        $this->assertInternalType('array', $access_codes);

        $this->client->delete(sprintf('/events/%s/access_code/%s/', getenv('TEST_EVENT_ID'), $access_codes['id']));
    }

    public function testEventUrlsAreReturned()
    {
        $urls = $this->eb->get_event_urls(getenv('TEST_EVENT_ID'));
        $this->assertNotEmpty($urls);
    }


}
