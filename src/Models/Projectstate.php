<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projectstate extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Projectstate';
  protected $titles = ['Project state', 'Project states'];
  protected $icon = 'edit';
}
