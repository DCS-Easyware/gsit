<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperatingSystemKernel extends Common
{
  protected $table = 'glpi_operatingsystemkernels';
  protected $definition = '\App\Models\Definitions\OperatingSystemKernel';
  protected $titles = ['Kernel', 'Kernels'];
  protected $icon = 'edit';

}
