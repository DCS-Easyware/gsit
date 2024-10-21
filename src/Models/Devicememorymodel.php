<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicememorymodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicememorymodel';
  protected $titles = ['Device memory model', 'Device memory models'];
  protected $icon = 'edit';
}
