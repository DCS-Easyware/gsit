<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceFirmwareModel extends Common
{
  protected $table = 'glpi_devicefirmwaremodels';
  protected $definition = '\App\Models\Definitions\ItemDeviceFirmwareModel';
  protected $titles = ['Device firmware model', 'Device firmware models'];
  protected $icon = 'edit';

}
