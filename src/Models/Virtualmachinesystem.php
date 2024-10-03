<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Virtualmachinesystem extends Common
{
  protected $definition = '\App\Models\Definitions\Virtualmachinesystem';
  protected $titles = ['Virtualization model', 'Virtualization models'];
  protected $icon = 'edit';
}
