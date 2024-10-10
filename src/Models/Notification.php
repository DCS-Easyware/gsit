<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Notification';
  protected $titles = ['Notification', 'Notifications'];
  protected $icon = 'edit';
}
