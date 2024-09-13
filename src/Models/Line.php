<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Line extends Common
{
  protected $table = 'glpi_lines';
  protected $definition = '\App\Models\Definitions\Line';
  protected $titles = ['Line', 'Lines'];
  protected $icon = 'phone';

  protected $appends = [
    'location',
    'type',
    'operator',
    'state',
    'user',
    'group',
  ];

  protected $visible = [
    'location',
    'type',
    'operator',
    'state',
    'user',
    'group',
  ];

  protected $with = [
    'location:id,name',
    'type:id,name',
    'operator:id,name',
    'state:id,name',
    'user:id,name',
    'group:id,name',
  ];

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location', 'locations_id');
  }

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\LineType', 'linetypes_id');
  }

  public function operator(): BelongsTo
  {
    return $this->belongsTo('\App\Models\LineOperator', 'lineoperators_id');
  }

  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\State', 'states_id');
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
