<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Passivedcequipmentmodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Passivedcequipmentmodel';
  protected $titles = ['Passive device model', 'Passive device models'];
  protected $icon = 'edit';
}
