<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskCategory extends Common
{
  protected $table = 'glpi_taskcategories';
  protected $definition = '\App\Models\Definitions\TaskCategory';
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
    return $this->belongsTo('\App\Models\TaskCategory', 'taskcategories_id');
  }

  public function knowbaseitemcategories(): BelongsTo
  {
    return $this->belongsTo('\App\Models\KnowbaseItemCategory', 'knowbaseitemcategories_id');
  }

}
