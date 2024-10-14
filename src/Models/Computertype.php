<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Computertype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Computertype';
  protected $titles = ['Computer type', 'Computer types'];
  protected $icon = 'edit';
}
