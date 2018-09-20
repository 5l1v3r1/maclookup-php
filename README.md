# Description

PHP library for MAC Vendor Lookup API by [macaddress.io](https://macaddress.io/)

# Installation

You can install the library via [Composer](https://getcomposer.org/)

```bash
composer require codelinefi/mac-lookup
```

To use the library, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading)

```php
require_once('vendor/autoload');
```


# Requirements

### Supported PHP versions:

* PHP 5.5.x
* PHP 5.6.x
* PHP 7.0.x
* PHP 7.1.x
* PHP 7.2.x

### Dependencies:

* mbstring
* mbregex
* json
* curl

# Documentation

Full API documentation is available [here](https://macaddress.io/api-documentation)

## Getting started

### Basic usage

```php
<?php

use CodeLine\MacLookup\Builders\ClientBuilder;

$builder = new ClientBuilder();
$client = $builder->build('Your API key');

echo $client->get('F041C81')->blockDetails->dateUpdated . PHP_EOL;
echo $client->getRawData('18810E') . PHP_EOL;
echo $client->getVendorName('F041C81') . PHP_EOL;
```
### Advanced usage

```php
<?php

use CodeLine\MacLookup\Builders\ResponseModelBuilder;
use CodeLine\MacLookup\Clients\GuzzleClient;
use CodeLine\MacLookup\ApiClient;
use \GuzzleHttp\Client;

$requestor = new GuzzleClient(new Client());
$builder = new ResponseModelBuilder('');
$client = new ApiClient($requestor, $builder, 'Your API key');

echo $client->get('18810E')->vendorDetails->companyName . PHP_EOL;
echo $client->getRawData('18810E') . PHP_EOL;
echo $client->getVendorName('18810E') . PHP_EOL;
```

**Be careful! This library uses trigger_error function with E_USER_DEPRECATED 
constant to inform you about API updates** 

## Examples

You may find some examples in the example directory. To run these examples 
execute the following commands:

```bash
export API_KEY="<Your api key>"
php vendor.php
php basic.php
```

## Classes

### ApiClient class

```php
/**
 * ApiClient constructor.
 * @param \CodeLine\MacLookup\Clients\ClientInterface $client
 * @param \CodeLine\MacLookup\Builders\ResponseModelBuilderInterface $builder
 * @param string $apiKey Your API key
 * @param string $url API base URl
*/
public function __construct(
    ClientInterface $client,
    ResponseModelBuilderInterface $builder,
    $apiKey,
    $url = ""
)

/**
 * @param string $url API base URl
 */
public function setBaseUrl($url);

/**
 * @param string $apiKey Your API key
 */
public function setApiKey($apiKey);

/**
 * @param string $mac Mac address or OUI
 * @return \CodeLine\MacLookup\Models\Response
 * @throws EmptyResponseException
 * @throws ServerErrorException
 * @throws UnknownOutputFormatException
 * @throws AuthorizationRequiredException
 * @throws NotEnoughCreditsException
 * @throws AccessDeniedException
 * @throws InvalidMacOrOUIException
 */
public function get($mac);

/**
 * @param string $mac Mac address or OUI
 * @param string $format Supported formats json/xml/csv/vendor
 * @return string
 * @throws EmptyResponseException
 * @throws ServerErrorException
 * @throws UnknownOutputFormatException
 * @throws AuthorizationRequiredException
 * @throws NotEnoughCreditsException
 * @throws AccessDeniedException
 * @throws InvalidMacOrOUIException
 */
public function getRawData($mac, $format = 'json');

/**
 * @param string $mac Mac address or OUI
 * @return string
 * @throws ServerErrorException
 * @throws UnknownOutputFormatException
 * @throws AuthorizationRequiredException
 * @throws NotEnoughCreditsException
 * @throws AccessDeniedException
 * @throws InvalidMacOrOUIException
*/
public function getVendorName($mac);
```

### Models

namespace CodeLine\MacLookup\Models

#### Response

```php
/**
 * @var VendorDetails
 */
public $vendorDetails;

/**
 * @var BlockDetails
 */
public $blockDetails;

/**
 * @var MacAddressDetails
 */
public $macAddressDetails;
```

#### VendorDetails

```php
/**
 * @var string
 */
public $oui;

/**
 * @var boolean
 */
public $isPrivate;

/**
 * @var string
 */
public $companyName;

/**
 * @var string
 */
public $companyAddress;

/**
 * @var string
 */
public $countryCode;
```

#### BlockDetails

```php
/**
 * @var boolean
 */
public $blockFound;

/**
 * @var string
 */
public $borderLeft;

/**
 * @var string
 */
public $borderRight;

/**
 * @var int|float
 */
public $blockSize;

/**
 * @var string
 */
public $assignmentBlockSize;

/**
 * @var \DateTimeInterface
 */
public $dateCreated;

/**
 * @var \DateTimeInterface
 */
public $dateUpdated;
```

#### MacAddressDetails

```php
/**
 * @var string
 */
public $searchTerm;

/**
 * @var boolean
 */
public $isValid;

/**
 * @var string
 */
public $transmissionType;

/**
 * @var string
 */
public $administrationType;
```

### ClientBuilder

namespace \CodeLine\MacLookup\Builders

```php
/**
 * @param string $apiKey
 * @param string $url
 * @return \CodeLine\MacLookup\ApiClient
 */
public function build($apiKey, $url = '');
```

# Development

[Install composer](https://getcomposer.org/download/)

Clone code from repository

```bash
git clone https://github.com/CodeLineFi/maclookup-php.git
```

Install dependencies

```bash
composer install
```

Running tests

```bash
./vendor/bin/phpunit --testdox tests
```