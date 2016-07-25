<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use Pixers\SalesManagoAPI\Service\EventService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class EventServiceTest extends AbstractServiceTest
{
    const TEST_EVENT_TYPE = 'PURCHASE';
    const TEST_EVENT_TYPE_NEW = 'VISIT';
    const TEST_DETAIL_1 = 'Some event detail';
    const TEST_DETAIL_1_NEW = 'Some event detail with new data';

    /**
     * @var EventService
     */
    protected static $eventService;

    /**
     * Setup event service.
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$eventService = new EventService(self::$salesManagoClient);

        self::createContact();
    }

    /**
     * @return string
     */
    public function testCreate()
    {
        $data = [
            'contactEvent' => [
                'contactExtEventType' => self::TEST_EVENT_TYPE,
                'detail1' => self::TEST_DETAIL_1,
                'date' => date('c', time()),
            ]
        ];

        $response = self::$eventService->create(self::$config['owner'], self::$config['contactEmail'], $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('eventId', $response);
        $this->assertInternalType('string', $response->eventId);
        $this->assertNotEmpty($response->eventId);

        return $response->eventId;
    }

    /**
     * @depends testCreate
     *
     * @param  string $eventId
     * @return string
     */
    public function testUpdate($eventId)
    {
        $data = [
            'contactEvent' => [
                'contactExtEventType' => self::TEST_EVENT_TYPE_NEW,
                'detail1' => self::TEST_DETAIL_1_NEW,
                'date' => date('c', time()),
            ]
        ];

        $response = self::$eventService->update(self::$config['owner'], $eventId, $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('eventId', $response);
        $this->assertInternalType('string', $response->eventId);
        $this->assertEquals($eventId, $response->eventId);
        $this->assertNotEmpty($response->eventId);

        return $response->eventId;
    }

    /**
     * @depends testUpdate
     *
     * @param  string $eventId
     * @return string
     */
    public function testDelete($eventId)
    {
        $response = self::$eventService->delete(self::$config['owner'], $eventId);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('result', $response);
        $this->assertInternalType('string', $response->result);
        $this->assertEquals('deleted', $response->result);
    }

    /**
     * Removing contact.
     */
    public static function tearDownAfterClass()
    {
        self::removeContact();
    }
}
