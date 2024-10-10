<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Passivedcequipmenttype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Passivedcequipmenttype';
  protected $titles = ['Passive device type', 'Passive device types'];
  protected $icon = 'edit';
}
