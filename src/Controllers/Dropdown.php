<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use Slim\Routing\RouteContext;

final class Dropdown extends Common
{
  public function getAll(Request $request, Response $response, $args): Response
  {
    $data = json_decode($request->getBody());
    // POST
    // itemtype
    // filter
    // entity_restrict
    // page (option)

    // GLPI values
    // itemtype "ITILCategory"
    // display_emptychoice  "1"
    // emptylabel "-----"
    // condition  "fc20cd4dd8f56c07f744c2684be72be48c64dc53"
    // entity_restrict  "0"
    // permit_select_parent "0"
    // _idor_toke "5e4a3ab5e4137a71daccbaf311c2ad8f0cdccaefc09cbd0d363efd70cfebbc58"
    // page_limit "100"
    // page "1"

    // response format - JSON
    //   {
    //     "success": true,
    //     "results": [
    //       {
    //         // name displayed in dropdown
    //         "name"  : "Choice 1",
    //          // selected value
    //         "value" : "value1",
    //          // name displayed after selection (optional)
    //         "text"  : "Choice 1"
    //          // whether field should be displayed as disabled (optional)
    //         "disabled"  : false
    //        },
    //       {
    //         "name"  : "Choice 2",
    //         "value" : "value2",
    //         "text"  : "Choice 2"
    //       }
    //     ]
    // }

    $dropData = [];
    $success = false;

    if (property_exists($data, 'itemtype') && class_exists($data->itemtype))
    {
      $item = new $data->itemtype();
      $dropData = $item->getDropdownValues();
      $success = true;
    } else {
      $dropData = [];
      $success = false;
    }

    $respdata = [
      "success" => $success,
      "results" => $dropData,
    ];

    $response->getBody()->write(json_encode($respdata));
    return $response->withHeader('Content-Type', 'application/json');
  }
}
