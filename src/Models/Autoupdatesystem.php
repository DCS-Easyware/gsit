<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Autoupdatesystem extends Common
{
  protected $definition = '\App\Models\Definitions\Autoupdatesystem';
  protected $titles = ['Update Source', 'Update Sources'];
  protected $icon = 'edit';
}
