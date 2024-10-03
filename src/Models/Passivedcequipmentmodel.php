<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Passivedcequipmentmodel extends Common
{
  protected $definition = '\App\Models\Definitions\Passivedcequipmentmodel';
  protected $titles = ['Passive device model', 'Passive device models'];
  protected $icon = 'edit';
}
