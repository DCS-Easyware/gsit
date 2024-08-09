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
      $computers->group("/{id:[0-9]+}", function (RouteCollectorProxy $computerId)
      {
        $computerId->map(['GET'], '', \App\Controllers\Computer::class . ':showItem');
        $computerId->map(['POST'], '', \App\Controllers\Computer::class . ':updateItem');
        $computerId->map(['GET'], '/operatingsystem', \App\Controllers\Computer::class . ':showOperatingsystem');
        $computerId->map(['GET'], '/softwares', \App\Controllers\Computer::class . ':showSoftwares');
      });
    });

    $app->group($prefix . '/softwares', function (RouteCollectorProxy $softwares)
    {
      $softwares->map(['GET'], '', \App\Controllers\Software::class . ':getAll');
      $softwares->map(['POST'], '', \App\Controllers\Software::class . ':postItem');
    });

    $app->group($prefix . '/tickets', function (RouteCollectorProxy $tickets)
    {
      $tickets->map(['GET'], '', \App\Controllers\Ticket::class . ':getAll');
      $tickets->map(['POST'], '', \App\Controllers\Ticket::class . ':postItem');

      $tickets->group("/{id:[0-9]+}", function (RouteCollectorProxy $ticketId)
      {
        $ticketId->map(['GET'], '', \App\Controllers\Ticket::class . ':showItem');
        $ticketId->map(['POST'], '', \App\Controllers\Ticket::class . ':updateItem');
      });
    });

    $app->group($prefix . '/rules', function (RouteCollectorProxy $rules)
    {
      $rules->group("/tickets", function (RouteCollectorProxy $tickets)
      {
        $tickets->map(['GET'], '', \App\Controllers\Rules\Ticket::class . ':getAll');

      });
    });
  }
}
