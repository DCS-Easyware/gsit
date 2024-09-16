<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DateTime;
use Firebase\JWT\JWT;
use Tuupola\Base62;

final class Token
{
   /**
    * Check is a password match the stored hash
    *
    * @since 0.85
    *
    * @param string $pass Password (pain-text)
    * @param string $hash Hash
    *
    * @return boolean
    */
    static function checkPassword($pass, $hash)
    {
      $tmp = password_get_info($hash);
      $verify = false;

      if (isset($tmp['algo']) && $tmp['algo'])
      {
        $verify = password_verify($pass, $hash);
      } else if (strlen($hash)==32)
      {
        $verify = md5($pass) === $hash;
      } else if (strlen($hash)==40)
      {
        $verify = sha1($pass) === $hash;
      } else {
         $salt = substr($hash, 0, 8);
         $verify = ($salt.sha1($salt.$pass) === $hash);
      }
      return $verify;
   }

  public function generateJWTToken(\App\Models\User $user)
  {
    $firstName = $user->firstname;
    $lastName = $user->realname;
    // $jwtid = $user->getPropertyAttribute('userjwtid');
    $jwtid = null;
    // $jwtidId = $user->getPropertyAttribute('userjwtid', 'id');
    // $refreshtokenPropId = $user->getPropertyAttribute('userrefreshtoken', 'id');
    // if (is_null($jwtidId) || is_null($refreshtokenPropId))
    // {
    //   throw new \Exception('The database is corrupted', 500);
    // }

    // Generate a new refreshtoken and save in DB
    $refreshtoken = $this->generateToken();
    // $user->properties()->updateExistingPivot($refreshtokenPropId, ['value_string' => $refreshtoken]);

    // the jwtid (jit), used to revoke the JWT by server (for example when change rights, disable user...)
    if (is_null($jwtid))
    {
      $jti = $this->generateToken();
      // $user->properties()->updateExistingPivot($jwtidId, ['value_string' => $jti]);
    } else {
      $jti = $jwtid;
    }

    $now = new DateTime();
    $future = new DateTime("+2000 minutes");
    // For test / DEBUG
    // $future = new DateTime("+30 seconds");
    // Get roles
    // $role = $user->roles()->first();

    // if (is_null($role))
    // {
    //   throw new \Exception('No role assigned to the user', 401);
    // }

    $payload = [
      'iat'              => $now->getTimeStamp(),
      'exp'              => $future->getTimeStamp(),
      'jti'              => $jti,
      'sub'              => '',
      'scope'            => $this->getScope($user->id),
      'user_id'          => $user->id,
      // 'role_id'          => $role->id,
      'firstname'        => $firstName,
      'lastname'         => $lastName,
      'apiversion'       => "v1",
      'entities_id'      => $user->entities_id,
      'sub_organization' => true
    ];
    // $configSecret = include(__DIR__ . '/../../../config/current/config.php');
    $secret = sodium_base642bin('TEST', SODIUM_BASE64_VARIANT_ORIGINAL);
    $token = JWT::encode($payload, $secret, "HS256");
    $responseData = [
      "token"        => $token,
      "refreshtoken" => $refreshtoken,
      "expires"      => $future->getTimeStamp()
    ];
    return $responseData;
  }

  // get rights of this user.
  private function getScope($userId)
  {
    $scope = [
    ];

    return $scope;
  }

  private function generateToken()
  {
     return (new Base62())->encode(random_bytes(16));
  }

}
