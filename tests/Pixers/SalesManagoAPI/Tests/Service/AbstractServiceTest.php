<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use PHPUnit\Framework\TestCase;
use Pixers\SalesManagoAPI\Client;
use Pixers\SalesManagoAPI\Service\ContactService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
abstract class AbstractServiceTest extends TestCase
{
    const CONTACT_TEST_PHONE = '123456789';
    const CONTACT_TEST_PHONE_NEW = '987654321';
    const CONTACT_TEST_FAX = '000000000';
    const CONTACT_TEST_FAX_NEW = '999999999';

    /**
     * @var array
     */
    protected static $config;

    /**
     * @var Client
     */
    protected static $salesManagoClient;

    /**
     * @var ContactService
     */
    protected static $contactService;

    public static function setUpBeforeClass()
    {
        self::$config = self::getConfig();

        self::$salesManagoClient = new Client(
            self::$config['clientId'],
            self::$config['endPoint'],
            self::$config['apiSecret'],
            self::$config['apiKey']
        );

        self::$contactService = new ContactService(self::$salesManagoClient);
    }

    /**
     * Returns config.
     *  
     * @return array
     */
    protected static function getConfig()
    {
        return [
            'owner' => $GLOBALS['SALESMANAGO_OWNER'],
            'clientId' => $GLOBALS['SALESMANAGO_CLIENT_ID'],
            'clientEmail' => $GLOBALS['SALESMANAGO_CLIENT_EMAIL'],
            'clientPassword' => $GLOBALS['SALESMANAGO_CLIENT_PASSWORD'],
            'endPoint' => $GLOBALS['SALESMANAGO_END_POINT'],
            'apiSecret' => $GLOBALS['SALESMANAGO_API_SECRET'],
            'apiKey' => $GLOBALS['SALESMANAGO_API_KEY'],
            'emailId' => $GLOBALS['SALESMANAGO_EMAIL_ID'],
            'contactEmail' => $GLOBALS['SALESMANAGO_CONTACT_EMAIL'],
            'isPartner' => $GLOBALS['SALESMANAGO_IS_PARTNER']
        ];
    }

    /**
     * Create contact.
     *
     * @return object
     */
    protected static function createContact()
    {
        $data = [
            'contact' => [
                'company' => 'Test',
                'email' => self::$config['contactEmail'],
                'fax' => self::CONTACT_TEST_FAX,
                'name' => 'John Example',
                'phone' => self::CONTACT_TEST_PHONE
            ],
            'tags' => ['TAG_1', 'TAG_2', 'TAG_3']
        ];

        return self::$contactService->create(self::$config['owner'], $data);
    }

    /**
     * Remove contact.
     *
     * @return object
     */
    protected static function removeContact()
    {
        $data = [
            'permanently' => true
        ];

        return self::$contactService->delete(self::$config['owner'], self::$config['contactEmail'], $data);
    }
}
