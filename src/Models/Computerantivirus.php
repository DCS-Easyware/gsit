<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Computerantivirus extends Common
{
  protected $table = 'computerantiviruses';
  protected $definition = '\App\Models\Definitions\Computerantivirus';
  protected $titles = ['Antivirus', 'Antivirus'];
  protected $icon = 'virus slash';

  protected $appends = [
  ];

  protected $visible = [
  ];

  protected $with = [
  ];

  protected $fillable = [
    'name',
    'computer_id',
  ];

  public function computer(): BelongsTo
  {
    return $this->belongsTo('App\Models\Computer');
  }
}
