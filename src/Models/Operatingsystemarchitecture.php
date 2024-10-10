<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operatingsystemarchitecture extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Operatingsystemarchitecture';
  protected $titles = ['Operating system architecture', 'Operating system architectures'];
  protected $icon = 'edit';
}
