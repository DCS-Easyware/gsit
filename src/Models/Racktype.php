<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Racktype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Racktype';
  protected $titles = ['Rack type', 'Rack types'];
  protected $icon = 'edit';
}
