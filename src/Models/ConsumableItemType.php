<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConsumableItemType extends Common
{
  protected $table = 'glpi_consumableitemtypes';
  protected $definition = '\App\Models\Definitions\ConsumableItemType';
  protected $titles = ['Consumable type', 'Consumable types'];
  protected $icon = 'edit';

}
