<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contracttype extends Common
{
  protected $definition = '\App\Models\Definitions\Contracttype';
  protected $titles = ['Contract type', 'Contract types'];
  protected $icon = 'edit';
}
