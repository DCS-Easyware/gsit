<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Budget';
  protected $titles = ['Budget', 'Budgets'];
  protected $icon = 'calculator';

  protected $appends = [
    'location',
    'type',
  ];

  protected $visible = [
    'location',
    'type',
  ];

  protected $with = [
    'location:id,name',
    'type:id,name',
  ];

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location');
  }

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Budgettype');
  }
}
