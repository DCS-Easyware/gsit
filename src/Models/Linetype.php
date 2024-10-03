<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Linetype extends Common
{
  protected $definition = '\App\Models\Definitions\Linetype';
  protected $titles = ['Line type', 'Line types'];
  protected $icon = 'edit';
}
