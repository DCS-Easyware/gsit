<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceFirmwareType extends Common
{
  protected $table = 'glpi_devicefirmwaretypes';
  protected $definition = '\App\Models\Definitions\ItemDeviceFirmwareType';
  protected $titles = ['Firmware type', 'Firmware types'];
  protected $icon = 'edit';

}
