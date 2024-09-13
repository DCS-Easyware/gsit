<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceMemoryModel extends Common
{
  protected $table = 'glpi_devicememorymodels';
  protected $definition = '\App\Models\Definitions\ItemDeviceMemoryModel';
  protected $titles = ['Device memory model', 'Device memory models'];
  protected $icon = 'edit';

}
