<?php
require_once(__DIR__ . '/../vendor/autoload.php');

use CodeLine\MacLookup\Builders\ClientBuilder;


$builder = new ClientBuilder();

$client = $builder->build(getenv("API_KEY"));

$data = $client->getRawData('18810E', 'csv');

file_put_contents('18810E.csv', $data);