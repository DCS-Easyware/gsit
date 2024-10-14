<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Printertype extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Printertype';
  protected $titles = ['Printer type', 'Printer types'];
  protected $icon = 'edit';
}
