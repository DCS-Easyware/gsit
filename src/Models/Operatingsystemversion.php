<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operatingsystemversion extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Operatingsystemversion';
  protected $titles = ['Version of the operating system', 'Versions of the operating systems'];
  protected $icon = 'edit';
}
