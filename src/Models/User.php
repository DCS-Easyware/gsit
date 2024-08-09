<?php

namespace App\Models;


class User extends Common
{
  protected $table = 'glpi_users';
  protected $definition = '\App\Models\Definitions\User';

}
