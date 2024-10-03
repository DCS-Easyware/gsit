<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projecttasktype extends Common
{
  protected $definition = '\App\Models\Definitions\Projecttasktype';
  protected $titles = ['Project tasks type', 'Project tasks types'];
  protected $icon = 'edit';
}
