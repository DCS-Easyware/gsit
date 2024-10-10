<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cartridgeitemtype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Cartridgeitemtype';
  protected $titles = ['Cartridge type', 'Cartridge types'];
  protected $icon = 'edit';
}
