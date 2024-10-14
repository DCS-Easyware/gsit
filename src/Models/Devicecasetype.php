<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicecasetype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicecasetype';
  protected $titles = ['Case type', 'Case types'];
  protected $icon = 'edit';
}
