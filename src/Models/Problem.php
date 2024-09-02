<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Problem extends Common
{
  protected $table = 'glpi_problems';
  protected $definition = '\App\Models\Definitions\Problem';
  protected $titles = ['Problem', 'Problems'];
  protected $icon = 'exclamation triangle';

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
    return $this->belongsTo('\App\Models\ITILCategory', 'itilcategories_id');
  }

  public function usersidlastupdater(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id_lastupdater');
  }

  public function usersidrecipient(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id_recipient');
  }


}
