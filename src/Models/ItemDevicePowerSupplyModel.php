<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDevicePowerSupplyModel extends Common
{
  protected $table = 'glpi_devicepowersupplymodels';
  protected $definition = '\App\Models\Definitions\ItemDevicePowerSupplyModel';
  protected $titles = ['Device power supply model', 'Device power supply models'];
  protected $icon = 'edit';

}
