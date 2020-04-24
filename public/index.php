<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$rootPath = realpath(__DIR__ . '/..');
include_once  $rootPath . '/src/model/Repository.php';
include_once  $rootPath . '/src/middleware/JsonBodyParserMiddleware.php';
include_once $rootPath . '/src/utils/settings.php';
require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->add(JsonBodyParserMiddleware::class);

$mproxy = new Repository($settings);

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write('Hello world');
    return $response;
});
$app->get('/filter/{providerId}', function (Request $request, Response $response, $args) use ($mproxy) {
    $params = $request->getQueryParams();
    $resp = $mproxy->filterRecord($args, $params);
    $response->getBody()->write(json_encode($resp));
    return $response;
});
$app->post('/register', function (Request $request, Response $response, $args) use ($mproxy) {
    $parsedBody = $request->getParsedBody();
    $jsonResponse = $mproxy->registerUser($parsedBody);
    $response->getBody()->write(json_encode($jsonResponse));
    return $response;
});

$app->run();
