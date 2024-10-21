<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requesttype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Requesttype';
  protected $titles = ['Request source', 'Request sources'];
  protected $icon = 'edit';
}
