<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacttype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Contacttype';
  protected $titles = ['Contact type', 'Contact types'];
  protected $icon = 'edit';
}
