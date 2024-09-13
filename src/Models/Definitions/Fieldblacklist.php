<?php

namespace App\Models\Definitions;

class Fieldblacklist
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
        'id'                 => '4',
        'table'              => $this->getTable(),
        'field'              => 'itemtype',
        'name'               => _n('Type', 'Types', 1),
        'massiveaction'      => false,
        'datatype'           => 'itemtypename',
        'forcegroupby'       => true
      ];

      $tab[] = [
        'id'                 => '6',
        'table'              => $this->getTable(),
        'field'              => 'field',
        'name'               => _n('Field', 'Fields', 1),
        'massiveaction'      => false,
        'datatype'           => 'specific',
        'additionalfields'   => [
        '0'                  => 'itemtype'
        ]
      ];

      $tab[] = [
        'id'                 => '7',
        'table'              => $this->getTable(),
        'field'              => 'value',
        'name'               => __('Value'),
        'datatype'           => 'specific',
        'additionalfields'   => [
        '0'                  => 'itemtype',
        '1'                  => 'field'
        ],
        'massiveaction'      => false
      ];
      */
    ];
  }

  public static function getRelatedPages()
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Ignored value for the unicity', 'Ignored values for the unicity', 1),
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
