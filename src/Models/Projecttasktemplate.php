<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projecttasktemplate extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Projecttasktemplate';
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
    return $this->belongsTo('\App\Models\Projectstate');
  }

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Projecttasktype');
  }

  public function projecttasks(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Projecttask');
  }
}
