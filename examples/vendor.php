<?php
require_once(__DIR__ . '/../vendor/autoload.php');

use CodeLine\MacLookup\Builders\ClientBuilder;


$builder = new ClientBuilder();

$client = $builder->build(getenv("API_KEY"));

$vendorName = $client->getVendorName('18810E');

echo $vendorName . PHP_EOL;
