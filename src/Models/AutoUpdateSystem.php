<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AutoUpdateSystem extends Common
{
  protected $table = 'glpi_autoupdatesystems';
  protected $definition = '\App\Models\Definitions\AutoUpdateSystem';
  protected $titles = ['Update Source', 'Update Sources'];
  protected $icon = 'edit';

}
