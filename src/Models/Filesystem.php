<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filesystem extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Filesystem';
  protected $titles = ['File system', 'File systems'];
  protected $icon = 'edit';
}
