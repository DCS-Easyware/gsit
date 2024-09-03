<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Itilfollowup extends Common
{
  protected $table = 'glpi_itilfollowups';

  protected $appends = [
    'user',
  ];

  protected $visible = [
    'user',
  ];

  protected $with = [
    'user',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id');
  }
}
