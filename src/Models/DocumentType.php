<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentType extends Common
{
  protected $table = 'glpi_documenttypes';
  protected $definition = '\App\Models\Definitions\DocumentType';
  protected $titles = ['Document type', 'Document types'];
  protected $icon = 'edit';

}
