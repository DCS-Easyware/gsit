<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperatingSystem extends Common
{
  protected $table = 'glpi_operatingsystems';
  protected $definition = '\App\Models\Definitions\OperatingSystem';
  protected $titles = ['Operating system', 'Operating systems'];
  protected $icon = 'edit';

}
