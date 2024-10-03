<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lineoperator extends Common
{
  protected $definition = '\App\Models\Definitions\Lineoperator';
  protected $titles = ['Line operator', 'Line operators'];
  protected $icon = 'edit';
}
