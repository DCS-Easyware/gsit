<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticketrecurrent extends Common
{
  protected $table = 'glpi_ticketrecurrents';
  protected $definition = '\App\Models\Definitions\Ticketrecurrent';
  protected $titles = ['Recurrent ticket', 'Recurrent tickets'];
  protected $icon = 'stopwatch';

  protected $appends = [
    // 'requester',
    // 'requestergroup',
    // 'watcher',
    // 'watchergroup',
    // 'technician',
    // 'techniciangroup',
    // 'usersidlastupdater',
    // 'usersidrecipient',
    // 'itilcategorie',
  ];

  protected $visible = [
    // 'requester',
    // 'requestergroup',
    // 'watcher',
    // 'watchergroup',
    // 'technician',
    // 'techniciangroup',
    // 'usersidlastupdater',
    // 'usersidrecipient',
    // 'itilcategorie',
  ];

  protected $with = [
    // 'requester:id,name',
    // 'requestergroup:id,name',
    // 'watcher:id,name',
    // 'watchergroup:id,name',
    // 'technician:id,name',
    // 'techniciangroup:id,name',
    // 'usersidlastupdater:id,name',
    // 'usersidrecipient:id,name',
    // 'itilcategorie:id,name',
  ];

  // public function requester()
  // {
  //   return $this->belongsToMany('\App\Models\User', 'glpi_tickets_users', 'tickets_id', 'users_id')->wherePivot('type', 1);
  // }

  // public function requestergroup()
  // {
  //   return $this->belongsToMany('\App\Models\Group', 'glpi_groups_tickets', 'tickets_id', 'groups_id')->wherePivot('type', 1);
  // }

  // public function watcher()
  // {
  //   return $this->belongsToMany('\App\Models\User', 'glpi_tickets_users', 'tickets_id', 'users_id')->wherePivot('type', 3);
  // }

  // public function watchergroup()
  // {
  //   return $this->belongsToMany('\App\Models\Group', 'glpi_groups_tickets', 'tickets_id', 'groups_id')->wherePivot('type', 3);
  // }

  // public function technician()
  // {
  //   return $this->belongsToMany('\App\Models\User', 'glpi_tickets_users', 'tickets_id', 'users_id')->wherePivot('type', 2);
  // }

  // public function techniciangroup()
  // {
  //   return $this->belongsToMany('\App\Models\Group', 'glpi_groups_tickets', 'tickets_id', 'groups_id')->wherePivot('type', 2);
  // }

  // public function usersidlastupdater(): BelongsTo
  // {
  //   return $this->belongsTo('\App\Models\User', 'users_id_lastupdater');
  // }

  // public function usersidrecipient(): BelongsTo
  // {
  //   return $this->belongsTo('\App\Models\User', 'users_id_recipient');
  // }

  // public function itilcategorie(): BelongsTo
  // {
  //   return $this->belongsTo('\App\Models\ITILCategory', 'itilcategories_id');
  // }

}
