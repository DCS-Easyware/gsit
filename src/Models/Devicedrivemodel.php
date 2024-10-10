<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicedrivemodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicedrivemodel';
  protected $titles = ['Device drive model', 'Device drive models'];
  protected $icon = 'edit';
}
