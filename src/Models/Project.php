<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Common
{
  protected $table = 'glpi_projects';
  protected $definition = '\App\Models\Definitions\Project';
  protected $titles = ['Project', 'Projects'];
  protected $icon = 'columns';

  protected $appends = [
    'type',
    'state',
    'user',
    'group',
  ];

  protected $visible = [
    'type',
    'state',
    'user',
    'group',
  ];

  protected $with = [
    'type:id,name',
    'state:id,name',
    'user:id,name',
    'group:id,name',
  ];


  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ProjectType', 'projecttypes_id');
  }

  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ProjectState', 'projectstates_id');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id');
  }

  public function group(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'groups_id');
  }

}
