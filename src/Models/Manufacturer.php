<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manufacturer extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Manufacturer';
  protected $titles = ['Manufacturer', 'Manufacturers'];
  protected $icon = 'edit';
}
