<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentCategory extends Common
{
  protected $table = 'glpi_documentcategories';
  protected $definition = '\App\Models\Definitions\DocumentCategory';
  protected $titles = ['Document heading', 'Document headings'];
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
    return $this->belongsTo('\App\Models\DocumentCategory', 'documentcategories_id');
  }

}
