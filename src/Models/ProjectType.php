<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectType extends Common
{
  protected $table = 'glpi_projecttypes';
  protected $definition = '\App\Models\Definitions\ProjectType';
  protected $titles = ['Project type', 'Project types'];
  protected $icon = 'edit';

}
