<?php

namespace App\Models;


class Printertype extends Common
{
  protected $table = 'glpi_printertypes';
  protected $definition = '\App\Models\Definitions\PrinterType';

}
