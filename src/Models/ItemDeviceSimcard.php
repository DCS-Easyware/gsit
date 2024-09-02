<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemDeviceSimcard extends Common
{
  protected $table = 'glpi_items_devicesimcards';
  protected $definition = '\App\Models\Definitions\ItemDeviceSimcard';
  protected $titles = ['Simcard', 'Simcards'];
  protected $icon = 'sim card';

  protected $appends = [
    'state',
    'location',
    'user',
    'group',
  ];

  protected $visible = [
    'state',
    'location',
    'user',
    'group',
  ];

  protected $with = [
    'state:id,name',
    'location:id,name',
    'user:id,name',
    'group:id,name',
  ];


  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\State', 'states_id');
  }

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location', 'locations_id');
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
