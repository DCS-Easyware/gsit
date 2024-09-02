<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Change extends Common
{
  protected $table = 'glpi_changes';
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
