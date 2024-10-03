<?php

namespace App\v1\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class Followup extends Common
{
  public function postItem(Request $request, Response $response, $args): Response
  {
    $data = (object) $request->getParsedBody();
    // TODO if not have $data->followup, error


    $item = new \App\Models\Followup();
    $item->itemtype = 'Ticket';
    $item->items_id = 8;
    $item->content = $data->followup;
    $item->is_private = $data->private;
    $item->users_id = $GLOBALS['user_id'];

    $item->save();

    // add message to session
    $session = new \SlimSession\Helper();
    $session->message = "The followup has been added correctly";

    header('Location: /gsit/tickets/8');
    exit();
  }
}
