<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceCaseModel extends Common
{
  protected $table = 'glpi_devicecasemodels';
  protected $definition = '\App\Models\Definitions\ItemDeviceCaseModel';
  protected $titles = ['Device case model', 'Device case models'];
  protected $icon = 'edit';

}
