<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QueuedNotification extends Common
{
  protected $table = 'glpi_queuednotifications';
  protected $definition = '\App\Models\Definitions\QueuedNotification';
  protected $titles = ['Notification queue', 'Notification queue'];
  protected $icon = 'list alt';

  protected $appends = [
    'notificationtemplate',
  ];

  protected $visible = [
    'notificationtemplate',
  ];

  protected $with = [
    'notificationtemplate:id,name',
  ];

  public function notificationtemplate(): BelongsTo
  {
    return $this->belongsTo('\App\Models\NotificationTemplate', 'notificationtemplates_id');
  }
}
