<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Businesscriticity extends Common
{
  protected $definition = '\App\Models\Definitions\Businesscriticity';
  protected $titles = ['Business criticity', 'Business criticities'];
  protected $icon = 'edit';

  protected $appends = [
    'category',
  ];

  protected $visible = [
    'category',
  ];

  protected $with = [
    'category:id,name',
  ];

  public function category(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Businesscriticity');
  }
}
