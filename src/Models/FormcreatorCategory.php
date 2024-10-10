<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormcreatorCategory extends Common
{
  use SoftDeletes;

  protected $table = 'glpi_plugin_formcreator_categories';
  protected $definition = '\App\Models\Definitions\FormcreatorCategory';
  protected $titles = ['Form category', 'Form categories'];
  protected $icon = 'edit';

  protected $appends = [
    'knowbaseitemcategory',
    'category',
  ];

  protected $visible = [
    'knowbaseitemcategory',
    'category',
  ];

  protected $with = [
    'knowbaseitemcategory:id,name',
    'category:id,name',
  ];

  public function knowbaseitemcategory(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Knowbaseitemcategory');
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo('\App\Models\FormcreatorCategory', 'plugin_formcreator_categories_id');
  }
}
