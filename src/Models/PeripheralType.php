<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeripheralType extends Common
{
  protected $table = 'glpi_peripheraltypes';
  protected $definition = '\App\Models\Definitions\PeripheralType';
  protected $titles = ['Peripheral type', 'Peripheral types'];
  protected $icon = 'edit';

}
