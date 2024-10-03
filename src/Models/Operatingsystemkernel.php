<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operatingsystemkernel extends Common
{
  protected $definition = '\App\Models\Definitions\Operatingsystemkernel';
  protected $titles = ['Kernel', 'Kernels'];
  protected $icon = 'edit';
}
