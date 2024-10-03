<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Notificationtemplate extends Common
{
  protected $definition = '\App\Models\Definitions\Notificationtemplate';
  protected $titles = ['Notification template', 'Notification templates'];
  protected $icon = 'edit';
}
