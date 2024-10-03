<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projecttype extends Common
{
  protected $definition = '\App\Models\Definitions\Projecttype';
  protected $titles = ['Project type', 'Project types'];
  protected $icon = 'edit';
}
