<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumableitemtype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Consumableitemtype';
  protected $titles = ['Consumable type', 'Consumable types'];
  protected $icon = 'edit';
}
