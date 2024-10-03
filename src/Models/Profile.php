<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Common
{
  protected $definition = '\App\Models\Definitions\Profile';
  protected $titles = ['Profile', 'Profiles'];
  protected $icon = 'user check';
}
