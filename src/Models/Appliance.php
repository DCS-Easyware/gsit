<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appliance extends Common
{
  protected $table = 'glpi_appliances';
  protected $definition = '\App\Models\Definitions\Appliance';
  protected $titles = ['Appliance', 'Appliances'];
  protected $icon = 'cubes';

  protected $appends = [
    'location',
    'type',
    'state',
    'user',
    'group',
    'userstech',
    'groupstech',
    'manufacturer',
    'environment',
  ];

  protected $visible = [
    'location',
    'type',
    'state',
    'user',
    'group',
    'userstech',
    'groupstech',
    'manufacturer',
    'environment',
  ];

  protected $with = [
    'location:id,name',
    'type:id,name',
    'state:id,name',
    'user:id,name',
    'group:id,name',
    'userstech:id,name',
    'groupstech:id,name',
    'manufacturer:id,name',
    'environment:id,name',
  ];

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location', 'locations_id');
  }

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ApplianceType', 'appliancetypes_id');
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

  public function userstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id_tech');
  }

  public function groupstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'groups_id_tech');
  }

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer', 'manufacturers_id');
  }

  public function environment(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ApplianceEnvironment', 'applianceenvironments_id');
  }

}
