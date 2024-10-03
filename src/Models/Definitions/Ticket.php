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
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Category'),
        'type'  => 'dropdown_remote',
        'name'  => 'category',
        'dbname' => 'categorie_id',
        'itemtype' => '\App\Models\Category',
      ],
      [
        'id'    => 45,
        'title' => $translator->translate('Total duration'),
        'type'  => 'dropdown',
        'name'  => 'actiontime',
        'dbname'  => 'actiontime',
        'values' => self::getTimestampArray(
          [
            'addfirstminutes' => true
          ]
        ),
        // 'type'  => 'input',
        // 'name'  => 'actiontime',
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
      /**/
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
        'title' => $translator->translate('status' . "\004" . 'Processing (assigned)'),
        'displaystyle' => 'marked',
        'color' => 'blue',
        'icon'  => 'book reader',
      ],
      3 => [
        'title' => $translator->translate('status' . "\004" . 'Processing (planned)'),
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
        'title' => $translator->translate('urgency' . "\004" . 'Very high'),
      ],
      4 => [
        'title' => $translator->translate('urgency' . "\004" . 'High'),
      ],
      3 => [
        'title' => $translator->translate('urgency' . "\004" . 'Medium'),
      ],
      2 => [
        'title' => $translator->translate('urgency' . "\004" . 'Low'),
      ],
      1 => [
        'title' => $translator->translate('urgency' . "\004" . 'Very low'),
      ],
    ];
  }

  public static function getImpactArray()
  {
    global $translator;
    return [
      5 => [
        'title' => $translator->translate('impact' . "\004" . 'Very high'),
      ],
      4 => [
        'title' => $translator->translate('impact' . "\004" . 'High'),
      ],
      3 => [
        'title' => $translator->translate('impact' . "\004" . 'Medium'),
      ],
      2 => [
        'title' => $translator->translate('impact' . "\004" . 'Low'),
      ],
      1 => [
        'title' => $translator->translate('impact' . "\004" . 'Very low'),
      ],
    ];
  }

  public static function getPriorityArray()
  {
    global $translator;
    return [
      6 => [
        'title' => $translator->translate('priority' . "\004" . 'Major'),
        'color' => 'gsitmajor',
        'icon'  => 'fire extinguisher',
      ],
      5 => [
        'title' => $translator->translate('priority' . "\004" . 'Very high'),
        'color' => 'gsitveryhigh',
        'icon'  => 'fire alternate',
      ],
      4 => [
        'title' => $translator->translate('priority' . "\004" . 'High'),
        'color' => 'gsithigh',
        'icon'  => 'fire',
      ],
      3 => [
        'title' => $translator->translate('priority' . "\004" . 'Medium'),
        'color' => 'gsitmedium',
        'icon'  => 'volume up',
      ],
      2 => [
        'title' => $translator->translate('priority' . "\004" . 'Low'),
        'color' => 'gsitlow',
        'icon'  => 'volume down',
      ],
      1 => [
        'title' => $translator->translate('priority' . "\004" . 'Very low'),
        'color' => 'gsitverylow',
        'icon'  => 'volume off',
      ],
    ];
  }

  public static function getTimestampArray($options = [])
  {
    global $translator;

    $MINUTE_TIMESTAMP = 60;
    $HOUR_TIMESTAMP = 3600;
    $DAY_TIMESTAMP = 86400;
    $WEEK_TIMESTAMP = 604800;
    $MONTH_TIMESTAMP = 2592000;


    $params = [];
    $params['min']                 = 0;
    $params['max']                 = $DAY_TIMESTAMP;
    $params['step']                = 5 * $MINUTE_TIMESTAMP;
    $params['addfirstminutes']     = false;
    $params['toadd']               = [];
    $params['inhours']             = false;

    if (is_array($options) && count($options))
    {
      foreach ($options as $key => $val)
      {
        $params[$key] = $val;
      }
    }

    $params['min'] = floor($params['min'] / $params['step']) * $params['step'];

    if ($params['min'] == 0)
    {
      $params['min'] = $params['step'];
    }

    $values = [];

    if ($params['addfirstminutes'])
    {
      $max = max($params['min'], 10 * $MINUTE_TIMESTAMP);
      for ($i = $MINUTE_TIMESTAMP; $i < $max; $i += $MINUTE_TIMESTAMP)
      {
        $values[$i] = '';
      }
    }

    for ($i = $params['min']; $i <= $params['max']; $i += $params['step'])
    {
      $values[$i] = '';
    }

    if (count($params['toadd']))
    {
      foreach ($params['toadd'] as $key)
      {
        $values[$key] = '';
      }
      ksort($values);
    }

    foreach ($values as $i => $val)
    {
      if (empty($val))
      {
        if ($params['inhours'])
        {
          $day  = 0;
          $hour = floor($i / $HOUR_TIMESTAMP);
        } else {
          $day  = floor($i / $DAY_TIMESTAMP);
          $hour = floor(($i % $DAY_TIMESTAMP) / $HOUR_TIMESTAMP);
        }
        $minute     = floor(($i % $HOUR_TIMESTAMP) / $MINUTE_TIMESTAMP);
        if ($minute === '0')
        {
          $minute = '00';
        }
        $values[$i] = '';
        if ($day > 0)
        {
          if (($hour > 0) || ($minute > 0))
          {
            if ($minute < 10)
            {
              $minute = '0' . $minute;
            }

            //TRANS: %1$d is the number of days, %2$d the number of hours,
            //       %3$s the number of minutes : display 1 day 3h15
            $values[$i] = sprintf(
              $translator->translatePlural('%1$d day %2$dh%3$s', '%1$d days %2$dh%3$s', $day),
              $day,
              $hour,
              $minute
            );
          } else {
              $values[$i] = sprintf($translator->translatePlural('%d day', '%d days', $day), $day);
          }
        } elseif ($hour > 0 || $minute > 0)
        {
          if ($minute < 10)
          {
              $minute = '0' . $minute;
          }

          //TRANS: %1$d the number of hours, %2$s the number of minutes : display 3h15
          $values[$i] = sprintf($translator->translate('%1$dh%2$s'), $hour, $minute);
        }
      }
    }

    $tab = [];
    foreach (array_keys($values) as $key)
    {
      $tab[$key]['title'] = $values[$key];
    }
    return $tab;
  }

  public static function getRelatedPages()
  {
    global $translator;
    return [
      [
        'title' => $translator->translate('Statistics'),
        'icon' => 'chartline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Approval', 'Approvals', 2),
        'icon' => 'thumbs up',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Knowledge base'),
        'icon' => 'book',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Item', 'Items', 2),
        'icon' => 'desktop',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Cost', 'Costs', 2),
        'icon' => 'money bill alternate',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Project', 'Projects', 2),
        'icon' => 'folder open',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Project task', 'Project tasks', 2),
        'icon' => 'tasks',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Problem', 'Problems', 2),
        'icon' => 'drafting compass',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Change', 'Changes', 2),
        'icon' => 'paint roller',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => '',
      ],
    ];
  }
}
