<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LineOperator extends Common
{
  protected $table = 'glpi_lineoperators';
  protected $definition = '\App\Models\Definitions\LineOperator';
  protected $titles = ['Line operator', 'Line operators'];
  protected $icon = 'edit';

}
