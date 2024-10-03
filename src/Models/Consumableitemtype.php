<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consumableitemtype extends Common
{
  protected $definition = '\App\Models\Definitions\Consumableitemtype';
  protected $titles = ['Consumable type', 'Consumable types'];
  protected $icon = 'edit';
}
