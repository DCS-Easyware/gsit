<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Computertype extends Common
{
  protected $definition = '\App\Models\Definitions\Computertype';
  protected $titles = ['Computer type', 'Computer types'];
  protected $icon = 'edit';
}
