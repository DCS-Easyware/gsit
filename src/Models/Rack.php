<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rack extends Common
{
  protected $table = 'glpi_racks';
  protected $definition = '\App\Models\Definitions\Rack';
  protected $titles = ['Rack', 'Racks'];
  protected $icon = 'print';

  protected $appends = [
    'type',
    'model',
    'state',
    'manufacturer',
    'groupstech',
    'userstech',
    'location',
  ];

  protected $visible = [
    'type',
    'model',
    'state',
    'manufacturer',
    'groupstech',
    'userstech',
    'location',
  ];

  protected $with = [
    'type:id,name',
    'model:id,name',
    'state:id,name',
    'manufacturer:id,name',
    'groupstech:id,name',
    'userstech:id,name',
    'location:id,name',
  ];


  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Racktype', 'racktypes_id');
  }

  public function model(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Rackmodel', 'rackmodels_id');
  }

  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\State', 'states_id');
  }

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer', 'manufacturers_id');
  }

  public function groupstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'groups_id_tech');
  }

  public function userstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id_tech');
  }

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location', 'locations_id');
  }

}
