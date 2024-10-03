<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Documenttype extends Common
{
  protected $definition = '\App\Models\Definitions\Documenttype';
  protected $titles = ['Document type', 'Document types'];
  protected $icon = 'edit';
}
