<?php

namespace App\Models\Definitions;

class Requesttype
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
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Active'),
        'type'  => 'boolean',
        'name'  => 'is_active',
      ],
      [
        'id'    => 14,
        'title' => $translator->translate('Default for tickets'),
        'type'  => 'boolean',
        'name'  => 'is_helpdesk_default',
      ],
      [
        'id'    => 182,
        'title' => $translator->translate('Default for followups'),
        'type'  => 'boolean',
        'name'  => 'is_followup_default',
      ],
      [
        'id'    => 15,
        'title' => $translator->translate('Default for mail recipients'),
        'type'  => 'boolean',
        'name'  => 'is_mail_default',
      ],
      [
        'id'    => 183,
        'title' => $translator->translate('Default for followup mail recipients'),
        'type'  => 'boolean',
        'name'  => 'is_mailfollowup_default',
      ],
      [
        'id'    => 180,
        'title' => $translator->translate('Request source visible for tickets'),
        'type'  => 'boolean',
        'name'  => 'is_ticketheader',
      ],
      [
        'id'    => 181,
        'title' => $translator->translate('Request source visible for followups'),
        'type'  => 'boolean',
        'name'  => 'is_itilfollowup',
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

      /*
      $tab[] = [
         'id'   => 'common',
         'name' => __('Characteristics')
      ];

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


      */
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Request source', 'Request sources', 1),
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
