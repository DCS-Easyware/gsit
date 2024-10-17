<?php

namespace App\Models\Definitions;

class Ticketrecurrent
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
        'fillable' => true,
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
        'fillable' => true,
      ],
      // [
      //   'id'    => 80,
      //   'title' => $translator->translatePlural('Entity', 'Entities', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'completename',
      //   'itemtype' => '\App\Models\Entity',
      // ],
      [
        'id'    => 86,
        'title' => $translator->translate('Child entities'),
        'type'  => 'boolean',
        'name'  => 'is_recursive',
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
      [
        'id'    => 11,
        'title' => $translator->translate('Active'),
        'type'  => 'boolean',
        'name'  => 'is_active',
        'fillable' => true,
      ],
      [
        'id'    => 13,
        'title' => $translator->translate('Start date'),
        'type'  => 'datetime',
        'name'  => 'begin_date',
        'fillable' => true,
      ],
      [
        'id'    => 17,
        'title' => $translator->translate('End date'),
        'type'  => 'datetime',
        'name'  => 'end_date',
        'fillable' => true,
      ],



      /*

      $tab[] = [
         'id'                => '2',
         'table'             => $this->getTable(),
         'field'             => 'id',
         'name'              => __('ID'),
         'massiveaction'     => false,
         'datatype'          => 'number'
      ];

      if ($DB->fieldExists($this->getTable(), 'product_number'))
      {
         $tab[] = [
            'id'  => '3',
            'table'  => $this->getTable(),
            'field'  => 'product_number',
            'name'   => __('Product number'),
            'autocomplete' => true,
         ];
      }


      // add objectlock search options
      $tab = array_merge($tab, ObjectLock::rawSearchOptionsToAdd(get_class($this)));



      $tab[] = [
         'id'                 => '12',
         'table'              => 'glpi_tickettemplates',
         'field'              => 'name',
         'name'               => _n('Ticket template', 'Ticket templates', 1),
         'datatype'           => 'itemlink'
      ];

      $tab[] = [
         'id'                 => '15',
         'table'              => $this->getTable(),
         'field'              => 'periodicity',
         'name'               => __('Periodicity'),
         'datatype'           => 'specific'
      ];

      $tab[] = [
         'id'                 => '14',
         'table'              => $this->getTable(),
         'field'              => 'create_before',
         'name'               => __('Preliminary creation'),
         'datatype'           => 'timestamp'
      ];

      $tab[] = [
         'id'                 => '18',
         'table'              => 'glpi_calendars',
         'field'              => 'name',
         'name'               => _n('Calendar', 'Calendars', 1),
         'datatype'           => 'itemlink'
      ];


      */
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translate('Recurrent tickets'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Information', 'Information', 2),
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
