<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceProcessorModel extends Common
{
  protected $table = 'glpi_deviceprocessormodels';
  protected $definition = '\App\Models\Definitions\ItemDeviceProcessorModel';
  protected $titles = ['Device processor model', 'Device processor models'];
  protected $icon = 'edit';

}
