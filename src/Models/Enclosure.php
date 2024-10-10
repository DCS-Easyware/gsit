<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enclosure extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Enclosure';
  protected $titles = ['Enclosure', 'Enclosures'];
  protected $icon = 'th';

  protected $appends = [
    'model',
    'state',
    'manufacturer',
    'groupstech',
    'userstech',
    'location',
  ];

  protected $visible = [
    'model',
    'state',
    'manufacturer',
    'groupstech',
    'userstech',
    'location',
  ];

  protected $with = [
    'model:id,name',
    'state:id,name',
    'manufacturer:id,name',
    'groupstech:id,name',
    'userstech:id,name',
    'location:id,name',
  ];


  public function model(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Enclosuremodel');
  }

  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\State');
  }

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer');
  }

  public function groupstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'group_id_tech');
  }

  public function userstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'user_id_tech');
  }

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location');
  }
}
