<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use Pixers\SalesManagoAPI\Service\TaskService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class TaskServiceTest extends AbstractServiceTest
{
    const TEST_NOTE = 'Call to client.';
    const TEST_NOTE_NEW = 'Call to client - its very important.';
    const TEST_REMINDER = '_15_MIN';
    const TEST_REMINDER_NEW = '_30_MIN';

    /**
     * @var PhoneListService
     */
    protected static $taskService;

    /**
     * Setup task service.
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$taskService = new TaskService(self::$salesManagoClient);

        self::createContact();
    }

    /**
     * @return string
     */
    public function testCreate()
    {
        $data = [
            'smContactTaskReq' => [
                'note' => self::TEST_NOTE,
                'date' => date('c', time()),
                'cc' => self::$config['owner'],
                'reminder' => self::TEST_REMINDER
            ]
        ];

        $response = self::$taskService->create($data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('taskId', $response);
        $this->assertInternalType('string', $response->taskId);
        $this->assertNotEmpty($response->taskId);

        return $response->taskId;
    }
    
    /**
     * @depends testCreate
     *
     * @param string $taskId
     */
    public function testUpdate($taskId)
    {
        $data = [
            'smContactTaskReq' => [
                'id' => $taskId,
                'note' => self::TEST_NOTE_NEW,
                'date' => date('c', time()),
                'reminder' => self::TEST_REMINDER_NEW
            ]
        ];

        $response = self::$taskService->update($taskId, $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('taskId', $response);
        $this->assertInternalType('string', $response->taskId);
        $this->assertNotEmpty($response->taskId);
        $this->assertEquals($taskId, $response->taskId);

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
        $this->assertObjectHasAttribute('contactTasks', $contactData);
        $this->assertInternalType('array', $contactData->contactTasks);
        $this->assertNotEmpty($contactData->contactTasks);

        $contactTask = $contactData->contactTasks[0];

        $this->assertInstanceOf(\stdClass::class, $contactTask);

        $this->assertObjectHasAttribute('id', $contactTask);
        $this->assertInternalType('string', $contactTask->id);
        $this->assertEquals($taskId, $contactTask->id);

        $this->assertObjectHasAttribute('note', $contactTask);
        $this->assertInternalType('string', $contactTask->note);
        $this->assertEquals(self::TEST_NOTE_NEW, $contactTask->note);

        $this->assertObjectHasAttribute('date', $contactTask);
        $this->assertInternalType('float', $contactTask->date);

        $this->assertObjectHasAttribute('cc', $contactTask);
        $this->assertInternalType('string', $contactTask->cc);

        $this->assertObjectHasAttribute('reminder', $contactTask);
        $this->assertInternalType('float', $contactTask->reminder);
        $this->assertEquals(self::TEST_REMINDER_NEW, $contactTask->reminder);

        return $response->taskId;
    }

    /**
     * @depends testUpdate
     *
     * @param  string $taskId
     */
    public function testDelete($taskId)
    {
        $response = self::$taskService->delete($taskId);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('taskId', $response);
        $this->assertInternalType('string', $response->taskId);
        $this->assertNotEmpty($response->taskId);
        $this->assertEquals($taskId, $response->taskId);
    }

    /**
     * Removing contact.
     */
    public static function tearDownAfterClass()
    {
        self::removeContact();
    }
}
