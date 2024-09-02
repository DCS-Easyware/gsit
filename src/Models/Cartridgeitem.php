<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cartridgeitem extends Common
{
  protected $table = 'glpi_cartridgeitems';
  protected $definition = '\App\Models\Definitions\Cartridgeitem';
  protected $titles = ['Cartridge', 'Cartridges'];
  protected $icon = 'fill drip';

  protected $appends = [
    'type',
    'manufacturer',
    'groupstech',
    'userstech',
    'location',
  ];

  protected $visible = [
    'type',
    'manufacturer',
    'groupstech',
    'userstech',
    'location',
  ];

  protected $with = [
    'type:id,name',
    'manufacturer:id,name',
    'groupstech:id,name',
    'userstech:id,name',
    'location:id,name',
  ];


  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Cartridgeitemtype', 'cartridgeitemtypes_id');
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
