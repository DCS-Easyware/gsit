<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Link extends Common
{
  protected $definition = '\App\Models\Definitions\Link';
  protected $titles = ['External link', 'External links'];
  protected $icon = 'edit';
}
