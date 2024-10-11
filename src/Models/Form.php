<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Common
{
  protected $table = 'glpi_plugin_formcreator_forms';
  protected $definition = '\App\Models\Definitions\Form';
  protected $titles = ['Form', 'Forms'];
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
    return $this->belongsTo('\App\Models\FormCategory', 'plugin_formcreator_categories_id');
  }
}
