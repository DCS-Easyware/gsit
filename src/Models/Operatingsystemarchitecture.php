<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operatingsystemarchitecture extends Common
{
  protected $definition = '\App\Models\Definitions\Operatingsystemarchitecture';
  protected $titles = ['Operating system architecture', 'Operating system architectures'];
  protected $icon = 'edit';
}
