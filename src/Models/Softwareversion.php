<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Softwareversion extends Common
{
  protected $table = 'glpi_softwareversions';
  protected $definition = '\App\Models\Definitions\Softwareversion';

  protected $appends = [
  ];

  protected $visible = [
  ];

  protected $with = [
  ];

  // We get all devices
  public function devices()
  {
    return $this->belongsToMany('\App\Models\Computer', 'glpi_items_softwareversions', 'softwareversions_id', 'items_id');
  }
}
