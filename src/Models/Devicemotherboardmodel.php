<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devicemotherboardmodel extends Common
{
  protected $definition = '\App\Models\Definitions\Devicemotherboardmodel';
  protected $titles = ['System board model', 'System board models'];
  protected $icon = 'edit';
}
