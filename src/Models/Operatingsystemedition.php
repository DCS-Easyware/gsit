<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operatingsystemedition extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Operatingsystemedition';
  protected $titles = ['Edition', 'Editions'];
  protected $icon = 'edit';
}
