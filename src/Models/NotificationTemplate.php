<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotificationTemplate extends Common
{
  protected $table = 'glpi_notificationtemplates';
  protected $definition = '\App\Models\Definitions\NotificationTemplate';
  protected $titles = ['Notification template', 'Notification templates'];
  protected $icon = 'edit';

}
