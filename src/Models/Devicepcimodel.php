<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devicepcimodel extends Common
{
  protected $definition = '\App\Models\Definitions\Devicepcimodel';
  protected $titles = ['Other component model', 'Other component models'];
  protected $icon = 'edit';
}
