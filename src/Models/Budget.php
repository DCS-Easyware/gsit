<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Common
{
  protected $table = 'glpi_budgets';
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
    return $this->belongsTo('\App\Models\Location', 'locations_id');
  }

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\BudgetType', 'budgettypes_id');
  }


}
