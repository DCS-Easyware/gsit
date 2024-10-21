<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Contract';
  protected $titles = ['Contract', 'Contracts'];
  protected $icon = 'file signature';

  protected $appends = [
    'type',
    'state',
  ];

  protected $visible = [
    'type',
    'state',
  ];

  protected $with = [
    'type:id,name',
    'state:id,name',
  ];

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Contracttype');
  }

  public function state(): BelongsTo
  {
    return $this->belongsTo('\App\Models\State');
  }
}
