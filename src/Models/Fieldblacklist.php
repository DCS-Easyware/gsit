<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fieldblacklist extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Fieldblacklist';
  protected $titles = ['Ignored value for the unicity', 'Ignored values for the unicity'];
  protected $icon = 'edit';
}
