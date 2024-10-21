<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Queuednotification extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Queuednotification';
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
    return $this->belongsTo('\App\Models\Notificationtemplate');
  }
}
