<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Profile';
  protected $titles = ['Profile', 'Profiles'];
  protected $icon = 'user check';
}
