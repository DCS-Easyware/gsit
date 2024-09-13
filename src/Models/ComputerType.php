<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComputerType extends Common
{
  protected $table = 'glpi_computertypes';
  protected $definition = '\App\Models\Definitions\ComputerType';
  protected $titles = ['Computer type', 'Computer types'];
  protected $icon = 'edit';

}
