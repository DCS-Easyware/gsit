<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devicesensortype extends Common
{
  protected $definition = '\App\Models\Definitions\Devicesensortype';
  protected $titles = ['Sensor type', 'Sensor types'];
  protected $icon = 'edit';
}
