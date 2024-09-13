<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectTask extends Common
{
  protected $table = 'glpi_projecttasks';
  protected $definition = '\App\Models\Definitions\ProjectTask';
  protected $titles = ['Project task', 'Project tasks'];
  protected $icon = 'edit';

}
