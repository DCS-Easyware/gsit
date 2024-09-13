<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceDriveModel extends Common
{
  protected $table = 'glpi_devicedrivemodels';
  protected $definition = '\App\Models\Definitions\ItemDeviceDriveModel';
  protected $titles = ['Device drive model', 'Device drive models'];
  protected $icon = 'edit';

}
