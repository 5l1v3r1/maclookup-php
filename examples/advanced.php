<?php
require_once(__DIR__ . '/../vendor/autoload.php');

use CodeLine\MacLookup\Builders\ResponseModelBuilder;
use CodeLine\MacLookup\ApiClient;
use CodeLine\MacLookup\Clients\GuzzleClient;
use \GuzzleHttp\Client;

$httpClient = new GuzzleClient(new Client());
$responseBuilder = new ResponseModelBuilder('');

$client = new ApiClient(
    $httpClient,
    $responseBuilder,
    getenv('API_KEY')
);

$response = null;

try {
    $response = $client->get('18810E');
} catch (\CodeLine\MacLookup\Exceptions\EmptyResponseException $e) {
    echo "Oops, the response is empty" . PHP_EOL;
} catch (\CodeLine\MacLookup\Exceptions\UnknownOutputFormatException $e) {
    echo "Error: " . $e->getCode() . " " . $e->getMessage() . PHP_EOL;
} catch (\CodeLine\MacLookup\Exceptions\AuthorizationRequiredException $e) {
    echo "Error: " . $e->getCode() . " " . $e->getMessage() . PHP_EOL;
} catch (\CodeLine\MacLookup\Exceptions\NotEnoughCreditsException $e) {
    echo "Error: " . $e->getCode() . " " . $e->getMessage() . PHP_EOL;
} catch (\CodeLine\MacLookup\Exceptions\AccessDeniedException $e) {
    echo "Error: " . $e->getCode() . " " . $e->getMessage() . PHP_EOL;
} catch (\CodeLine\MacLookup\Exceptions\UnparsableResponseException $e) {
    echo "Error: " . $e->getCode() . " " . $e->getMessage() . PHP_EOL;
} catch (\CodeLine\MacLookup\Exceptions\ServerErrorException $e) {
    echo "HTTP error code: " . $e->getCode() . PHP_EOL;
} catch (\Throwable $exception) {
    echo "Unknown error" . PHP_EOL;
}

if (!is_null($response)) {
    echo "left border: " . $response->blockDetails->borderLeft . PHP_EOL;
    echo "right border: " . $response->blockDetails->borderRight . PHP_EOL;
}
