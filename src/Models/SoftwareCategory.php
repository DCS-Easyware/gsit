<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SoftwareCategory extends Common
{
  protected $table = 'glpi_softwarecategories';
  protected $definition = '\App\Models\Definitions\SoftwareCategory';
  protected $titles = ['Software category', 'Software categories'];
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
    return $this->belongsTo('\App\Models\SoftwareCategory', 'softwarecategories_id');
  }

}
