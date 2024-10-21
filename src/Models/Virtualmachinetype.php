<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Virtualmachinetype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Virtualmachinetype';
  protected $titles = ['Virtualization system', 'Virtualization systems'];
  protected $icon = 'edit';
}
