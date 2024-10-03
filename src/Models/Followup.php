<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Followup extends Common
{
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
    return $this->belongsTo('\App\Models\User');
  }
}
