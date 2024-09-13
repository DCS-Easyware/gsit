<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Datacenter extends Common
{
  protected $table = 'glpi_datacenters';
  protected $definition = '\App\Models\Definitions\Datacenter';
  protected $titles = ['Data center', 'Data centers'];
  protected $icon = 'warehouse';

  protected $appends = [
    'location',
  ];

  protected $visible = [
    'location',
  ];

  protected $with = [
    'location:id,name',
  ];

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location', 'locations_id');
  }


}
