<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solutiontemplate extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Solutiontemplate';
  protected $titles = ['Solution template', 'Solution templates'];
  protected $icon = 'edit';

  protected $appends = [
    'types',
  ];

  protected $visible = [
    'types',
  ];

  protected $with = [
    'types:id,name',
  ];

  public function types(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Solutiontype');
  }
}
