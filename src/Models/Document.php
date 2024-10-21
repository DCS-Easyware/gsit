<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Document';
  protected $titles = ['Document', 'Documents'];
  protected $icon = 'file';

  protected $appends = [
    'categorie',
  ];

  protected $visible = [
    'categorie',
  ];

  protected $with = [
    'categorie:id,name',
  ];

  public function categorie(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Documentcategory');
  }
}
