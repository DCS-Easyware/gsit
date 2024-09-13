<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SoftwareLicense extends Common
{
  protected $table = 'glpi_softwarelicenses';
  protected $definition = '\App\Models\Definitions\SoftwareLicense';
  protected $titles = ['License', 'Licenses'];
  protected $icon = 'key';

  protected $appends = [
    'location',
    'softwarelicensetype',
    'userstech',
    'groupstech',
    'user',
    'group',
    'state',
    'softwareversions_buy',
    'softwareversions_use',
    'manufacturer',
    'software',
  ];

  protected $visible = [
    'location',
    'softwarelicensetype',
    'userstech',
    'groupstech',
    'user',
    'group',
    'state',
    'softwareversions_buy',
    'softwareversions_use',
    'manufacturer',
    'software',
  ];

  protected $with = [
    'location:id,name',
    'softwarelicensetype:id,name',
    'userstech:id,name',
    'groupstech:id,name',
    'user:id,name',
    'group:id,name',
    'state:id,name',
    'softwareversions_buy:id,name',
    'softwareversions_use:id,name',
    'manufacturer:id,name',
    'software:id,name',
  ];

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location', 'locations_id');
  }

  public function softwarelicensetype(): BelongsTo
  {
    return $this->belongsTo('\App\Models\SoftwareLicenseType', 'softwarelicensetypes_id');
  }

  public function userstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id_tech');
  }

  public function groupstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'groups_id_tech');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id');
  }

  public function group(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'groups_id');
  }

  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\State', 'states_id');
  }

  public function softwareversions_buy(): BelongsTo
  {
    return $this->belongsTo('\App\Models\SoftwareVersion', 'softwareversions_id_buy');
  }

  public function softwareversions_use(): BelongsTo
  {
    return $this->belongsTo('\App\Models\SoftwareVersion', 'softwareversions_id_use');
  }

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer', 'manufacturers_id');
  }

  public function software(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Software', 'softwares_id');
  }


}
