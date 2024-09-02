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
    'usersidlastupdater',
    'usersidrecipient',
    'itilcategorie',
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
    'itilcategorie',
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
    'itilcategorie:id,name',
  ];


  public static function boot()
  {
    parent::boot();

    static::creating(function ($model)
    {
    });

    static::updating(function ($model)
    {
      $currentItem = \App\Models\Ticket::find($model->id);
      // Clean new lines before passing to rules
      if (property_exists($model, 'content'))
      {
        $model->content = preg_replace('/\\\\r\\\\n/', "\n", $model->content);
        $model->content = preg_replace('/\\\\n/', "\n", $model->content);
      }

      // automatic recalculate if user changes urgence or technician change impact
      // $canpriority = Session::haveRight($this->rightname, self::CHANGEPRIORITY);
      $canpriority = true;
      if ($model->urgency != $currentItem->urgency ||
        $model->impact != $currentItem->impact &&
        ($canpriority && !$model->isDirty('priority') || !$canpriority)
      )
      {
        $model->priority = \App\Controllers\Ticket::computePriority($model->urgency, $model->impact);
      }

      // TODO manage security, check if can't steal or own the ticket

      // TODO Manage template?

      // test rules, need write with old prepareInputtoupdate
      $input = [
        'name' => $model->name,
        'urgency' => $model->urgency,
        'priority' => $model->priority,
      ];
      $rule = new \App\Controllers\Rules\Ticket();
      $input = $rule->processAllRules(
        $input
      );

     // TODO finish
    });

    static::deleting(function ($model)
    {
    });

    // static::restoring(function ($model)
    // {
    // });

  }

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
    return $this->belongsTo('\App\Models\User', 'users_id_lastupdater');
  }

  public function usersidrecipient(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'users_id_recipient');
  }

  public function itilcategorie(): BelongsTo
  {
    return $this->belongsTo('\App\Models\ITILCategory', 'itilcategories_id');
  }
}
