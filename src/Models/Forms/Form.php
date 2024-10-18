<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends \App\Models\Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Forms\Form';
  protected $titles = ['Form', 'Forms'];
  protected $icon = 'cubes';

  protected $visible = [
    'category',
  ];

  protected $with = [
    'category:id,name',
  ];

  public function category(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Category');
  }

  public function sections(): BelongsToMany
  {
    return $this->belongsToMany('\App\Models\Forms\Section');
  }
}
