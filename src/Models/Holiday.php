<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Holiday extends Common
{
  protected $table = 'glpi_holidays';
  protected $definition = '\App\Models\Definitions\Holiday';
  protected $titles = ['Close time', 'Close times'];
  protected $icon = 'edit';

}
