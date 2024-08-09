<?php

namespace App\Models;


class Manufacturer extends Common
{
  protected $table = 'glpi_manufacturers';
  protected $definition = '\App\Models\Definitions\Manufacturer';

}
