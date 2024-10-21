<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projecttask extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Projecttask';
  protected $titles = ['Project task', 'Project tasks'];
  protected $icon = 'edit';
}
