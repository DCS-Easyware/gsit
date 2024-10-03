<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deviceprocessormodel extends Common
{
  protected $definition = '\App\Models\Definitions\Deviceprocessormodel';
  protected $titles = ['Device processor model', 'Device processor models'];
  protected $icon = 'edit';
}
