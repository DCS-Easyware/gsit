<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rssfeed extends Common
{
  protected $table = 'glpi_rssfeeds';
  protected $definition = '\App\Models\Definitions\Rssfeed';
  protected $titles = ['RSS feed', 'RSS feed'];
  protected $icon = 'rss';

  protected $appends = [
    'user',
  ];

  protected $visible = [
    'user',
  ];

  protected $with = [
    'user:id,name',
  ];


  public function user(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id');
  }

}
