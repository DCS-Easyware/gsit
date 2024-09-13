<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceSoundCardModel extends Common
{
  protected $table = 'glpi_devicesoundcardmodels';
  protected $definition = '\App\Models\Definitions\ItemDeviceSoundCardModel';
  protected $titles = ['Device sound card model', 'Device sound card models'];
  protected $icon = 'edit';

}
