<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Event';
  protected $titles = ['Log', 'Logs'];
  protected $icon = 'scroll';
}
