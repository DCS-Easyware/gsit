<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

  public function getFeeds($id)
  {
    $feeds = [];

    $statesDef = $this->definition::getStatusArray();

    // Get followups
    $followups = \App\Models\Itilfollowup::where('itemtype', 'Ticket')->where('items_id', $id)->get();
    foreach ($followups as $followup)
    {
      
      $feeds[] = [
        "user"     => $followup->user->completename,
        "usertype" => "tech",
        "type"     => "followup",
        "date"     => $followup['date_creation'],
        "summary"  => "added a followup",
        "content"  => $followup['content'],
        "time"     => null,
      ];
    }
    // Get important events:
    // * state changes
    // * user / group attribution
    $states = \App\Models\Log::where('itemtype', 'Ticket')->where('items_id', $id)->where('id_search_option', 12)->get();
    foreach ($states as $state)
    {
      $userActionSpl = explode(" (", $state['user_name']);

      $feeds[] = [
        "user"     => $userActionSpl[0],
        "usertype" => "tech",
        "type"     => "event",
        "date"     => $state['date_mod'],
        "summary"  => "changed state to " . $statesDef[$state['new_value']]['title'],
        "content"  => "",
        "time"     => null,
      ];
    }

    $userAttributes = \App\Models\Log::where('itemtype', 'Ticket')->where('items_id', $id)->where('id_search_option', 5)->get();
    foreach ($userAttributes as $userAttr)
    {
      $userActionSpl = explode(" (", $userAttr['user_name']);
      $userSpl = explode(" (", $userAttr['new_value']);

      $feeds[] = [
        "user"     => $userActionSpl[0],
        "usertype" => "tech",
        "type"     => "event",
        "date"     => $userAttr['date_mod'],
        "summary"  => "add attribution to the user " . $userSpl[0],
        "content"  => "",
        "time"     => null,
      ];
    }

    $groupAttributes = \App\Models\Log::where('itemtype', 'Ticket')->where('items_id', $id)->where('id_search_option', 8)->get();
    foreach ($groupAttributes as $groupAttr)
    {
      $userActionSpl = explode(" (", $userAttr['user_name']);
      $groupSpl = explode(" (", $userAttr['new_value']);

      $feeds[] = [
        "user"     => $userActionSpl[0],
        "usertype" => "tech",
        "type"     => "event",
        "date"     => $userAttr['date_mod'],
        "summary"  => "add attribution to the group " . $groupSpl[0],
        "content"  => "",
        "time"     => null,
      ];
    }

    // sort
    usort($feeds, function ($a, $b) {return $a['date'] > $b['date'];});

    return $feeds;

    // return [
    //   [
    //     "user"     => "David Durieux",
    //     "usertype" => "tech",
    //     "type"     => "followup",
    //     "date"     => "5 days ago",
    //     "summary"  => "added a followup",
    //     "content"  => "Pouvez-vous préciser l'erreur que vous avez?",
    //     "time"     => 75,
    //   ],
    //   [
    //     "user"     => "Joe Henderson",
    //     "usertype" => "user",
    //     "type"     => "followup",
    //     "date"     => "3 days ago",
    //     "summary"  => "added a followup",
    //     "content"  => "finalement c'est bon, ça refonctionne",
    //     "time"     => null,
    //   ],
    //   [
    //     "user"     => "David Durieux",
    //     "usertype" => "tech",
    //     "type"     => "state",
    //     "date"     => "2 days ago",
    //     "summary"  => "set state as closed",
    //     "content"  => null,
    //     "time"     => null,
    //   ],
    // ];
  }

  /**
   * Get the color of the status of the ticket
   */
  public function getColor()
  {
    $statesDef = $this->definition::getStatusArray();
    return $statesDef[$this->status]['color'];
  }
}
