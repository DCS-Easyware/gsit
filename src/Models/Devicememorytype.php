<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicememorytype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicememorytype';
  protected $titles = ['Memory type', 'Memory types'];
  protected $icon = 'edit';
}
