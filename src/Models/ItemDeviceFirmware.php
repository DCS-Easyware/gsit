<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceFirmware extends Common
{
  protected $table = 'glpi_devicefirmwares';
  protected $definition = '\App\Models\Definitions\ItemDeviceFirmware';
  protected $titles = ['Firmware', 'Firmware'];
  protected $icon = 'edit';

  protected $appends = [
    'manufacturer',
    'type',
    'model',
  ];

  protected $visible = [
    'manufacturer',
    'type',
    'model',
  ];

  protected $with = [
    'manufacturer:id,name',
    'type:id,name',
    'model:id,name',
  ];

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer', 'manufacturers_id');
  }

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ItemDeviceFirmwareType', 'devicefirmwaretypes_id');
  }

  public function model(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ItemDeviceFirmwareModel', 'devicefirmwaremodels_id');
  }

}