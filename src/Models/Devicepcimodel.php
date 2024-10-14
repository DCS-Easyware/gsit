<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicepcimodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicepcimodel';
  protected $titles = ['Other component model', 'Other component models'];
  protected $icon = 'edit';
}
