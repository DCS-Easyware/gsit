<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Software extends Common
{
  protected $table = 'glpi_softwares';
  protected $definition = '\App\Models\Definitions\Software';
  protected $titles = ['Software', 'Software'];
  protected $icon = 'cube';

  protected $appends = [
    'category',
    'manufacturer',
    'versions',
  ];

  protected $visible = [
    'category',
    'manufacturer',
    'versions',
  ];

  protected $with = [
    'category:id,name',
    'manufacturer:id,name',
    'nbinstallation.devices',
    'versions',
  ];

  public function category(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Softwarecategory', 'softwarecategories_id');
  }

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer', 'manufacturers_id');
  }

  public function nbinstallation(): HasMany
  {
    return $this->hasMany('\App\Models\Softwareversion', 'softwares_id')->withCount('devices');
  }

  public function versions(): HasMany
  {
    return $this->hasMany('\App\Models\Softwareversion', 'softwares_id');
  }
}
