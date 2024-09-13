<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Netpoint extends Common
{
  protected $table = 'glpi_netpoints';
  protected $definition = '\App\Models\Definitions\Netpoint';
  protected $titles = ['Network outlet', 'Network outlets'];
  protected $icon = 'edit';

  protected $appends = [
    'location',
  ];

  protected $visible = [
    'location',
  ];

  protected $with = [
    'location:id,name',
  ];

  public function location(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Location', 'locations_id');
  }

}
