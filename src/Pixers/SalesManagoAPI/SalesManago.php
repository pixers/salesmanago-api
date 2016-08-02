<?php

namespace Pixers\SalesManagoAPI;

use Pixers\SalesManagoAPI\Client;
use Pixers\SalesManagoAPI\Service;

/**
 * SalesManago Services Locator.
 *
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class SalesManago
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $services;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->services = [];
    }

    /**
     * @return ContactService
     */
    public function getContactService()
    {
        return $this->getService(Service\ContactService::class);
    }

    /**
     * @return CouponService
     */
    public function getCouponService()
    {
        return $this->getService(Service\CouponService::class);
    }

    /**
     * @return EmailService
     */
    public function getEmailService()
    {
        return $this->getService(Service\EmailService::class);
    }

    /**
     * @return EventService
     */
    public function getEventService()
    {
        return $this->getService(Service\EventService::class);
    }

    /**
     * @return MailingListService
     */
    public function getMailingListService()
    {
        return $this->getService(Service\MailingListService::class);
    }

    /**
     * @return PhoneListService
     */
    public function getPhoneListService()
    {
        return $this->getService(Service\PhoneListService::class);
    }

    /**
     * @return RuleService
     */
    public function getRuleService()
    {
        return $this->getService(Service\RuleService::class);
    }

    /**
     * @return SystemService
     */
    public function getSystemService()
    {
        return $this->getService(Service\SystemService::class);
    }

    /**
     * @return TagService
     */
    public function getTagService()
    {
        return $this->getService(Service\TagService::class);
    }

    /**
     * @return TaskService
     */
    public function getTaskService()
    {
        return $this->getService(Service\TaskService::class);
    }

    /**
     * @param  string $className
     * @return mixed
     */
    public function getService($className)
    {
        if (!isset($this->services[$className])) {
            $this->services[$className] = new $className($this->client);
        }

        return $this->services[$className];
    }
}
