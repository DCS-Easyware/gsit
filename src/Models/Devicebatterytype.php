<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicebatterytype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicebatterytype';
  protected $titles = ['Battery type', 'Battery types'];
  protected $icon = 'edit';
}
