<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDevicesimcard extends Common
{
  protected $definition = '\App\Models\Definitions\ItemDevicesimcard';
  protected $titles = ['Simcard', 'Simcards'];
  protected $icon = 'sim card';

  protected $appends = [
    'state',
    'location',
    'user',
    'group',
  ];

  protected $visible = [
    'state',
    'location',
    'user',
    'group',
  ];

  protected $with = [
    'state:id,name',
    'location:id,name',
    'user:id,name',
    'group:id,name',
  ];


  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\State');
  }

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location');
  }

  public function user(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User');
  }

  public function group(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group');
  }
}
