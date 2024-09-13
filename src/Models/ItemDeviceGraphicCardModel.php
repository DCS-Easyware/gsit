<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceGraphicCardModel extends Common
{
  protected $table = 'glpi_devicegraphiccardmodels';
  protected $definition = '\App\Models\Definitions\ItemDeviceGraphicCardModel';
  protected $titles = ['Device graphic card model', 'Device graphic card models'];
  protected $icon = 'edit';

}
