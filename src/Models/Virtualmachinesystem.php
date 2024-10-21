<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Virtualmachinesystem extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Virtualmachinesystem';
  protected $titles = ['Virtualization model', 'Virtualization models'];
  protected $icon = 'edit';
}
