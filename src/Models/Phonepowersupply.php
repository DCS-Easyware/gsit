<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Phonepowersupply extends Common
{
  protected $definition = '\App\Models\Definitions\Phonepowersupply';
  protected $titles = ['Phone power supply type', 'Phone power supply types'];
  protected $icon = 'edit';
}
