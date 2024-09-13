<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceSoundCard extends Common
{
  protected $table = 'glpi_devicesoundcards';
  protected $definition = '\App\Models\Definitions\ItemDeviceSoundCard';
  protected $titles = ['Soundcard', 'Soundcards'];
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
    return $this->belongsTo('\App\Models\ItemDeviceSoundCardModel', 'devicesoundcardmodels_id');
  }

}
