<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectTaskTemplate extends Common
{
  protected $table = 'glpi_projecttasktemplates';
  protected $definition = '\App\Models\Definitions\ProjectTaskTemplate';
  protected $titles = ['Project task template', 'Project task templates'];
  protected $icon = 'edit';

  protected $appends = [
    'state',
    'type',
    'projecttasks',
  ];

  protected $visible = [
    'state',
    'type',
    'projecttasks',
  ];

  protected $with = [
    'state:id,name',
    'type:id,name',
    'projecttasks:id,name',
  ];

  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ProjectState', 'projectstates_id');
  }

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ProjectTaskType', 'projecttasktypes_id');
  }

  public function projecttasks(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ProjectTask', 'projecttasks_id');
  }

}
