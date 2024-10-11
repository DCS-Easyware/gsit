<?php

namespace App\Models\Definitions;

class Event
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 14,
        'title' => $translator->translate('Source'),
        'type'  => 'dropdown',
        'name'  => 'type',
        'dbname'  => 'type',
        'values' => self::getTypeArray(),
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 14,
        'title' => $translator->translatePlural('Date', 'Dates', 1),
        'type'  => 'datetime',
        'name'  => 'date',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 14,
        'title' => $translator->translate('Service'),
        'type'  => 'dropdown',
        'name'  => 'service',
        'dbname'  => 'service',
        'values' => self::getServiceArray(),
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 14,
        'title' => $translator->translate('Level'),
        'type'  => 'input',
        'name'  => 'level',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 14,
        'title' => $translator->translate('Message'),
        'type'  => 'input',
        'name'  => 'message',
        'readonly'  => 'readonly',
      ],
    ];
  }

  public static function getTypeArray()
  {
    global $translator;
    return [
      'system' => [
        'title' => $translator->translate('System'),
      ],
      'devices' => [
        'title' => $translator->translatePlural('Component', 'Components', 2),
      ],
      'planning' => [
        'title' => $translator->translate('Planning'),
      ],
      'reservation' => [
        'title' => $translator->translatePlural('Reservation', 'Reservations', 2),
      ],
      'dropdown' => [
        'title' => $translator->translatePlural('Dropdown', 'Dropdowns', 2),
      ],
      'rules' => [
        'title' => $translator->translatePlural('Rule', 'Rules', 2),
      ],
    ];
  }

  public static function getServiceArray()
  {
    global $translator;
    return [
      'inventory' => [
        'title' => $translator->translate('Assets'),
      ],
      'tracking' => [
        'title' => $translator->translatePlural('Ticket', 'Tickets', 2),
      ],
      'maintain' => [
        'title' => $translator->translate('Assistance'),
      ],
      'planning' => [
        'title' => $translator->translate('Planning'),
      ],
      'tools' => [
        'title' => $translator->translate('Tools'),
      ],
      'financial' => [
        'title' => $translator->translate('Management'),
      ],
      'login' => [
        'title' => $translator->translatePlural('Connection', 'Connections', 1),
      ],
      'setup' => [
        'title' => $translator->translate('Setup'),
      ],
      'security' => [
        'title' => $translator->translate('Security'),
      ],
      'reservation' => [
        'title' => $translator->translatePlural('Reservation', 'Reservations', 2),
      ],
      'cron' => [
        'title' => $translator->translatePlural('Automatic action', 'Automatic actions', 2),
      ],
      'document' => [
        'title' => $translator->translatePlural('Document', 'Documents', 2),
      ],
      'notification' => [
        'title' => $translator->translatePlural('Notification', 'Notifications', 2),
      ],
      'plugin' => [
        'title' => $translator->translate('Plugin', 'Plugins', 2),
      ],
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      // [
      //   'title' => $translator->translate('Historical'),
      //   'icon' => 'history',
      //   'link' => '',
      // ],
    ];
  }
}
