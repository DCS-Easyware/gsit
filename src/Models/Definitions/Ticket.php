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
        'values' => self::getStatusArray(),
      ],
      [
        'id'    => 10,
        'title' => $translator->translate('Urgency'),
        'type'  => 'dropdown',
        'name'  => 'urgency',
        'values' => self::getUrgencyArray(),
      ],
      [
        'id'    => 11,
        'title' => $translator->translate('Impact'),
        'type'  => 'dropdown',
        'name'  => 'impact',
        'values' => self::getImpactArray(),
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('Priority'),
        'type'  => 'dropdown',
        'name'  => 'priority',
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
      // [
      //   'id'    => 7,
      //   'title' => $translator->translate('Category'),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'itilvategories_id',
      //   'itemtype' => '\App\Models\ITILCategory',
      // ],
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
        'name'  => 'users_id_lastupdater',
        'itemtype' => '\App\Models\User',
      ],
      // [
      //   'id'    => 4,
      //   'title' => $translator->translatePlural('Requester', 'Requesters', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'requester_name',
      //   'itemtype' => '\App\Models\User',
      //   'relationship' => 'many-to-many',
      //   'foreignkey' => 'users_id',
      //   'pivotitemtype' => '\App\Models\TicketUser',
      //   'pivotfilters' => ['type' => '1'],
      // ]
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

}
