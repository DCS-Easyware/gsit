<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plug extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Plug';
  protected $titles = ['Plug', 'Plugs'];
  protected $icon = 'edit';
}
