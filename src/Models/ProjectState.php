<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectState extends Common
{
  protected $table = 'glpi_projectstates';
  protected $definition = '\App\Models\Definitions\ProjectState';
  protected $titles = ['Project state', 'Project states'];
  protected $icon = 'edit';

}
