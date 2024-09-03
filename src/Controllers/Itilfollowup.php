<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class Itilfollowup extends Common
{

  public function postItem(Request $request, Response $response, $args): Response
  {
    $data = (object) $request->getParsedBody();
    $item = new \App\Models\Itilfollowup();
    $item->itemtype = 'Ticket';
    $item->items_id = 8;
    $item->content = $data->followup;
    $item->is_private = $data->private;
    
    $item->save();

    // add message to session
    $session = new \SlimSession\Helper();
    $session->message = "The followup has been added correctly";

    $response = $response->withStatus(302);
    return $response->withHeader('Location', '/tickets/8');
  }
}
