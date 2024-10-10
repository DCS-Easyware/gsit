<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Problem extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Problem';
  protected $titles = ['Problem', 'Problems'];
  protected $icon = 'exclamation triangle';

  protected $appends = [
    // 'category',
    // 'usersidlastupdater',
    // 'usersidrecipient',
  ];

  protected $visible = [
    'id',
    'name',
    'created_at',
    'updated_at',
    'category',
    'usersidlastupdater',
    'usersidrecipient',
  ];

  protected $with = [
    'category:id,name',
    'usersidlastupdater:id,name',
    'usersidrecipient:id,name',
  ];

  public function category(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Category');
  }

  public function usersidlastupdater(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'user_id_lastupdater');
  }

  public function usersidrecipient(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'user_id_recipient');
  }
}
