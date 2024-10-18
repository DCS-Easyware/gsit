<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Taskcategory extends Common
{
  protected $definition = '\App\Models\Definitions\Taskcategory';
  protected $titles = ['Task category', 'Task categories'];
  protected $icon = 'edit';

  protected $appends = [
    'category',
    'knowbaseitemcategories',
  ];

  protected $visible = [
    'category',
    'knowbaseitemcategories',
  ];

  protected $with = [
    'category:id,name',
    'knowbaseitemcategories:id,name',
  ];

  public function category(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Taskcategory');
  }

  public function knowbaseitemcategories(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Knowbaseitemcategory');
  }
}
