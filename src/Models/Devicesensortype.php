<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicesensortype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicesensortype';
  protected $titles = ['Sensor type', 'Sensor types'];
  protected $icon = 'edit';
}
