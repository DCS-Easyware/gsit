<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminder extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Reminder';
  protected $titles = ['Reminder', 'Reminders'];
  protected $icon = 'sticky note';

  protected $appends = [
    'user',
  ];

  protected $visible = [
    'user',
  ];

  protected $with = [
    'user:id,name',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User');
  }
}
