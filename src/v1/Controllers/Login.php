<?php

namespace App\v1\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

final class Login extends Common
{
  public function getLogin(Request $request, Response $response, $args): Response
  {
    $view = Twig::fromRequest($request);

    $viewData = [
      'title'    => 'GSIT - ' . 'Login page',
      'rootpath' => \App\v1\Controllers\Toolbox::getRootPath($request),
    ];

    return $view->render($response, 'login.html.twig', $viewData);
  }

  public function postLogin(Request $request, Response $response, $args): Response
  {
    $data = (object) $request->getParsedBody();
    $token = new \App\v1\Controllers\Token();

    // Validate data
    if (!property_exists($data, 'login') || !property_exists($data, 'password'))
    {
      throw new \Exception('Login error', 401);
    }

    if (gettype($data->login) != 'string' || gettype($data->password) != 'string')
    {
      throw new \Exception('Login error', 401);
    }

    // check if account exists
    $user = \App\Models\User::where('name', $data->login)->first();
    if (is_null($user))
    {
      throw new \Exception('Login error', 401);
    }
    // check passwords
    $check = $token->checkPassword($data->password, $user->password);
    if (!$check)
    {
      throw new \Exception('Login error', 401);
    }

    // generate token
    // put into cookie, key token

    $jwt = $token->generateJWTToken($user);

    // Set Cookie
    // $cookie_lifetime = empty($cookie_value) ? time() - 3600 : time() + $CFG_GLPI['login_remember_time'];
    // $cookie_path     = ini_get('session.cookie_path');
    // $cookie_domain   = ini_get('session.cookie_domain');
    // $cookie_secure   = (bool)ini_get('session.cookie_secure');

    setcookie('token', $jwt['token']);//, $cookie_lifetime, $cookie_path, $cookie_domain, $cookie_secure, true);

    header('Location: /gsit/computers');
    exit();
  }
}
