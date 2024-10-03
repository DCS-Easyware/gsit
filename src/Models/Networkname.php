<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Networkname extends Common
{
  protected $definition = '\App\Models\Definitions\Networkname';
  protected $titles = ['Network name', 'Network names'];
  protected $icon = 'edit';

  protected $appends = [
    'fqdn',
  ];

  protected $visible = [
    'fqdn',
  ];

  protected $with = [
    'fqdn:id,name',
  ];

  public function fqdn(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Fqdn');
  }
}
