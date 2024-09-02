<?php

namespace App\Models\Definitions;

class Contract
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
        'id'    => 3,
        'title' => $translator->translate('phone'."\004".'Number'),
        'type'  => 'input',
        'name'  => 'num',
      ],
      [
        'id'    => 31,
        'title' => $translator->translate('Status'),
        'type'  => 'dropdown_remote',
        'name'  => 'state',
        'dbname' => 'states_id',
        'itemtype' => '\App\Models\State',
      ],
      [
        'id'    => 4,
        'title' => $translator->translatePlural('Contract type', 'Contract types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'type',
        'dbname' => 'contracttypes_id',
        'itemtype' => '\App\Models\Contracttype',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Start date'),
        'type'  => 'date',
        'name'  => 'begin_date',
      ],
      [
        'id'    => 10,
        'title' => $translator->translate('Account number'),
        'type'  => 'input',
        'name'  => 'accounting_number',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
      // [
      //   'id'    => 80,
      //   'title' => $translator->translate('Entity'),
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
        'id'    => 23,
        'title' => $translator->translate('Renewal'),
        'type'  => 'dropdown',
        'name'  => 'renewal',
        'dbname'  => 'renewal',
        'values' => self::getContractRenewalArray(),
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Initial contract period'),
        'type'  => 'input',
        'name'  => 'duration',
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Notice'),
        'type'  => 'input',
        'name'  => 'notice',
      ],
      [
        'id'    => 21,
        'title' => $translator->translate('Contract renewal period'),
        'type'  => 'input',
        'name'  => 'periodicity',
      ],
      [
        'id'    => 22,
        'title' => $translator->translate('Invoice period'),
        'type'  => 'input',
        'name'  => 'billing',
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
         'id'                 => 'common',
         'name'               => __('Characteristics')
      ];



      $tab[] = [
         'id'                 => '20',
         'table'              => $this->getTable(),
         'field'              => 'end_date',
         'name'               => __('End date'),
         'datatype'           => 'date_delay',
         'datafields'         => [
            '1'                  => 'begin_date',
            '2'                  => 'duration'
         ],
         'searchunit'         => 'MONTH',
         'delayunit'          => 'MONTH',
         'maybefuture'        => true,
         'massiveaction'      => false
      ];



      $tab[] = [
         'id'                 => '12',
         'table'              => $this->getTable(),
         'field'              => 'expire',
         'name'               => __('Expiration'),
         'datatype'           => 'date_delay',
         'datafields'         => [
            '1'                  => 'begin_date',
            '2'                  => 'duration'
         ],
         'searchunit'         => 'DAY',
         'delayunit'          => 'MONTH',
         'maybefuture'        => true,
         'massiveaction'      => false
      ];

      $tab[] = [
         'id'                 => '13',
         'table'              => $this->getTable(),
         'field'              => 'expire_notice',
         'name'               => __('Expiration date + notice'),
         'datatype'           => 'date_delay',
         'datafields'         => [
            '1'                  => 'begin_date',
            '2'                  => 'duration',
            '3'                  => 'notice'
         ],
         'searchunit'         => 'DAY',
         'delayunit'          => 'MONTH',
         'maybefuture'        => true,
         'massiveaction'      => false
      ];

      $tab[] = [
         'id'                 => '59',
         'table'              => $this->getTable(),
         'field'              => 'alert',
         'name'               => __('Email alarms'),
         'datatype'           => 'specific',
         'searchtype'         => ['equals', 'notequals']
      ];


      $tab[] = [
         'id'                 => '72',
         'table'              => 'glpi_contracts_items',
         'field'              => 'id',
         'name'               => _x('quantity', 'Number of items'),
         'forcegroupby'       => true,
         'usehaving'          => true,
         'datatype'           => 'count',
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'           => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '29',
         'table'              => 'glpi_suppliers',
         'field'              => 'name',
         'name'               => _n('Associated supplier', 'Associated suppliers',
                                     Session::getPluralNumber()),
         'forcegroupby'       => true,
         'datatype'           => 'itemlink',
         'massiveaction'      => false,
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => 'glpi_contracts_suppliers',
               'joinparams'         => [
                  'jointype'           => 'child'
               ]
            ]
         ]
      ];

      $tab[] = [
         'id'                 => '50',
         'table'              => $this->getTable(),
         'field'              => 'template_name',
         'name'               => __('Template name'),
         'datatype'           => 'text',
         'massiveaction'      => false,
         'nosearch'           => true,
         'nodisplay'          => true,
         'autocomplete'       => true,
      ];

      // add objectlock search options
      $tab = array_merge($tab, ObjectLock::rawSearchOptionsToAdd(get_class($this)));

      $tab = array_merge($tab, Notepad::rawSearchOptionsToAdd());

      $tab[] = [
         'id'                 => 'cost',
         'name'               => _n('Cost', 'Costs', 1)
      ];

      $tab[] = [
         'id'                 => '11',
         'table'              => 'glpi_contractcosts',
         'field'              => 'totalcost',
         'name'               => __('Total cost'),
         'datatype'           => 'decimal',
         'forcegroupby'       => true,
         'usehaving'          => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'           => 'child'
         ],
         'computation'        =>
            '(SUM(' . $DB->quoteName('TABLE.cost') . ') / COUNT(' .
            $DB->quoteName('TABLE.id') . ')) * COUNT(DISTINCT ' .
            $DB->quoteName('TABLE.id') . ')',
         'nometa'             => true, // cannot GROUP_CONCAT a SUM
      ];

      $tab[] = [
         'id'                 => '41',
         'table'              => 'glpi_contractcosts',
         'field'              => 'cost',
         'name'               => _n('Cost', 'Costs', Session::getPluralNumber()),
         'datatype'           => 'decimal',
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'           => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '42',
         'table'              => 'glpi_contractcosts',
         'field'              => 'begin_date',
         'name'               => sprintf(__('%1$s - %2$s'), _n('Cost', 'Costs', 1), __('Begin date')),
         'datatype'           => 'date',
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'           => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '43',
         'table'              => 'glpi_contractcosts',
         'field'              => 'end_date',
         'name'               => sprintf(__('%1$s - %2$s'), _n('Cost', 'Costs', 1), __('End date')),
         'datatype'           => 'date',
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'           => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '44',
         'table'              => 'glpi_contractcosts',
         'field'              => 'name',
         'name'               => sprintf(__('%1$s - %2$s'), _n('Cost', 'Costs', 1), __('Name')),
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'           => 'child'
         ],
         'datatype'           => 'dropdown'
      ];

      $tab[] = [
         'id'                 => '45',
         'table'              => 'glpi_budgets',
         'field'              => 'name',
         'name'               => sprintf(__('%1$s - %2$s'), _n('Cost', 'Costs', 1), Budget::getTypeName(1)),
         'datatype'           => 'dropdown',
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => 'glpi_contractcosts',
               'joinparams'         => [
                  'jointype'           => 'child'
               ]
            ]
         ]
      ];



      */
    ];
  }


  public static function getContractRenewalArray()
  {
    global $translator;

    return [
      0 => [
        'title' => $translator->translate('Never'),
      ],
      1 => [
        'title' => $translator->translate('Tacit'),
      ],
      2 => [
        'title' => $translator->translate('Express'),
      ],
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;

    return [
      [
        'title' => $translator->translatePlural('Contract', 'Contract', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Cost', 'Costs', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Supplier', 'Suppliers', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Item', 'Items', 2),
        'icon' => 'desktop',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Document', 'Documents', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('External link', 'External links', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Note', 'Notes', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Knowledge base'),
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
