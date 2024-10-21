<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Change extends Common
{
  use SoftDeletes;

  protected $definition = '\App\Models\Definitions\Change';
  protected $titles = ['Change', 'Changes'];
  protected $icon = 'clipboard check';

  protected $appends = [
    'itilcategorie',
    'usersidlastupdater',
    'usersidrecipient',
  ];

  protected $visible = [
    'itilcategorie',
    'usersidlastupdater',
    'usersidrecipient',
  ];

  protected $with = [
    'itilcategorie:id,name',
    'usersidlastupdater:id,name',
    'usersidrecipient:id,name',
  ];

  public function itilcategorie(): BelongsTo
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
