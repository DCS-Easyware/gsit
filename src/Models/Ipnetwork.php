<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ipnetwork extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Ipnetwork';
  protected $titles = ['IP network', 'IP networks'];
  protected $icon = 'edit';
}
