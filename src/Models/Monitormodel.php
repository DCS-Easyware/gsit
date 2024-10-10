<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monitormodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Monitormodel';
  protected $titles = ['Monitor model', 'Monitor models'];
  protected $icon = 'edit';
}
