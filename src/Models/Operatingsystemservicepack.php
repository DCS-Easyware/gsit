<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operatingsystemservicepack extends Common
{
  protected $definition = '\App\Models\Definitions\Operatingsystemservicepack';
  protected $titles = ['Service pack', 'Service packs'];
  protected $icon = 'edit';
}
