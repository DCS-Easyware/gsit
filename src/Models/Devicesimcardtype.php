<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devicesimcardtype extends Common
{
  protected $definition = '\App\Models\Definitions\Devicesimcardtype';
  protected $titles = ['Simcard type', 'Simcard types'];
  protected $icon = 'edit';
}
