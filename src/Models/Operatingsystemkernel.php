<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operatingsystemkernel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Operatingsystemkernel';
  protected $titles = ['Kernel', 'Kernels'];
  protected $icon = 'edit';
}
