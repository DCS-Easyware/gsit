<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceMotherBoardModel extends Common
{
  protected $table = 'glpi_devicemotherboardmodels';
  protected $definition = '\App\Models\Definitions\ItemDeviceMotherBoardModel';
  protected $titles = ['System board model', 'System board models'];
  protected $icon = 'edit';

}
