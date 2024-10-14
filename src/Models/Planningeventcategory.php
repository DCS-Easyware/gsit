<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Planningeventcategory extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Planningeventcategory';
  protected $titles = ['Event category', 'Event categories'];
  protected $icon = 'edit';
}
