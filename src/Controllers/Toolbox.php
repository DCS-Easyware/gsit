<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

final class Toolbox
{

  /**
   * Clean integer string value (strip all chars not - and spaces )
   *
   * @since versin 0.83.5
   *
   * @param string  $integer  integer string
   *
   * @return string  clean integer
   **/
  static function cleanInteger($integer)
  {
    return preg_replace("/[^0-9-]/", "", $integer);
  }

  static function getRootPath(Request $request)
  {
    $routeContext = RouteContext::fromRequest($request);
    return $routeContext->getBasePath();
  }
}
