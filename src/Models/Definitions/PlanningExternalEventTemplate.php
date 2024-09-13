<?php

namespace App\Models\Definitions;

class PlanningExternalEventTemplate
{
  public static function getDefinition()
  {
    global $translator;
      return [
      [
        'id'    => 1,
        'title' => $translator->translate('Name'),
        'type'  => 'input',
        'name'  => 'name',
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Status'),
        'type'  => 'dropdown',
        'name'  => 'state',
        'dbname' => 'states_id',
        'values' => self::getStateArray(),
      ],
      [
        'id'    => 5,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'category',
        'dbname' => 'planningeventcategories_id',
        'itemtype' => '\App\Models\PlanningEventCategory',
      ],
      [
        'id'    => 201,
        'title' => $translator->translate('Background event'),
        'type'  => 'boolean',
        'name'  => 'background',
      ],
      [
        'id'    => 211,
        'title' => $translator->translate('Period'),
        'type'  => 'input',
        'name'  => 'duration',
      ],
      [
        'id'    => 212,
        'title' => $translator->translate('Planning'."\004".'Reminder'),
        'type'  => 'input',
        'name'  => 'before_time',
      ],
      [
        'id'    => 202,
        'title' => $translator->translate('Repeat'),
        'type'  => 'input',
        'name'  => 'rrule',
      ],
      [
        'id'    => 203,
        'title' => $translator->translate('Description'),
        'type'  => 'textarea',
        'name'  => 'text',
      ],
      [
        'id'    => 204,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
      [
        'id'    => 19,
        'title' => $translator->translate('Last update'),
        'type'  => 'datetime',
        'name'  => 'date_mod',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 121,
        'title' => $translator->translate('Creation date'),
        'type'  => 'datetime',
        'name'  => 'date_creation',
        'readonly'  => 'readonly',
      ],
    ];
  }

  public static function getStateArray()
  {
    global $translator;
    return [
      0 => [
        'title' => $translator->translatePlural('Information', 'Information', 1),
      ],
      1 => [
        'title' => $translator->translate('To do'),
      ],
      2 => [
        'title' => $translator->translate('Done'),
      ],
    ];
  }

  public static function getRelatedPages()
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('External events template', 'External events templates', 1),
        'icon' => 'caret square down outline',
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
