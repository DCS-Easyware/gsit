<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Savedsearch extends Common
{
  protected $definition = '\App\Models\Definitions\Savedsearch';
  protected $titles = ['Saved search', 'Saved searches'];
  protected $icon = 'bookmark';

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
