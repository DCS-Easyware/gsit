<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rackmodel extends Common
{
  protected $definition = '\App\Models\Definitions\Rackmodel';
  protected $titles = ['Rack model', 'Rack models'];
  protected $icon = 'edit';
}
