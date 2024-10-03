<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devicegenerictype extends Common
{
  protected $definition = '\App\Models\Definitions\Devicegenerictype';
  protected $titles = ['Generic type', 'Generic types'];
  protected $icon = 'edit';
}
