<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskTemplate extends Common
{
  protected $table = 'glpi_tasktemplates';
  protected $definition = '\App\Models\Definitions\TaskTemplate';
  protected $titles = ['Task template', 'Task templates'];
  protected $icon = 'edit';

  protected $appends = [
    'category',
    'users',
    'groups',
  ];

  protected $visible = [
    'category',
    'users',
    'groups',
  ];

  protected $with = [
    'category:id,name',
    'users:id,name',
    'groups:id,name',
  ];

  public function category(): BelongsTo
  {
    return $this->belongsTo('\App\Models\TaskCategory', 'taskcategories_id');
  }

  public function users(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id_tech');
  }

  public function groups(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'groups_id_tech');
  }

}
