<?php

namespace App\Models;


class Domaintype extends Common
{
  protected $table = 'glpi_domaintypes';
  protected $definition = '\App\Models\Definitions\DomainType';

}
