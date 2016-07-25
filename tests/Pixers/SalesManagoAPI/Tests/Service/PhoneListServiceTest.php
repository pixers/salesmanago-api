<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use Pixers\SalesManagoAPI\Service\PhoneListService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class PhoneListServiceTest extends AbstractServiceTest
{
    /**
     * @var PhoneListService
     */
    protected static $phoneListService;

    /**
     * Setup phone list service.
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$phoneListService = new PhoneListService(self::$salesManagoClient);

        self::createContact();
    }

    /**
     * @return string
     */
    public function testAdd()
    {
        $response = self::$phoneListService->add(self::$config['contactEmail']);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('contactId', $response);
        $this->assertInternalType('string', $response->contactId);
        $this->assertNotEmpty($response->contactId);

        return $response->contactId;
    }

    /**
     * @depends testAdd
     *
     * @param string $contactId
     */
    public function testRemove($contactId)
    {
        $response = self::$phoneListService->remove(self::$config['contactEmail']);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('contactId', $response);
        $this->assertInternalType('string', $response->contactId);
        $this->assertEquals($contactId, $response->contactId);
        $this->assertNotEmpty($response->contactId);
    }

    /**
     * Removing contact.
     */
    public static function tearDownAfterClass()
    {
        self::removeContact();
    }
}
