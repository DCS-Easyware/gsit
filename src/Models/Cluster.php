<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cluster extends Common
{
  protected $definition = '\App\Models\Definitions\Cluster';
  protected $titles = ['Cluster', 'Clusters'];
  protected $icon = 'project diagram';

  protected $appends = [
    'type',
    'state',
    'userstech',
    'groupstech',
  ];

  protected $visible = [
    'type',
    'state',
    'userstech',
    'groupstech',
  ];

  protected $with = [
    'type:id,name',
    'state:id,name',
    'userstech:id,name',
    'groupstech:id,name',
  ];

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Clustertype');
  }

  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\State');
  }

  public function userstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'user_id_tech');
  }

  public function groupstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'group_id_tech');
  }
}
