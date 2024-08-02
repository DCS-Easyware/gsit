<?php

namespace App;

use Slim\Routing\RouteCollectorProxy;

final class Route
{
  public static function setRoutes(&$app, $prefix)
  {
    // Enable OPTIONS method for all routes
    $app->options($prefix . '/{routes:.+}', function ($request, $response, $args)
    {
      return $response;
    });

    // The ping - pong ;)
    // $app->get($prefix . '/ping', \App\v1\Controllers\Ping::class . ':getPing');

    $app->map(['POST'], '/dropdown', \App\Controllers\Dropdown::class . ':getAll');

    $app->group($prefix . '/computers', function (RouteCollectorProxy $computers)
    {
      $computers->map(['GET'], '', \App\Controllers\Computer::class . ':getAll');
      $computers->map(['POST'], '', \App\Controllers\Computer::class . ':postItem');
      $computers->map(['GET'], '/{id:[0-9]+}', \App\Controllers\Computer::class . ':showItem');
      $computers->map(['POST'], '/{id:[0-9]+}', \App\Controllers\Computer::class . ':updateItem');
    });

    $app->group($prefix . '/tickets', function (RouteCollectorProxy $computers)
    {
      $computers->map(['GET'], '', \App\Controllers\Ticket::class . ':getAll');
      $computers->map(['POST'], '', \App\Controllers\Ticket::class . ':postItem');
      $computers->map(['GET'], '/{id:[0-9]+}', \App\Controllers\Ticket::class . ':showItem');
      $computers->map(['POST'], '/{id:[0-9]+}', \App\Controllers\Ticket::class . ':updateItem');
    });
  }
}
