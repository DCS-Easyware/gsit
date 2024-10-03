<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Planningeventcategory extends Common
{
  protected $definition = '\App\Models\Definitions\Planningeventcategory';
  protected $titles = ['Event category', 'Event categories'];
  protected $icon = 'edit';
}
