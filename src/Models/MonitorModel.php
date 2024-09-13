<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MonitorModel extends Common
{
  protected $table = 'glpi_monitormodels';
  protected $definition = '\App\Models\Definitions\MonitorModel';
  protected $titles = ['Monitor model', 'Monitor models'];
  protected $icon = 'edit';

}
