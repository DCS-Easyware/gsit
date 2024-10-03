<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devicecasemodel extends Common
{
  protected $definition = '\App\Models\Definitions\Devicecasemodel';
  protected $titles = ['Device case model', 'Device case models'];
  protected $icon = 'edit';
}
