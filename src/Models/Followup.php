<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Followup extends Common
{
  use SoftDeletes;

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
