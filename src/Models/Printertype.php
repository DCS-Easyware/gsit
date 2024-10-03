<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Printertype extends Common
{
  protected $definition = '\App\Models\Definitions\Printertype';
  protected $titles = ['Printer type', 'Printer types'];
  protected $icon = 'edit';
}
