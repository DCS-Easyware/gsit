<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projecttasktype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Projecttasktype';
  protected $titles = ['Project tasks type', 'Project tasks types'];
  protected $icon = 'edit';
}
