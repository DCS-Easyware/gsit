<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDevicePci extends Common
{
  protected $table = 'glpi_devicepcis';
  protected $definition = '\App\Models\Definitions\ItemDevicePci';
  protected $titles = ['PCI device', 'PCI devices'];
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
    return $this->belongsTo('\App\Models\ItemDevicePciModel', 'devicepcimodels_id');
  }

}