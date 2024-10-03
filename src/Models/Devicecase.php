<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Devicecase extends Common
{
  protected $definition = '\App\Models\Definitions\Devicecase';
  protected $titles = ['Case', 'Cases'];
  protected $icon = 'edit';

  protected $appends = [
    'manufacturer',
    'type',
    'model',
  ];

  protected $visible = [
    'manufacturer',
    'type',
    'model',
  ];

  protected $with = [
    'manufacturer:id,name',
    'type:id,name',
    'model:id,name',
  ];

  public function manufacturer(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Manufacturer');
  }

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Devicecasetype');
  }

  public function model(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Devicecasemodel');
  }
}
