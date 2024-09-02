<?php

namespace App\Models;


class Projecttype extends Common
{
  protected $table = 'glpi_projecttypes';
  protected $definition = '\App\Models\Definitions\ProjectType';

}
