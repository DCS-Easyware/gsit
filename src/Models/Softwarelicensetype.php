<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Softwarelicensetype extends Common
{
  protected $definition = '\App\Models\Definitions\Softwarelicensetype';
  protected $titles = ['License type', 'License types'];
  protected $icon = 'edit';

  protected $appends = [
    'softwarelicensetype',
  ];

  protected $visible = [
    'softwarelicensetype',
  ];

  protected $with = [
    'softwarelicensetype:id,name',
  ];

  public function softwarelicensetype(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Softwarelicensetype');
  }
}
