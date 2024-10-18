<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projecttype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Projecttype';
  protected $titles = ['Project type', 'Project types'];
  protected $icon = 'edit';
}
