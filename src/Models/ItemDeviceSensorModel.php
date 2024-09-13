<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceSensorModel extends Common
{
  protected $table = 'glpi_devicesensormodels';
  protected $definition = '\App\Models\Definitions\ItemDeviceSensorModel';
  protected $titles = ['Device sensor model', 'Device sensor models'];
  protected $icon = 'edit';

}
