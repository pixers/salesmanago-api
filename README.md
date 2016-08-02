# SalesManago API Client

Implementation of SalesManago API version `1.45`.
For more details about the API go to [SalesManago site].

## Installation

Install the package through composer.  
For the latest stable version use:

```
php composer.phar require pixers/salesmanago-api:1.1.1
```

For the latest version use:

```
php composer.phar require pixers/salesmanago-api:dev-master
```

## Usage

API Client is divided into several sub-services, responsible for particular resources (e.g. Contacts, Events):

* [ContactService](src/Pixers/SalesManagoAPI/Service/ContactService.php)
    * ContactService::create($owner, $data)
    * ContactService::update($owner, $email, $data)
    * ContactService::upsert($owner, $email, $data)
    * ContactService::delete($owner, $email, $data)
    * ContactService::has($owner, $email)
    * ContactService::useCoupon($email, $coupon)
    * ContactService::listByEmails($owner, $data)
    * ContactService::listByIds($owner, $data)
    * ContactService::listRecentlyModified($owner, $data)
    * ContactService::listRecentActivity($data)
* [CouponService](src/Pixers/SalesManagoAPI/Service/CouponService.php)
    * CouponService::create($owner, $email, $data)
* [EmailService](src/Pixers/SalesManagoAPI/Service/EmailService.php)
    * EmailService::create($data)
* [EventService](src/Pixers/SalesManagoAPI/Service/EventService.php)
    * EventService::create($owner, $email, $data)
    * EventService::update($owner, $eventId, $data)
    * EventService::delete($owner, $eventId)
* [MailingListService](src/Pixers/SalesManagoAPI/Service/MailingListService.php)
    * MailingListService::add($email)
    * MailingListService::remove($email)
* [PhoneListService](src/Pixers/SalesManagoAPI/Service/PhoneListService.php)
    * PhoneListService::add($email)
    * PhoneListService::remove($email)
* [RuleService](src/Pixers/SalesManagoAPI/Service/RuleService.php)
    * RuleService::create($owner, $data)
* [SystemService](src/Pixers/SalesManagoAPI/Service/SystemService.php)
    * SystemService::registerAccount($data)
    * SystemService::authorise($userName, $password)
* [TagService](src/Pixers/SalesManagoAPI/Service/TagService.php)
    * TagService::getAll($owner, $data)
    * TagService::modify($owner, $email, $data)
* [TaskService](src/Pixers/SalesManagoAPI/Service/TaskService.php)
    * TaskService::create($data)
    * TaskService::update($taskId, $data)
    * TaskService::delete($taskId)

### Basic usage

```php
<?php

use Pixers\SalesManagoAPI\Client;
use Pixers\SalesManagoAPI\SalesManago;

// First - initialize configured client
// endpoint - e.g. https://app3.salesmanago.pl/api/
$client = new Client($clientId, $endpoint, $apiSecret, $apiKey);

// Then - initialize SalesManago Services Locator
$salesManago = new SalesManago($client);

// Now you can use specific services
$contactResponse = $salesManago->getContactService()->delete($owner, $email, $data);

$eventResponse = $salesManago->getEventService()->delete($owner, $eventId);
```

## Tests

Create phpunit configuration in `phpunit.xml` file, based on template from [phpunit.xml.dist](phpunit.xml.dist).
After that you can run tests with:

`phpunit -c phpunit.xml`

## Authors

* Sylwester Łuczak <sylwester.luczak@pixers.pl>
* Antoni Orfin <antoni.orfin@pixers.pl>
* Michał Kanak <michal.kanak@pixers.pl>

## License

Copyright 2016 PIXERS Ltd - www.pixersize.com

Licensed under the [BSD 3-Clause](LICENSE)

[SalesManago site]:http://www.salesmanago.pl/marketing-automation/developers.htm