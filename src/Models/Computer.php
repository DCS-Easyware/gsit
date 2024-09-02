<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Computer extends Common
{
  protected $table = 'glpi_computers';
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
    return $this->belongsTo('\App\Models\Computertype', 'computertypes_id');
  }

  public function model(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Computermodel', 'computermodels_id');
  }

  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\State', 'states_id');
  }

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer', 'manufacturers_id');
  }

  public function network(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Network', 'networks_id');
  }

  public function groupstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'groups_id_tech');
  }

  public function userstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id_tech');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id');
  }

  public function group(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'groups_id');
  }

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location', 'locations_id');
  }

  public function autoupdatesystem(): BelongsTo
  {
    return $this->belongsTo('\App\Models\AutoUpdateSystem', 'autoupdatesystems_id');
  }

}
