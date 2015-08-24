# SalesManago API Client

Implementation of SalesManago API version `1.42`.
For more details about the API go to [SalesManago site].

## Installation

Install the package through composer::

```
php composer.phar require pixers/salesmanago-api:dev-master
```

## Usage

API Client is divided into several sub-services, responsible for particular resources (e.g. Contacts, Events):

* [ContactService](src/Pixers/SalesManagoAPI/Service/ContactService.php)
    * ContactService::create($owner, $data)
    * ContactService::update($owner, $email, $data)
    * ContactService::delete($owner, $email, $data)
    * ContactService::has($owner, $email)
    * ContactService::listByEmails($owner, $data)
    * ContactService::listByIds($owner, $data)
    * ContactService::listRecentlyModified($owner, $data)
    * ContactService::listRecentActivity($data)
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
use Pixers\SalesManagoAPI\Service\ContactService;
use Pixers\SalesManagoAPI\Service\EventService;

// First - initialize configured client
$client = new Client($clientId, $endpoint, $apiSecret, $apiKey);

// Now you can use specific services
$contactService = new ContactService($client);
$contactResponse = $contactService->delete($owner, $email, $data);

$eventService = new EventService($client);
$eventResponse = $eventService->delete($owner, $eventId);
```

### Examples

For some in-code examples, visit [examples](examples/) directory.

## Authors

* Sylwester Łuczak <sylwester.luczak@pixers.pl>
* Antoni Orfin <antoni.orfin@pixers.pl>

## License

Copyright 2015 PIXERS Ltd - www.pixersize.com

Licensed under the [BSD 3-Clause](LICENSE)

[SalesManago site]:http://www.salesmanago.pl/marketing-automation/developers.htm