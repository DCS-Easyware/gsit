<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Common
{
  use SoftDeletes;

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
    'category',
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
    'category',
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
    'category:id,name',
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
    return $this->belongsToMany('\App\Models\User')->wherePivot('type', 1);
  }

  public function requestergroup()
  {
    return $this->belongsToMany('\App\Models\Group')->wherePivot('type', 1);
  }

  public function watcher()
  {
    return $this->belongsToMany('\App\Models\User')->wherePivot('type', 3);
  }

  public function watchergroup()
  {
    return $this->belongsToMany('\App\Models\Group')->wherePivot('type', 3);
  }

  public function technician()
  {
    return $this->belongsToMany('\App\Models\User')->wherePivot('type', 2);
  }

  public function techniciangroup()
  {
    return $this->belongsToMany('\App\Models\Group')->wherePivot('type', 2);
  }

  public function usersidlastupdater(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'user_id_lastupdater');
  }

  public function usersidrecipient(): BelongsTo
  {
    return $this->belongsTo('\App\Models\User', 'user_id_recipient');
  }

  public function category(): BelongsTo
  {
    return $this->belongsTo('\App\Models\Category', 'category_id');
  }

  public function getFeeds($id)
  {
    $feeds = [];

    $statesDef = $this->definition::getStatusArray();

    $itemtypes = ['Ticket', 'App\Models\Ticket', 'App\Models\Ticket'];

    // Get followups
    $followups = \App\Models\Followup::whereIn('item_type', $itemtypes)->where('item_id', $id)->get();
    foreach ($followups as $followup)
    {
      $feeds[] = [
        "user"     => $followup->user->completename,
        "usertype" => "tech",
        "type"     => "followup",
        "date"     => $followup['created_at'],
        "summary"  => "added a followup",
        "content"  => \App\v1\Controllers\Toolbox::convertMarkdownToHtml($followup['content']),
        "time"     => null,
      ];
    }
    // Get important events:
    // * state changes
    // * user / group attribution

    $states = \App\Models\Log::
        whereIn('item_type', $itemtypes)
      ->where('item_id', $id)
      ->where('id_search_option', 12)
      ->get();
    foreach ($states as $state)
    {
      $userActionSpl = explode(" (", $state['user_name']);
      $stateDef = $statesDef[$state['new_value']];
      $feeds[] = [
        "user"     => $userActionSpl[0],
        "usertype" => "tech",
        "type"     => "event",
        "date"     => $state['updated_at'],
        "summary"  => "changed state to <span class=\"ui " . $stateDef['color'] .
                      " text\"><i class=\"" . $stateDef['icon'] . " icon\"></i>" . $stateDef['title'] . "</span>",
        "content"  => "",
        "time"     => null,
      ];
    }

    $userAttributes = \App\Models\Log::
        whereIn('item_type', $itemtypes)
      ->where('item_id', $id)
      ->where('id_search_option', 5)
      ->get();
    foreach ($userAttributes as $userAttr)
    {
      $userActionSpl = explode(" (", $userAttr['user_name']);
      $userSpl = explode(" (", $userAttr['new_value']);

      $feeds[] = [
        "user"     => $userActionSpl[0],
        "usertype" => "tech",
        "type"     => "event",
        "date"     => $userAttr['updated_at'],
        "summary"  => "add attribution to the user " . $userSpl[0],
        "content"  => "",
        "time"     => null,
      ];
    }

    $groupAttributes = \App\Models\Log::
        whereIn('item_type', $itemtypes)
      ->where('item_id', $id)
      ->where('id_search_option', 8)
      ->get();
    foreach ($groupAttributes as $groupAttr)
    {
      $userActionSpl = explode(" (", $groupAttr['user_name']);
      if (!is_null($groupAttr['new_value']))
      {
        $groupSpl = explode(" (", $groupAttr['new_value']);
        $feeds[] = [
          "user"     => $userActionSpl[0],
          "usertype" => "tech",
          "type"     => "event",
          "date"     => $groupAttr['updated_at'],
          "summary"  => "add (+) attribution to the group " . $groupSpl[0],
          "content"  => "",
          "time"     => null,
        ];
      } else {
        $groupSpl = explode(" (", $groupAttr['old_value']);
        $feeds[] = [
          "user"     => $userActionSpl[0],
          "usertype" => "tech",
          "type"     => "event",
          "date"     => $groupAttr['updated_at'],
          "summary"  => "delete (-) attribution to the group " . $groupSpl[0],
          "content"  => "",
          "time"     => null,
        ];
      }
    }

    // sort
    usort($feeds, function ($a, $b)
    {
      return $a['date'] > $b['date'];
    });

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
