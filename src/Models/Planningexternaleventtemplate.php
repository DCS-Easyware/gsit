<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Planningexternaleventtemplate extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Planningexternaleventtemplate';
  protected $titles = ['External events template', 'External events templates'];
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
    return $this->belongsTo('\App\Models\Planningeventcategory');
  }
}
