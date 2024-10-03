<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Virtualmachinetype extends Common
{
  protected $definition = '\App\Models\Definitions\Virtualmachinetype';
  protected $titles = ['Virtualization system', 'Virtualization systems'];
  protected $icon = 'edit';
}
