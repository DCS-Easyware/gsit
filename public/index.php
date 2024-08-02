<?php

use Slim\Factory\AppFactory;
use Symfony\Component\ErrorHandler\ErrorHandler as SymfonyErrorHandler;

require __DIR__ . '/../vendor/autoload.php';
include('../config/config_db.php');
$DB = new DB();
// Load lang
$lang = new \App\Translation();
$translator = $lang->loadLanguage();

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->setBasePath('/gsit');

$prefix = "";
if (strstr($_SERVER['REQUEST_URI'], 'index.php'))
{
  $uri_spl = explode('index.php', $_SERVER['REQUEST_URI']);
  $prefix = $uri_spl[0] . "index.php";
}
if (strstr($_SERVER['REQUEST_URI'], '/'))
{
  $uri_spl = explode('/', $_SERVER['REQUEST_URI']);
  $prefix = $uri_spl[0];
}

// $app->get('/', function (Request $request, Response $response, $args) {
//     $response->getBody()->write("Hello world!");
//     return $response;
// });


// $app->get('/hello', function ($request, $response) {
// })->setName('profile');

// Define routes
\App\Route::setRoutes($app, $prefix);

// Define Custom Error Handler
$customErrorHandler = function (
  Request $request,
  Throwable $exception,
  bool $displayErrorDetails,
  bool $logErrors,
  bool $logErrorDetails
) use ($app)
{
  // TODO write error page

};

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
// $errorMiddleware->setDefaultErrorHandler($customErrorHandler);

// get php errors (warning...)
SymfonyErrorHandler::register();

$app->run();
