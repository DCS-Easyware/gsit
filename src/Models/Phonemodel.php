<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Phonemodel extends Common
{
  protected $definition = '\App\Models\Definitions\Phonemodel';
  protected $titles = ['Phone model', 'Phone models'];
  protected $icon = 'edit';
}
