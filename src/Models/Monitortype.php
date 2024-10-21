<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monitortype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Monitortype';
  protected $titles = ['Monitor type', 'Monitor types'];
  protected $icon = 'edit';
}
