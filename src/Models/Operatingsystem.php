<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operatingsystem extends Common
{
  protected $definition = '\App\Models\Definitions\Operatingsystem';
  protected $titles = ['Operating system', 'Operating systems'];
  protected $icon = 'edit';
}
