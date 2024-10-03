<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Printermodel extends Common
{
  protected $definition = '\App\Models\Definitions\Printermodel';
  protected $titles = ['Printer model', 'Printer models'];
  protected $icon = 'edit';
}
