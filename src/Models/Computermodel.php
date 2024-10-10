<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Computermodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Computermodel';
  protected $titles = ['Computer model', 'Computer models'];
  protected $icon = 'edit';
}
