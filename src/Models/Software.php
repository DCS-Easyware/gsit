<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Software extends Common
{
  use SoftDeletes;

  protected $table = 'softwares';
  protected $definition = '\App\Models\Definitions\Software';
  protected $titles = ['Software', 'Software'];
  protected $icon = 'cube';

  protected $appends = [
    // 'category',
    // 'manufacturer',
    // // 'nbinstallation',
    // 'versions',
    // 'groupstech',
    // 'userstech',
    // 'user',
    // 'group',
    // 'location',
  ];

  protected $visible = [
    // 'category',
    // 'manufacturer',
    // // 'nbinstallation',
    // 'versions',
    // 'groupstech',
    // 'userstech',
    // 'user',
    // 'group',
    // 'location',
  ];

  protected $with = [
    // 'category:id,name',
    // 'manufacturer:id,name',
    // // 'nbinstallation.devices',
    // // 'versions',
    // 'groupstech:id,name',
    // 'userstech:id,name',
    // 'user:id,name',
    // 'group:id,name',
    // 'location:id,name',
  ];

  public function category(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Softwarecategory');
  }

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer');
  }

  // public function nbinstallation(): HasMany
  // {
  //   return $this->hasMany('\App\Models\Softwareversion')->withCount('devices');
  // }

  public function versions(): HasMany
  {
    return $this->hasMany('\App\Models\Softwareversion');
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
}
