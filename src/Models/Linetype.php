<?php

namespace App\Models;


class Linetype extends Common
{
  protected $table = 'glpi_linetypes';
  protected $definition = '\App\Models\Definitions\LineType';

}
