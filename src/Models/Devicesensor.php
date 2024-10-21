<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devicesensor extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Devicesensor';
  protected $titles = ['Sensor', 'Sensors'];
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
    return $this->belongsTo('\App\Models\Manufacturer');
  }

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Devicesensortype');
  }
}
