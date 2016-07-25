<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use Pixers\SalesManagoAPI\Service\EmailService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class EmailServiceTest extends AbstractServiceTest
{
    /**
     * @var EmailService
     */
    protected static $emailService;

    /**
     * Setup email service.
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$emailService = new EmailService(self::$salesManagoClient);
    }

    public function testCreate()
    {
        $data = [
            'user' => self::$config['owner'],
            'immediate' => true,
            'emailId' => self::$config['emailId'],
            'contacts' => [
                [
                    'email' => self::$config['contactEmail'],
                ]
            ],
            'date' => date('c', time()),
        ];

        $response = self::$emailService->create($data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertInternalType('boolean', $response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertInternalType('array', $response->message);

        $this->assertObjectHasAttribute('conversationId', $response);
        $this->assertInternalType('string', $response->conversationId);
        $this->assertNotEmpty($response->conversationId);
    }
}
