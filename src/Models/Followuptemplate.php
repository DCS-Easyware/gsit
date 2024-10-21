<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Followuptemplate extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Followuptemplate';
  protected $titles = ['Followup template', 'Followup templates'];
  protected $icon = 'edit';

  protected $appends = [
    'source',
  ];

  protected $visible = [
    'source',
  ];

  protected $with = [
    'source:id,name',
  ];

  public function source(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Requesttype');
  }
}
