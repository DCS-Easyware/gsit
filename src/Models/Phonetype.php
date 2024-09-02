<?php

namespace App\Models;


class Phonetype extends Common
{
  protected $table = 'glpi_phonetypes';
  protected $definition = '\App\Models\Definitions\PhoneType';

}
