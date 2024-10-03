<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Networkinterface extends Common
{
  protected $definition = '\App\Models\Definitions\Networkinterface';
  protected $titles = ['Network interface', 'Network interfaces'];
  protected $icon = 'edit';
}
