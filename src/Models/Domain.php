<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domain extends Common
{
  protected $table = 'glpi_domains';
  protected $definition = '\App\Models\Definitions\Domain';
  protected $titles = ['Domain', 'Domains'];
  protected $icon = 'globe americas';

  protected $appends = [
    'type',
    'userstech',
    'groupstech',
  ];

  protected $visible = [
    'type',
    'userstech',
    'groupstech',
  ];

  protected $with = [
    'type:id,name',
    'userstech:id,name',
    'groupstech:id,name',
  ];

  public function type(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Domaintype', 'domaintypes_id');
  }

  public function userstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id_tech');
  }

  public function groupstech(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Group', 'groups_id_tech');
  }


}
