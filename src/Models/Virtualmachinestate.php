<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Virtualmachinestate extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Virtualmachinestate';
  protected $titles = ['State of the virtual machine', 'States of the virtual machine'];
  protected $icon = 'edit';
}
