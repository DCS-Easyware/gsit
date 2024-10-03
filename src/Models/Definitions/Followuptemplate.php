<?php

namespace App\Models\Definitions;

class Followuptemplate
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
        'title' => $translator->translate('Content'),
        'type'  => 'textarea',
        'name'  => 'content',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Source of followup'),
        'type'  => 'dropdown_remote',
        'name'  => 'source',
        'dbname' => 'requesttype_id',
        'itemtype' => '\App\Models\Requesttype',
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Private'),
        'type'  => 'boolean',
        'name'  => 'is_private',
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

  public static function getRelatedPages()
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Followup template', 'Followup templates', 1),
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
