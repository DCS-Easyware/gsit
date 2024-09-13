<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RackType extends Common
{
  protected $table = 'glpi_racktypes';
  protected $definition = '\App\Models\Definitions\RackType';
  protected $titles = ['Rack type', 'Rack types'];
  protected $icon = 'edit';

}
