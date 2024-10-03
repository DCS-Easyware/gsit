<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ipnetwork extends Common
{
  protected $definition = '\App\Models\Definitions\Ipnetwork';
  protected $titles = ['IP network', 'IP networks'];
  protected $icon = 'edit';
}
