<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LineType extends Common
{
  protected $table = 'glpi_linetypes';
  protected $definition = '\App\Models\Definitions\LineType';
  protected $titles = ['Line type', 'Line types'];
  protected $icon = 'edit';

}
