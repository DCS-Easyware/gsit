<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operatingsystemedition extends Common
{
  protected $definition = '\App\Models\Definitions\Operatingsystemedition';
  protected $titles = ['Edition', 'Editions'];
  protected $icon = 'edit';
}
