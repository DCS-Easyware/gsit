<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceSensorType extends Common
{
  protected $table = 'glpi_devicesensortypes';
  protected $definition = '\App\Models\Definitions\ItemDeviceSensorType';
  protected $titles = ['Sensor type', 'Sensor types'];
  protected $icon = 'edit';

}
