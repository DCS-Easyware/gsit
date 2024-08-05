<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Common
{
  protected $table = 'glpi_tickets';
  protected $definition = '\App\Models\Definitions\Ticket';
  protected $titles = ['Ticket', 'Tickets'];
  protected $icon = 'hands helping';

  protected $appends = [
    'requester',
    'requestergroup',
    'watcher',
    'watchergroup',
    'technician',
    'techniciangroup',
    'users_id_lastupdater',
    'usersidrecipient',
  ];

  protected $visible = [
    'requester',
    'requestergroup',
    'watcher',
    'watchergroup',
    'technician',
    'techniciangroup',
    'usersidlastupdater',
    'usersidrecipient',
  ];

  protected $with = [
    'requester:id,name',
    'requestergroup:id,name',
    'watcher:id,name',
    'watchergroup:id,name',
    'technician:id,name',
    'techniciangroup:id,name',
    'usersidlastupdater:id,name',
    'usersidrecipient:id,name',
  ];
  
  public function requester()
  {
      return $this->belongsToMany('\App\Models\User', 'glpi_tickets_users', 'tickets_id', 'users_id')->wherePivot('type', 1);
  }

  public function requestergroup()
  {
      return $this->belongsToMany('\App\Models\Group', 'glpi_groups_tickets', 'tickets_id', 'groups_id')->wherePivot('type', 1);
  }

  public function watcher()
  {
      return $this->belongsToMany('\App\Models\User', 'glpi_tickets_users', 'tickets_id', 'users_id')->wherePivot('type', 3);
  }

  public function watchergroup()
  {
      return $this->belongsToMany('\App\Models\Group', 'glpi_groups_tickets', 'tickets_id', 'groups_id')->wherePivot('type', 3);
  }

  public function technician()
  {
      return $this->belongsToMany('\App\Models\User', 'glpi_tickets_users', 'tickets_id', 'users_id')->wherePivot('type', 2);
  }

  public function techniciangroup()
  {
      return $this->belongsToMany('\App\Models\Group', 'glpi_groups_tickets', 'tickets_id', 'groups_id')->wherePivot('type', 2);
  }

  public function usersidlastupdater(): BelongsTo
  {
      return $this->belongsTo('\App\Models\User', 'users_id');
  }

  public function usersidrecipient(): BelongsTo
  {
      return $this->belongsTo('\App\Models\User', 'users_id');
  }

}
