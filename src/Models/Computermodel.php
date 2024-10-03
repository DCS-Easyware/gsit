<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Computermodel extends Common
{
  protected $definition = '\App\Models\Definitions\Computermodel';
  protected $titles = ['Computer model', 'Computer models'];
  protected $icon = 'edit';
}
