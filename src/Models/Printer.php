<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Printer extends Common
{
  protected $table = 'glpi_printers';
  protected $definition = '\App\Models\Definitions\Printer';
  protected $titles = ['Printer', 'Printers'];
  protected $icon = 'print';

  protected $appends = [
    'type',
    'model',
    'state',
    'manufacturer',
    'user',
    'group',
    'network',
    'groupstech',
    'userstech',
    'location',
  ];

  protected $visible = [
    'type',
    'model',
    'state',
    'manufacturer',
    'user',
    'group',
    'network',
    'groupstech',
    'userstech',
    'location',
  ];

  protected $with = [
    'type:id,name',
    'model:id,name',
    'state:id,name',
    'manufacturer:id,name',
    'user:id,name',
    'group:id,name',
    'network:id,name',
    'groupstech:id,name',
    'userstech:id,name',
    'location:id,name',
  ];


  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\PrinterType', 'printertypes_id');
  }

  public function model(): BelongsTo
  {
    return $this->belongsTo('\App\Models\PrinterModel', 'printermodels_id');
  }

  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\State', 'states_id');
  }

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer', 'manufacturers_id');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id');
  }

  public function group(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'groups_id');
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

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location', 'locations_id');
  }

}
