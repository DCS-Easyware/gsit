<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDevicePciModel extends Common
{
  protected $table = 'glpi_devicepcimodels';
  protected $definition = '\App\Models\Definitions\ItemDevicePciModel';
  protected $titles = ['Other component model', 'Other component models'];
  protected $icon = 'edit';

}
