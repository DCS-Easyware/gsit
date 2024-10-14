<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enclosuremodel extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Enclosuremodel';
  protected $titles = ['Enclosure model', 'Enclosure models'];
  protected $icon = 'edit';
}
