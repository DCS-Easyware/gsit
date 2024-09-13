<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RackModel extends Common
{
  protected $table = 'glpi_rackmodels';
  protected $definition = '\App\Models\Definitions\RackModel';
  protected $titles = ['Rack model', 'Rack models'];
  protected $icon = 'edit';

}
