<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceControl extends Common
{
  protected $table = 'glpi_devicecontrols';
  protected $definition = '\App\Models\Definitions\ItemDeviceControl';
  protected $titles = ['Controller', 'Controllers'];
  protected $icon = 'edit';

  protected $appends = [
    'manufacturer',
    'model',
    'interface',
  ];

  protected $visible = [
    'manufacturer',
    'model',
    'interface',
  ];

  protected $with = [
    'manufacturer:id,name',
    'model:id,name',
    'interface:id,name',
  ];

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer', 'manufacturers_id');
  }

  public function model(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ItemDeviceControlModel', 'devicecontrolmodels_id');
  }

  public function interface(): BelongsTo
  {
    return $this->belongsTo('\App\Models\InterfaceType', 'interfacetypes_id');
  }

}