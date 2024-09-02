<?php

namespace App\Models;


class Contacttype extends Common
{
  protected $table = 'glpi_contacttypes';
  protected $definition = '\App\Models\Definitions\ContactType';

}
