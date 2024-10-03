<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plug extends Common
{
  protected $definition = '\App\Models\Definitions\Plug';
  protected $titles = ['Plug', 'Plugs'];
  protected $icon = 'edit';
}
