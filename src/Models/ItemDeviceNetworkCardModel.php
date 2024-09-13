<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceNetworkCardModel extends Common
{
  protected $table = 'glpi_devicenetworkcardmodels';
  protected $definition = '\App\Models\Definitions\ItemDeviceNetworkCardModel';
  protected $titles = ['Network card model', 'Network card models'];
  protected $icon = 'edit';

}
