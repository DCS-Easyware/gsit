<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDevicePowerSupply extends Common
{
  protected $table = 'glpi_devicepowersupplies';
  protected $definition = '\App\Models\Definitions\ItemDevicePowerSupply';
  protected $titles = ['Power supply', 'Power supplies'];
  protected $icon = 'edit';

  protected $appends = [
    'manufacturer',
    'model',
  ];

  protected $visible = [
    'manufacturer',
    'model',
  ];

  protected $with = [
    'manufacturer:id,name',
    'model:id,name',
  ];

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer', 'manufacturers_id');
  }

  public function model(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ItemDevicePowerSupplyModel', 'devicepowersupplymodels_id');
  }

}