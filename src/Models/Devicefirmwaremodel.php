<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicefirmwaremodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicefirmwaremodel';
  protected $titles = ['Device firmware model', 'Device firmware models'];
  protected $icon = 'edit';
}
