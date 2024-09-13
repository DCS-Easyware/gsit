<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceGenericModel extends Common
{
  protected $table = 'glpi_devicegenericmodels';
  protected $definition = '\App\Models\Definitions\ItemDeviceGenericModel';
  protected $titles = ['Device generic model', 'Device generic models'];
  protected $icon = 'edit';

}
