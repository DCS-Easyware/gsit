<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceGenericType extends Common
{
  protected $table = 'glpi_devicegenerictypes';
  protected $definition = '\App\Models\Definitions\ItemDeviceGenericType';
  protected $titles = ['Generic type', 'Generic types'];
  protected $icon = 'edit';

}
