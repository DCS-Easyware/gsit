<?php

namespace App\Models\Definitions;

class Ticket
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 1,
        'title' => $translator->translate('Title'),
        'type'  => 'input',
        'name'  => 'name',
      ],
      [
        'id'    => 21,
        'title' => $translator->translate('Description'),
        'type'  => 'textarea',
        'name'  => 'content',
      ],
      [
        'id'    => 12,
        'title' => $translator->translate('Status'),
        'type'  => 'dropdown',
        'name'  => 'status',
        'dbname'  => 'status',
        'values' => self::getStatusArray(),
      ],
      [
        'id'    => 10,
        'title' => $translator->translate('Urgency'),
        'type'  => 'dropdown',
        'name'  => 'urgency',
        'dbname'  => 'urgency',
        'values' => self::getUrgencyArray(),
      ],
      [
        'id'    => 11,
        'title' => $translator->translate('Impact'),
        'type'  => 'dropdown',
        'name'  => 'impact',
        'dbname'  => 'impact',
        'values' => self::getImpactArray(),
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('Priority'),
        'type'  => 'dropdown',
        'name'  => 'priority',
        'dbname'  => 'priority',
        'values' => self::getPriorityArray(),
      ],
      [
        'id'    => 15,
        'title' => $translator->translate('Opening date'),
        'type'  => 'datetime',
        'name'  => 'date',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Closing date'),
        'type'  => 'datetime',
        'name'  => 'closedate',
      ],
      [
        'id'    => 18,
        'title' => $translator->translate('Time to resolve'),
        'type'  => 'datetime',
        'name'  => 'time_to_resolve',
      ],
      // [
      //   'id'    => 82,
      //   'title' => $translator->translate('Time to resolve exceeded'),
      //   'type'  => 'boolean',
      //   'name'  => 'is_late',
      // ],
      [
        'id'    => 17,
        'title' => $translator->translate('Resolution date'),
        'type'  => 'datetime',
        'name'  => 'solvedate',
      ],
      [
        'id'    => 19,
        'title' => $translator->translate('Last update'),
        'type'  => 'datetime',
        'name'  => 'date_mod',
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Category'),
        'type'  => 'dropdown_remote',
        'name'  => 'itilcategories_id',
        'dbname' => 'itilcategories_id',
        'itemtype' => '\App\Models\ITILCategory',
      ],
      [
        'id'    => 45,
        'title' => $translator->translate('Total duration'),
        'type'  => 'input',
        'name'  => 'actiontime',
      ],
      [
        'id'    => 64,
        'title' => $translator->translate('Last edit by'),
        'type'  => 'dropdown_remote',
        'name'  => 'usersidlastupdater',
        'dbname' => 'users_id_lastupdater',
        'itemtype' => '\App\Models\User',
      ],
      [
        'id'    => 4,
        'title' => $translator->translatePlural('Requester', 'Requesters', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'requester',
        'itemtype' => '\App\Models\User',
        'multiple' => true,
        'pivot' => ['type' => 1],
      ],
      [
        'id'    => 71,
        'title' => $translator->translatePlural('Requester group', 'Requester groups', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'requestergroup',
        'itemtype' => '\App\Models\Group',
        'multiple' => true,
        'pivot' => ['type' => 1],
      ],
      [
        'id'    => 22,
        'title' => $translator->translate('Writer'),
        'type'  => 'dropdown_remote',
        'name'  => 'usersidrecipient',
        'dbname'  => 'users_id_recipient',
        'itemtype' => '\App\Models\User',
      ],
      [
        'id'    => 66,
        'title' => $translator->translatePlural('Watcher', 'Watchers', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'watcher',
        'itemtype' => '\App\Models\User',
        'multiple' => true,
        'pivot' => ['type' => 3],
      ],
      [
        'id'    => 65,
        'title' => $translator->translatePlural('Watcher group', 'Watcher groups', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'watchergroup',
        'itemtype' => '\App\Models\Group',
        'multiple' => true,
        'pivot' => ['type' => 3],
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Technician'),
        'type'  => 'dropdown_remote',
        'name'  => 'technician',
        'itemtype' => '\App\Models\User',
        'multiple' => true,
        'pivot' => ['type' => 2],
      ],
      // [ TODO supplier
      //   'id'    => 6,
      //   'title' => $translator->translate('Assigned to a supplier'),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'technician',
      //   'itemtype' => '\App\Models\User',
      //   'multiple' => true,
      // ],
      [
        'id'    => 8,
        'title' => $translator->translate('Technician group'),
        'type'  => 'dropdown_remote',
        'name'  => 'techniciangroup',
        'itemtype' => '\App\Models\Group',
        'multiple' => true,
        'pivot' => ['type' => 2],
      ],
    ];

    // TODO others like users



  }

  public static function getStatusArray()
  {
    global $translator;

    return [
      1 => [
        'title' => $translator->translate('New'),
        'displaystyle' => 'marked',
        'color' => 'olive',
        'icon'  => 'book open',
      ],
      2 => [
        'title' => $translator->translate('Processing (assigned)'),
        'displaystyle' => 'marked',
        'color' => 'blue',
        'icon'  => 'book reader',
      ],
      3 => [
        'title' => $translator->translate('Processing (planned)'),
        'displaystyle' => 'marked',
        'color' => 'blue',
        'icon'  => 'business time',
      ],
      4 => [
        'title' => $translator->translate('Pending'),
        'displaystyle' => 'marked',
        'color' => 'grey',
        'icon'  => 'pause',
      ],
      5 => [
        'title' => $translator->translate('Solved'),
        'displaystyle' => 'marked',
        'color' => 'purple',
        'icon'  => 'vote yea',
      ],
      6 => [
        'title' => $translator->translate('Closed'),
        'displaystyle' => 'marked',
        'color' => 'brown',
        'icon'  => 'archive',
      ],
    ];
  }

  public static function getUrgencyArray()
  {
    global $translator;

    return [
      5 => [
        'title' => $translator->translate('Very high'),
      ],
      4 => [
        'title' => $translator->translate('High'),
      ],
      3 => [
        'title' => $translator->translate('Medium'),
      ],
      2 => [
        'title' => $translator->translate('Low'),
      ],
      1 => [
        'title' => $translator->translate('Very low'),
      ],
    ];
  }

  public static function getImpactArray()
  {
    global $translator;

    return [
      5 => [
        'title' => $translator->translate('Very high'),
      ],
      4 => [
        'title' => $translator->translate('High'),
      ],
      3 => [
        'title' => $translator->translate('Medium'),
      ],
      2 => [
        'title' => $translator->translate('Low'),
      ],
      1 => [
        'title' => $translator->translate('Very low'),
      ],
    ];
  }

  public static function getPriorityArray()
  {
    global $translator;

    return [
      6 => [
        'title' => $translator->translate('Major'),
        'color' => 'gsitmajor',
        'icon'  => 'fire extinguisher',
      ],
      5 => [
        'title' => $translator->translate('Very high'),
        'color' => 'gsitveryhigh',
        'icon'  => 'fire alternate',
      ],
      4 => [
        'title' => $translator->translate('High'),
        'color' => 'gsithigh',
        'icon'  => 'fire',
      ],
      3 => [
        'title' => $translator->translate('Medium'),
        'color' => 'gsitmedium',
        'icon'  => 'volume up',
      ],
      2 => [
        'title' => $translator->translate('Low'),
        'color' => 'gsitlow',
        'icon'  => 'volume down',
      ],
      1 => [
        'title' => $translator->translate('Very low'),
        'color' => 'gsitverylow',
        'icon'  => 'volume off',
      ],
    ];
  }

  public static function getRelatedPages()
  {
    global $translator;

    return [
      [
        'title' => 'Statisques',
        'icon' => 'chartline',
        'link' => '',
      ],
      [
        'title' => 'Validations',
        'icon' => 'thumbs up',
        'link' => '',
      ],
      [
        'title' => 'Base de connaissances',
        'icon' => 'book',
        'link' => '',
      ],
      [
        'title' => 'Elements',
        'icon' => 'desktop',
        'link' => '',
      ],
      [
        'title' => 'Coûts',
        'icon' => 'money bill alternate',
        'link' => '',
      ],
      [
        'title' => 'Projets',
        'icon' => 'folder open',
        'link' => '',
      ],
      [
        'title' => 'Tâches de projets',
        'icon' => 'tasks',
        'link' => '',
      ],
      [
        'title' => 'Problèmes',
        'icon' => 'drafting compass',
        'link' => '',
      ],
      [
        'title' => 'Changements',
        'icon' => 'paint roller',
        'link' => '',
      ],
      [
        'title' => 'Historique',
        'icon' => 'history',
        'link' => '',
      ],
    ];
  }
}
