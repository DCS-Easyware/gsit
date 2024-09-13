<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SolutionType extends Common
{
  protected $table = 'glpi_solutiontypes';
  protected $definition = '\App\Models\Definitions\SolutionType';
  protected $titles = ['Solution type', 'Solution types'];
  protected $icon = 'edit';

}
