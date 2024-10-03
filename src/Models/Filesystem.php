<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filesystem extends Common
{
  protected $definition = '\App\Models\Definitions\Filesystem';
  protected $titles = ['File system', 'File systems'];
  protected $icon = 'edit';
}
