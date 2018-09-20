<?php
require_once(__DIR__ . '/../vendor/autoload.php');

use CodeLine\MacLookup\Builders\ClientBuilder;


$builder = new ClientBuilder();

$client = $builder->build(getenv("API_KEY"));

$response = $client->get('18810E');

echo "Vendor info: " . PHP_EOL;
echo " Name: " . $response->vendorDetails->companyName . PHP_EOL;
echo " Address: " . $response->vendorDetails->companyAddress . PHP_EOL;