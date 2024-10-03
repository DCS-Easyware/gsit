<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enclosuremodel extends Common
{
  protected $definition = '\App\Models\Definitions\Enclosuremodel';
  protected $titles = ['Enclosure model', 'Enclosure models'];
  protected $icon = 'edit';
}
