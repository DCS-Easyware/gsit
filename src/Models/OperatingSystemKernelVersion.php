<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperatingSystemKernelVersion extends Common
{
  protected $table = 'glpi_operatingsystemkernelversions';
  protected $definition = '\App\Models\Definitions\OperatingSystemKernelVersion';
  protected $titles = ['Kernel version', 'Kernel versions'];
  protected $icon = 'edit';

  protected $appends = [
    'kernel',
  ];

  protected $visible = [
    'kernel',
  ];

  protected $with = [
    'kernel:id,name',
  ];


  public function kernel(): BelongsTo
  {
    return $this->belongsTo('\App\Models\OperatingSystemKernel', 'operatingsystemkernels_id');
  }

}