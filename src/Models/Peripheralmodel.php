<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peripheralmodel extends Common
{
  protected $definition = '\App\Models\Definitions\Peripheralmodel';
  protected $titles = ['Peripheral model', 'Peripheral models'];
  protected $icon = 'edit';
}
