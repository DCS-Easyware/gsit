<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Passivedcequipmenttype extends Common
{
  protected $definition = '\App\Models\Definitions\Passivedcequipmenttype';
  protected $titles = ['Passive device type', 'Passive device types'];
  protected $icon = 'edit';
}
