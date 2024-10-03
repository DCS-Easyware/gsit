<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peripheraltype extends Common
{
  protected $definition = '\App\Models\Definitions\Peripheraltype';
  protected $titles = ['Peripheral type', 'Peripheral types'];
  protected $icon = 'edit';
}
