<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Common
{
  protected $definition = '\App\Models\Definitions\Event';
  protected $titles = ['Log', 'Logs'];
  protected $icon = 'scroll';
}
