<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Common
{
  protected $table = 'glpi_states';
  protected $definition = '\App\Models\Definitions\State';
  protected $titles = ['Status of items', 'Statuses of items'];
  protected $icon = 'edit';

  protected $appends = [
    'state',
  ];

  protected $visible = [
    'state',
  ];

  protected $with = [
    'state:id,name',
  ];

  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\State', 'states_id');
  }
}
