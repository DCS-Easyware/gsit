<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceSimcardType extends Common
{
  protected $table = 'glpi_devicesimcardtypes';
  protected $definition = '\App\Models\Definitions\ItemDeviceSimcardType';
  protected $titles = ['Simcard type', 'Simcard types'];
  protected $icon = 'edit';

}
