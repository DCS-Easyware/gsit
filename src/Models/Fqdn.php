<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fqdn extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Fqdn';
  protected $titles = ['Internet domain', 'Internet domains'];
  protected $icon = 'edit';
}
