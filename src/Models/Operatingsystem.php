<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Operatingsystem extends Common
{
  protected $table = 'glpi_operatingsystems';
  // protected $definition = '\App\Models\Definitions\Computer';
  protected $titles = ['Operating system', 'Operating systems'];
  protected $icon = 'laptop house';

  protected $appends = [
  ];

  protected $visible = [
  ];

  protected $with = [
  ];
}
