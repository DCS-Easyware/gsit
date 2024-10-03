<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Monitortype extends Common
{
  protected $definition = '\App\Models\Definitions\Monitortype';
  protected $titles = ['Monitor type', 'Monitor types'];
  protected $icon = 'edit';
}
