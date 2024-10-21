<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Networkinterface extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Networkinterface';
  protected $titles = ['Network interface', 'Network interfaces'];
  protected $icon = 'edit';
}
