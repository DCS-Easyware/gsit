<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fqdn extends Common
{
  protected $definition = '\App\Models\Definitions\Fqdn';
  protected $titles = ['Internet domain', 'Internet domains'];
  protected $icon = 'edit';
}
