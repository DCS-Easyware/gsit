<?php

use Slim\Factory\AppFactory;
use Symfony\Component\ErrorHandler\ErrorHandler as SymfonyErrorHandler;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

require __DIR__ . '/../vendor/autoload.php';
include('../config/config_db.php');
$DB = new DB();
// Load lang
$lang = new \App\Translation();
$translator = $lang->loadLanguage();

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->setBasePath('/gsit');

// See https://github.com/tuupola/slim-jwt-auth
$container = $app->getContainer();

$container["jwt"] = function ($container)
{
  return new StdClass();
};

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

$secret = sodium_base642bin('TEST', SODIUM_BASE64_VARIANT_ORIGINAL);

$app->add(new Tuupola\Middleware\JwtAuthentication([
  "ignore" => [
    $prefix . "/gsit/ping",
    $prefix . "/gsit/login"
  ],
  "secure" => false,
  "secret" => $secret,
  "before" => function ($request, $arguments)
  {
    $myUser = \App\Models\User::find($arguments['decoded']['user_id']);
    // $jwtid = $myUser->getPropertyAttribute('userjwtid');
    // if (is_null($jwtid) || $jwtid != $arguments['decoded']['jti'])
    // {
    //   throw new Exception('jti changed, ask for a new token ' . $myUser['jwtid'] . ' != ' .
    //                       $arguments['decoded']['jti'], 401);
    // }
    $GLOBALS['user_id'] = $arguments['decoded']['user_id'];
    // Load permissions
    // $GLOBALS['permissions'] = \App\v1\Controllers\Config\Role::generatePermission(
    //   $arguments['decoded']['role_id']
    // );
  },
  "error" => function ($response, $arguments)
  {
    $GLOBALS['user_id'] = null;
    // for web, redirect to login page
    header('Location: /gsit/login');
    exit();

    // for API
    throw new Exception($arguments["message"], 401);
  }
]));


$capsule = new Capsule();
$configdb = [
  'driver' => 'mysql',
  'host' => $DB->dbhost,
  'database' => $DB->dbdefault,
  'username' => $DB->dbuser,
  'password' => $DB->dbpassword,
  'charset' => 'utf8',
  'collation' => 'utf8_unicode_ci',
];
$capsule->addConnection($configdb);
$capsule->setEventDispatcher(new Dispatcher(new Container()));
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Init session
$app->add(
  new \Slim\Middleware\Session([
    'name' => 'gsit_session',
    'autorefresh' => true,
    'lifetime' => '1 hour',
  ])
);

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
