<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Requesttype extends Common
{
  protected $definition = '\App\Models\Definitions\Requesttype';
  protected $titles = ['Request source', 'Request sources'];
  protected $icon = 'edit';
}
