<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devicememorytype extends Common
{
  protected $definition = '\App\Models\Definitions\Devicememorytype';
  protected $titles = ['Memory type', 'Memory types'];
  protected $icon = 'edit';
}
