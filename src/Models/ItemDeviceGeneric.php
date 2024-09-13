<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceGeneric extends Common
{
  protected $table = 'glpi_devicegenerics';
  protected $definition = '\App\Models\Definitions\ItemDeviceGeneric';
  protected $titles = ['Generic device', 'Generic devices'];
  protected $icon = 'edit';

  protected $appends = [
    'manufacturer',
    'type',
  ];

  protected $visible = [
    'manufacturer',
    'type',
  ];

  protected $with = [
    'manufacturer:id,name',
    'type:id,name',
  ];

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer', 'manufacturers_id');
  }

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ItemDeviceGenericType', 'devicegenerictypes_id');
  }

}