<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Linetype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Linetype';
  protected $titles = ['Line type', 'Line types'];
  protected $icon = 'edit';
}
