<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lineoperator extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Lineoperator';
  protected $titles = ['Line operator', 'Line operators'];
  protected $icon = 'edit';
}
