<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Computer extends Common
{
  protected $table = 'glpi_computers';
  protected $definition = '\App\Models\Definitions\Computer';
  protected $titles = ['Computer', 'Computers'];
  protected $icon = 'laptop';

  protected $appends = [
    'type',
    'model',
    'state',
    'manufacturer',
  ];

  protected $visible = [
    'type',
    'model',
    'state',
    'manufacturer',
  ];

  protected $with = [
    'type:id,name',
    'model:id,name',
    'state:id,name',
    'manufacturer:id,name',
  ];


  public function type(): BelongsTo
  {
      return $this->belongsTo('\App\Models\Computertype', 'computertypes_id');
  }

  public function model(): BelongsTo
  {
      return $this->belongsTo('\App\Models\Computermodel', 'computermodels_id');
  }

  public function state(): BelongsTo
  {
      return $this->belongsTo('\App\Models\State', 'states_id');
  }

  public function manufacturer(): BelongsTo
  {
      return $this->belongsTo('\App\Models\Manufacturer', 'manufacturers_id');
  }

}
