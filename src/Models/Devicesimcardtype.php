<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicesimcardtype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicesimcardtype';
  protected $titles = ['Simcard type', 'Simcard types'];
  protected $icon = 'edit';
}
