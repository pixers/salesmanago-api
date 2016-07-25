<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use Pixers\SalesManagoAPI\Service\ContactService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class ContactServiceTest extends AbstractServiceTest
{
    /**
     * @return string
     */
    public function testCreate()
    {
        $response = self::createContact();

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
     * @depends testCreate
     *
     * @param  string $contactId
     * @return string
     */
    public function testHas($contactId)
    {
        $response = self::$contactService->has(self::$config['owner'], self::$config['contactEmail']);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('result', $response);
        $this->assertInternalType('boolean', $response->result);
        $this->assertTrue($response->result);

        $this->assertObjectHasAttribute('contactId', $response);
        $this->assertInternalType('string', $response->contactId);
        $this->assertNotEmpty($response->contactId);
        $this->assertEquals($contactId, $response->contactId);

        return $response->contactId;
    }

    /**
     * @depends testHas
     *
     * @param  string $contactId
     */
    public function testListByEmails($contactId)
    {
        $data = [
            'email' => [
                self::$config['contactEmail'],
            ],
        ];

        $response = self::$contactService->listByEmails(self::$config['owner'], $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('contacts', $response);
        $this->assertInternalType('array', $response->contacts);
        $this->assertNotEmpty($response->contacts);
        $this->assertCount(1, $response->contacts);

        $contactData = $response->contacts[0];

        $this->assertInstanceOf(\stdClass::class, $contactData);
        $this->assertEquals($contactId, $contactData->id);
        $this->assertEquals(self::$config['contactEmail'], $contactData->email);
        $this->assertEquals(self::CONTACT_TEST_PHONE, $contactData->phone);
        $this->assertEquals(self::CONTACT_TEST_FAX, $contactData->fax);
        $this->assertEquals(self::$config['owner'], $contactData->mainContactOwner);
    }

    /**
     * @depends testHas
     *
     * @param  string $contactId
     */
    public function testListByEmailsIds($contactId)
    {
        $data = [
            'contactId' => [
                $contactId
            ]
        ];

        $response = self::$contactService->listByIds(self::$config['owner'], $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('contacts', $response);
        $this->assertInternalType('array', $response->contacts);
        $this->assertNotEmpty($response->contacts);
        $this->assertCount(1, $response->contacts);

        $contactData = $response->contacts[0];

        $this->assertInstanceOf(\stdClass::class, $contactData);
        $this->assertEquals($contactId, $contactData->id);
        $this->assertEquals(self::$config['contactEmail'], $contactData->email);
        $this->assertEquals(self::CONTACT_TEST_PHONE, $contactData->phone);
        $this->assertEquals(self::CONTACT_TEST_FAX, $contactData->fax);
        $this->assertEquals(self::$config['owner'], $contactData->mainContactOwner);
    }

    public function testListRecentActivity()
    {
        $data = [
            'from' => date('c', strtotime('-10 minutes', time())),
            'to' => date('c', time()),
            'allVisits' => false
        ];

        $response = self::$contactService->listRecentActivity($data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('recentActivity', $response);
        $this->assertInstanceOf(\stdClass::class, $response->recentActivity);
    }

    public function testListRecentlyModified()
    {
        $data = [
            'from' => date('c', strtotime('-30 minutes', time())),
            'to' => date('c', time())
        ];

        $response = self::$contactService->listRecentlyModified(self::$config['owner'], $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('modifiedContacts', $response);
        $this->assertInternalType('array', $response->modifiedContacts);

        if (!empty($response->modifiedContacts)) {
            $firstContact = $response->modifiedContacts[0];

            $this->assertInstanceOf(\stdClass::class, $firstContact);

            $this->assertObjectHasAttribute('id', $firstContact);
            $this->assertInternalType('string', $firstContact->id);

            $this->assertObjectHasAttribute('email', $firstContact);
            $this->assertInternalType('string', $firstContact->email);
        }
    }

    /**
     * @depends testHas
     *
     * @param string $contactId
     */
    public function testUpdate($contactId)
    {
        $data = [
            'contact' => [
                'phone' => self::CONTACT_TEST_PHONE_NEW,
            ]
        ];

        $response = self::$contactService->update(self::$config['owner'], self::$config['contactEmail'], $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('contactId', $response);
        $this->assertInternalType('string', $response->contactId);
        $this->assertNotEmpty($response->contactId);
        $this->assertEquals($contactId, $response->contactId);

        $data = [
            'email' => [
                self::$config['contactEmail']
            ]
        ];

        $response = self::$contactService->listByEmails(self::$config['owner'], $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('contacts', $response);
        $this->assertInternalType('array', $response->contacts);
        $this->assertNotEmpty($response->contacts);
        $this->assertCount(1, $response->contacts);

        $contactData = $response->contacts[0];

        $this->assertInstanceOf(\stdClass::class, $contactData);
        $this->assertEquals($contactId, $contactData->id);
        $this->assertEquals(self::$config['contactEmail'], $contactData->email);
        $this->assertEquals(self::$config['owner'], $contactData->mainContactOwner);
        $this->assertEquals(self::CONTACT_TEST_PHONE_NEW, $contactData->phone);
    }

    /**
     * @depends testHas
     *
     * @param string $contactId
     */
    public function testUpsert($contactId)
    {
        $data = [
            'contact' => [
                'fax' => self::CONTACT_TEST_FAX_NEW
            ]
        ];

        $response = self::$contactService->upsert(self::$config['owner'], self::$config['contactEmail'], $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('contactId', $response);
        $this->assertInternalType('string', $response->contactId);
        $this->assertNotEmpty($response->contactId);
        $this->assertEquals($contactId, $response->contactId);

        $data = [
            'contactId' => [
                $response->contactId
            ]
        ];

        $response = self::$contactService->listByIds(self::$config['owner'], $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('contacts', $response);
        $this->assertInternalType('array', $response->contacts);
        $this->assertNotEmpty($response->contacts);
        $this->assertCount(1, $response->contacts);

        $contactData = $response->contacts[0];

        $this->assertInstanceOf(\stdClass::class, $contactData);
        $this->assertEquals($contactId, $contactData->id);
        $this->assertEquals(self::$config['contactEmail'], $contactData->email);
        $this->assertEquals(self::CONTACT_TEST_PHONE_NEW, $contactData->phone);
        $this->assertEquals(self::CONTACT_TEST_FAX_NEW, $contactData->fax);
        $this->assertEquals(self::$config['owner'], $contactData->mainContactOwner);
    }

    public function testDelete()
    {
        $response = $this->removeContact();

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('result', $response);
        $this->assertNULL($response->result);

        $response = self::$contactService->has(self::$config['owner'], self::$config['contactEmail']);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('result', $response);
        $this->assertInternalType('boolean', $response->result);
        $this->assertFalse($response->result);

        $this->assertObjectHasAttribute('contactId', $response);
        $this->assertNull($response->contactId);
    }
}
