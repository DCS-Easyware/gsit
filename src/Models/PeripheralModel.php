<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeripheralModel extends Common
{
  protected $table = 'glpi_peripheralmodels';
  protected $definition = '\App\Models\Definitions\PeripheralModel';
  protected $titles = ['Peripheral model', 'Peripheral models'];
  protected $icon = 'edit';

}
