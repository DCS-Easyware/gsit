<?php

namespace App\Models\Definitions;

class Planningexternaleventtemplate
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
        'fillable' => true,
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Status'),
        'type'  => 'dropdown',
        'name'  => 'state',
        'dbname' => 'state_id',
        'values' => self::getStateArray(),
        'fillable' => true,
      ],
      [
        'id'    => 5,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'category',
        'dbname' => 'planningeventcategory_id',
        'itemtype' => '\App\Models\Planningeventcategory',
        'fillable' => true,
      ],
      [
        'id'    => 201,
        'title' => $translator->translate('Background event'),
        'type'  => 'boolean',
        'name'  => 'background',
        'fillable' => true,
      ],
      [
        'id'    => 211,
        'title' => $translator->translate('Period'),
        'type'  => 'input',
        'name'  => 'duration',
        'fillable' => true,
      ],
      [
        'id'    => 212,
        'title' => $translator->translate('Planning' . "\004" . 'Reminder'),
        'type'  => 'input',
        'name'  => 'before_time',
        'fillable' => true,
      ],
      [
        'id'    => 202,
        'title' => $translator->translate('Repeat'),
        'type'  => 'input',
        'name'  => 'rrule',
        'fillable' => true,
      ],
      [
        'id'    => 203,
        'title' => $translator->translate('Description'),
        'type'  => 'textarea',
        'name'  => 'text',
        'fillable' => true,
      ],
      [
        'id'    => 204,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
        'fillable' => true,
      ],
      [
        'id'    => 19,
        'title' => $translator->translate('Last update'),
        'type'  => 'datetime',
        'name'  => 'updated_at',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 121,
        'title' => $translator->translate('Creation date'),
        'type'  => 'datetime',
        'name'  => 'created_at',
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

  public static function getRelatedPages($rootUrl)
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
