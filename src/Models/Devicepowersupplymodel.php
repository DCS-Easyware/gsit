<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicepowersupplymodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicepowersupplymodel';
  protected $titles = ['Device power supply model', 'Device power supply models'];
  protected $icon = 'edit';
}
