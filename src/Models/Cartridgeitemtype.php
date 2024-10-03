<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cartridgeitemtype extends Common
{
  protected $definition = '\App\Models\Definitions\Cartridgeitemtype';
  protected $titles = ['Cartridge type', 'Cartridge types'];
  protected $icon = 'edit';
}
