<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devicepowersupplymodel extends Common
{
  protected $definition = '\App\Models\Definitions\Devicepowersupplymodel';
  protected $titles = ['Device power supply model', 'Device power supply models'];
  protected $icon = 'edit';
}
