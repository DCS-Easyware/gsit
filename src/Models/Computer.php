<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Computer extends Common
{
  protected $definition = '\App\Models\Definitions\Computer';
  protected $titles = ['Computer', 'Computers'];
  protected $icon = 'laptop';

  protected $appends = [
    'type',
    'model',
    'state',
    'manufacturer',
    'network',
    'groupstech',
    'userstech',
    'user',
    'group',
    'location',
    'autoupdatesystem',
  ];

  protected $visible = [
    'type',
    'model',
    'state',
    'manufacturer',
    'network',
    'groupstech',
    'userstech',
    'user',
    'group',
    'location',
    'autoupdatesystem',
  ];

  protected $with = [
    'type:id,name',
    'model:id,name',
    'state:id,name',
    'manufacturer:id,name',
    'network:id,name',
    'groupstech:id,name',
    'userstech:id,name',
    'user:id,name',
    'group:id,name',
    'location:id,name',
    'autoupdatesystem:id,name',
  ];


  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Computertype');
  }

  public function model(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Computermodel');
  }

  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\State');
  }

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer');
  }

  public function network(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Network');
  }

  public function groupstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'group_id_tech');
  }

  public function userstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'user_id_tech');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User');
  }

  public function group(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group');
  }

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location');
  }

  public function autoupdatesystem(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Autoupdatesystem');
  }
}
