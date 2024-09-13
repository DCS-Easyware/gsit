<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceCase extends Common
{
  protected $table = 'glpi_devicecases';
  protected $definition = '\App\Models\Definitions\ItemDeviceCase';
  protected $titles = ['Case', 'Cases'];
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
    return $this->belongsTo('\App\Models\ItemDeviceCaseType', 'devicecasetypes_id');
  }

  public function model(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ItemDeviceCaseModel', 'devicecasemodels_id');
  }

}