<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceMemoryType extends Common
{
  protected $table = 'glpi_devicememorytypes';
  protected $definition = '\App\Models\Definitions\ItemDeviceMemoryType';
  protected $titles = ['Memory type', 'Memory types'];
  protected $icon = 'edit';

}
