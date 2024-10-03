<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devicecasetype extends Common
{
  protected $definition = '\App\Models\Definitions\Devicecasetype';
  protected $titles = ['Case type', 'Case types'];
  protected $icon = 'edit';
}
