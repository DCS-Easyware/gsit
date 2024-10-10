<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deviceprocessormodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Deviceprocessormodel';
  protected $titles = ['Device processor model', 'Device processor models'];
  protected $icon = 'edit';
}
