<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceControlModel extends Common
{
  protected $table = 'glpi_devicecontrolmodels';
  protected $definition = '\App\Models\Definitions\ItemDeviceControlModel';
  protected $titles = ['Device control model', 'Device control models'];
  protected $icon = 'edit';

}
