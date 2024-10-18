<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contracttype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Contracttype';
  protected $titles = ['Contract type', 'Contract types'];
  protected $icon = 'edit';
}
