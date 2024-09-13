<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectTaskType extends Common
{
  protected $table = 'glpi_projecttasktypes';
  protected $definition = '\App\Models\Definitions\ProjectTaskType';
  protected $titles = ['Project tasks type', 'Project tasks types'];
  protected $icon = 'edit';

}
