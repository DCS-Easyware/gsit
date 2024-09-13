<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Software extends Common
{
  protected $table = 'glpi_softwares';
  protected $definition = '\App\Models\Definitions\Software';
  protected $titles = ['Software', 'Software'];
  protected $icon = 'cube';

  protected $appends = [
    'category',
    'manufacturer',
    // 'nbinstallation',
    'versions',
    'groupstech',
    'userstech',
    'user',
    'group',
    'location',
  ];

  protected $visible = [
    'category',
    'manufacturer',
    // 'nbinstallation',
    'versions',
    'groupstech',
    'userstech',
    'user',
    'group',
    'location',
  ];

  protected $with = [
    'category:id,name',
    'manufacturer:id,name',
    // 'nbinstallation.devices',
    'versions',
    'groupstech:id,name',
    'userstech:id,name',
    'user:id,name',
    'group:id,name',
    'location:id,name',
  ];

  public function category(): BelongsTo
  {
    return $this->belongsTo('\App\Models\SoftwareCategory', 'softwarecategories_id');
  }

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer', 'manufacturers_id');
  }

  // public function nbinstallation(): HasMany
  // {
  //   return $this->hasMany('\App\Models\SoftwareVersion', 'softwares_id')->withCount('devices');
  // }

  public function versions(): HasMany
  {
    return $this->hasMany('\App\Models\SoftwareVersion', 'softwares_id');
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
}
