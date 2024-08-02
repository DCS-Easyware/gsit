<?php

namespace App\Models;


class Computer extends Common
{
  protected $table = 'glpi_computers';
  protected $definition = '\App\Models\Definitions\Computer';
  protected $titles = ['Computer', 'Computers'];
  protected $icon = 'laptop';
}
