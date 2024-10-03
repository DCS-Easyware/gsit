<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Operatingsystemversion extends Common
{
  protected $definition = '\App\Models\Definitions\Operatingsystemversion';
  protected $titles = ['Version of the operating system', 'Versions of the operating systems'];
  protected $icon = 'edit';
}
