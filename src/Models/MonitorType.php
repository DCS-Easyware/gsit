<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MonitorType extends Common
{
  protected $table = 'glpi_monitortypes';
  protected $definition = '\App\Models\Definitions\MonitorType';
  protected $titles = ['Monitor type', 'Monitor types'];
  protected $icon = 'edit';

}
