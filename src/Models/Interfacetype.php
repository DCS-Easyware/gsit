<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Interfacetype extends Common
{
  protected $definition = '\App\Models\Definitions\Interfacetype';
  protected $titles = ['Interface type (Hard drive...)', 'Interface types (Hard drive...)'];
  protected $icon = 'edit';
}
