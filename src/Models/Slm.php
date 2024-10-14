<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slm extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Slm';
  protected $titles = ['Service level', 'Service levels'];
  protected $icon = 'edit';

  protected $appends = [
    'calendar',
  ];

  protected $visible = [
    'calendar',
  ];

  protected $with = [
    'calendar:id,name',
  ];

  public function calendar(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Calendar');
  }
}
