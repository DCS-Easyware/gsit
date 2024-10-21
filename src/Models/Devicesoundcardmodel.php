<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicesoundcardmodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicesoundcardmodel';
  protected $titles = ['Device sound card model', 'Device sound card models'];
  protected $icon = 'edit';
}
