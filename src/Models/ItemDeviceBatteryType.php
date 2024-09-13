<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceBatteryType extends Common
{
  protected $table = 'glpi_devicebatterytypes';
  protected $definition = '\App\Models\Definitions\ItemDeviceBatteryType';
  protected $titles = ['Battery type', 'Battery types'];
  protected $icon = 'edit';

}