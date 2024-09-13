<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceHardDriveModel extends Common
{
  protected $table = 'glpi_deviceharddrivemodels';
  protected $definition = '\App\Models\Definitions\ItemDeviceHardDriveModel';
  protected $titles = ['Device hard drive model', 'Device hard drive models'];
  protected $icon = 'edit';

}
