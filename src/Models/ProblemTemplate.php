<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProblemTemplate extends Common
{
  protected $table = 'glpi_problemtemplates';
  protected $definition = '\App\Models\Definitions\ProblemTemplate';

}
