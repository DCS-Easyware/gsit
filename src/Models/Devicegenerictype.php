<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicegenerictype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicegenerictype';
  protected $titles = ['Generic type', 'Generic types'];
  protected $icon = 'edit';
}
