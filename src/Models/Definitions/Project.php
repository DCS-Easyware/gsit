<?php

namespace App\Models\Definitions;

class Project
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
        'title' => $translator->translate('Code'),
        'type'  => 'input',
        'name'  => 'code',
      ],
      [
        'id'    => 21,
        'title' => $translator->translate('Description'),
        'type'  => 'textarea',
        'name'  => 'content',
      ],
      [
        'id'    => 14,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'type',
        'dbname' => 'projecttypes_id',
        'itemtype' => '\App\Models\Projecttype',
      ],
      [
        'id'    => 12,
        'title' => $translator->translate('Status'),
        'type'  => 'dropdown_remote',
        'name'  => 'state',
        'dbname' => 'projectstates_id',
        'itemtype' => '\App\Models\Projectstate',
      ],
      [
        'id'    => 15,
        'title' => $translator->translate('Creation date'),
        'type'  => 'datetime',
        'name'  => 'date',
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Show on global GANTT'),
        'type'  => 'boolean',
        'name'  => 'show_on_global_gantt',
      ],
      [
        'id'    => 24,
        'title' => $translator->translate('Manager'),
        'type'  => 'dropdown_remote',
        'name'  => 'user',
        'dbname' => 'users_id',
        'itemtype' => '\App\Models\User',
      ],
      [
        'id'    => 49,
        'title' => $translator->translate('Manager group'),
        'type'  => 'dropdown_remote',
        'name'  => 'group',
        'dbname' => 'groups_id',
        'itemtype' => '\App\Models\Group',
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Planned start date'),
        'type'  => 'datetime',
        'name'  => 'plan_start_date',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Planned end date'),
        'type'  => 'datetime',
        'name'  => 'plan_end_date',
      ],
      [
        'id'    => 17,
        'title' => $translator->translate('Planned duration'),
        'type'  => 'input',
        'name'  => '_virtual_planned_duration',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 9,
        'title' => $translator->translate('Real start date'),
        'type'  => 'datetime',
        'name'  => 'real_start_date',
      ],
      [
        'id'    => 10,
        'title' => $translator->translate('Real end date'),
        'type'  => 'datetime',
        'name'  => 'real_end_date',
      ],
      [
        'id'    => 18,
        'title' => $translator->translate('Effective duration'),
        'type'  => 'input',
        'name'  => '_virtual_effective_duration',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Percent done'),
        'type'  => 'input',
        'name'  => 'percent_done',
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('Priority'),
        'type'  => 'dropdown',
        'name'  => 'priority',
        'dbname'  => 'priority',
        'values' => self::getPriorityArray(),
      ],


      // [
      //   'id'    => 50,
      //   'title' => $translator->translate('Template name'),
      //   'type'  => 'input',
      //   'name'  => 'template_name',
      // ],
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
         'id'                 => '2',
         'table'              => $this->getTable(),
         'field'              => 'id',
         'name'               => __('ID'),
         'massiveaction'      => false,
         'datatype'           => 'number'
      ];


      $tab[] = [
         'id'                 => '13',
         'table'              => $this->getTable(),
         'field'              => 'name',
         'name'               => __('Father'),
         'datatype'           => 'itemlink',
         'massiveaction'      => false,
         'joinparams'         => [
            'condition'          => 'AND 1=1'
         ]
      ];




      $tab[] = [
         'id'                 => '91',
         'table'              => ProjectCost::getTable(),
         'field'              => 'totalcost',
         'name'               => __('Total cost'),
         'datatype'           => 'decimal',
         'forcegroupby'       => true,
         'usehaving'          => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'           => 'child',
            'specific_itemtype'  => 'ProjectCost',
            'condition'          => 'AND NEWTABLE.`projects_id` = REFTABLE.`id`',
            'beforejoin'         => [
               'table'        => $this->getTable(),
               'joinparams'   => [
                  'jointype'  => 'child'
               ],
            ],
         ],
         'computation'        => '(SUM('.$DB->quoteName('TABLE.cost').'))',
         'nometa'             => true, // cannot GROUP_CONCAT a SUM
      ];

      $itil_count_types = [
         'Change'  => _x('quantity', 'Number of changes'),
         'Problem' => _x('quantity', 'Number of problems'),
         'Ticket'  => _x('quantity', 'Number of tickets'),
      ];
      $index = 92;
      foreach ($itil_count_types as $itil_type => $label) {
         $tab[] = [
            'id'                 => $index,
            'table'              => Itil_Project::getTable(),
            'field'              => 'id',
            'name'               => $label,
            'datatype'           => 'count',
            'forcegroupby'       => true,
            'usehaving'          => true,
            'massiveaction'      => false,
            'joinparams'         => [
               'jointype'           => 'child',
               'condition'          => "AND NEWTABLE.`itemtype` = '$itil_type'"
            ]
         ];
         $index++;
      }

      $tab[] = [
         'id'                 => 'project_team',
         'name'               => ProjectTeam::getTypeName(),
      ];

      $tab[] = [
         'id'                 => '87',
         'table'              => User::getTable(),
         'field'              => 'name',
         'name'               => User::getTypeName(2),
         'forcegroupby'       => true,
         'datatype'           => 'dropdown',
         'joinparams'         => [
            'jointype'          => 'itemtype_item_revert',
            'specific_itemtype' => 'User',
            'beforejoin'        => [
               'table'      => ProjectTeam::getTable(),
               'joinparams' => [
                  'jointype' => 'child',
               ]
            ]
         ]
      ];

      $tab[] = [
         'id'                 => '88',
         'table'              => Group::getTable(),
         'field'              => 'completename',
         'name'               => Group::getTypeName(2),
         'forcegroupby'       => true,
         'datatype'           => 'dropdown',
         'joinparams'         => [
            'jointype'          => 'itemtype_item_revert',
            'specific_itemtype' => 'Group',
            'beforejoin'        => [
               'table'      => ProjectTeam::getTable(),
               'joinparams' => [
                  'jointype' => 'child',
               ]
            ]
         ]
      ];

      $tab[] = [
         'id'                 => '89',
         'table'              => Supplier::getTable(),
         'field'              => 'name',
         'name'               => Supplier::getTypeName(2),
         'forcegroupby'       => true,
         'datatype'           => 'dropdown',
         'joinparams'         => [
            'jointype'          => 'itemtype_item_revert',
            'specific_itemtype' => 'Supplier',
            'beforejoin'        => [
               'table'      => ProjectTeam::getTable(),
               'joinparams' => [
                  'jointype' => 'child',
               ]
            ]
         ]
      ];

      $tab[] = [
         'id'                 => '90',
         'table'              => Contact::getTable(),
         'field'              => 'name',
         'name'               => Contact::getTypeName(2),
         'forcegroupby'       => true,
         'datatype'           => 'dropdown',
         'joinparams'         => [
            'jointype'          => 'itemtype_item_revert',
            'specific_itemtype' => 'Contact',
            'beforejoin'        => [
               'table'      => ProjectTeam::getTable(),
               'joinparams' => [
                  'jointype' => 'child',
               ]
            ]
         ]
      ];

      $tab[] = [
         'id'                 => 'project_task',
         'name'               => ProjectTask::getTypeName(),
      ];

      $tab[] = [
         'id'                 => '111',
         'table'              => ProjectTask::getTable(),
         'field'              => 'name',
         'name'               => __('Name'),
         'datatype'           => 'string',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'  => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '112',
         'table'              => ProjectTask::getTable(),
         'field'              => 'content',
         'name'               => __('Description'),
         'datatype'           => 'text',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'  => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '113',
         'table'              => ProjectState::getTable(),
         'field'              => 'name',
         'name'               => _x('item', 'State'),
         'datatype'           => 'dropdown',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'          => 'item_revert',
            'specific_itemtype' => 'ProjectState',
            'beforejoin'        => [
               'table'      => ProjectTask::getTable(),
               'joinparams' => [
                  'jointype' => 'child',
               ]
            ]
         ]
      ];

      $tab[] = [
         'id'                 => '114',
         'table'              => ProjectTaskType::getTable(),
         'field'              => 'name',
         'name'               => _n('Type', 'Types', 1),
         'datatype'           => 'dropdown',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'          => 'item_revert',
            'specific_itemtype' => 'ProjectTaskType',
            'beforejoin'        => [
               'table'      => ProjectTask::getTable(),
               'joinparams' => [
                  'jointype' => 'child',
               ]
            ]
         ]
      ];

      $tab[] = [
         'id'                 => '115',
         'table'              => ProjectTask::getTable(),
         'field'              => 'date',
         'name'               => __('Opening date'),
         'datatype'           => 'datetime',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'  => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '116',
         'table'              => ProjectTask::getTable(),
         'field'              => 'date_mod',
         'name'               => __('Last update'),
         'datatype'           => 'datetime',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'  => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '117',
         'table'              => ProjectTask::getTable(),
         'field'              => 'percent_done',
         'name'               => __('Percent done'),
         'datatype'           => 'number',
         'unit'               => '%',
         'min'                => 0,
         'max'                => 100,
         'step'               => 5,
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'  => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '118',
         'table'              => ProjectTask::getTable(),
         'field'              => 'plan_start_date',
         'name'               => __('Planned start date'),
         'datatype'           => 'datetime',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'  => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '119',
         'table'              => ProjectTask::getTable(),
         'field'              => 'plan_end_date',
         'name'               => __('Planned end date'),
         'datatype'           => 'datetime',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'  => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '120',
         'table'              => ProjectTask::getTable(),
         'field'              => 'real_start_date',
         'name'               => __('Real start date'),
         'datatype'           => 'datetime',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'  => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '122',
         'table'              => ProjectTask::getTable(),
         'field'              => 'real_end_date',
         'name'               => __('Real end date'),
         'datatype'           => 'datetime',
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'  => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '123',
         'table'              => ProjectTask::getTable(),
         'field'              => 'planned_duration',
         'name'               => __('Planned Duration'),
         'datatype'           => 'timestamp',
         'min'                => 0,
         'max'                => 100*HOUR_TIMESTAMP,
         'step'               => HOUR_TIMESTAMP,
         'addfirstminutes'    => true,
         'inhours'            => true,
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'  => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '124',
         'table'              => ProjectTask::getTable(),
         'field'              => 'effective_duration',
         'name'               => __('Effective duration'),
         'datatype'           => 'timestamp',
         'min'                => 0,
         'max'                => 100*HOUR_TIMESTAMP,
         'step'               => HOUR_TIMESTAMP,
         'addfirstminutes'    => true,
         'inhours'            => true,
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'  => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '125',
         'table'              => ProjectTask::getTable(),
         'field'              => 'comment',
         'name'               => __('Comments'),
         'datatype'           => 'text',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'  => 'child'
         ]
      ];

      $tab[] = [
         'id'                 => '126',
         'table'              => ProjectTask::getTable(),
         'field'              => 'is_milestone',
         'name'               => __('Milestone'),
         'datatype'           => 'bool',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'splititems'         => true,
         'joinparams'         => [
            'jointype'  => 'child'
         ]
      ];

      // add objectlock search options
      $tab = array_merge($tab, ObjectLock::rawSearchOptionsToAdd(get_class($this)));

      $tab = array_merge($tab, Notepad::rawSearchOptionsToAdd());

      */
    ];
  }

  public static function getPriorityArray()
  {
    global $translator;

    return [
      6 => [
        'title' => $translator->translate('priority'."\004". 'Major'),
        'color' => 'gsitmajor',
        'icon'  => 'fire extinguisher',
      ],
      5 => [
        'title' => $translator->translate('priority'."\004". 'Very high'),
        'color' => 'gsitveryhigh',
        'icon'  => 'fire alternate',
      ],
      4 => [
        'title' => $translator->translate('priority'."\004". 'High'),
        'color' => 'gsithigh',
        'icon'  => 'fire',
      ],
      3 => [
        'title' => $translator->translate('priority'."\004". 'Medium'),
        'color' => 'gsitmedium',
        'icon'  => 'volume up',
      ],
      2 => [
        'title' => $translator->translate('priority'."\004". 'Low'),
        'color' => 'gsitlow',
        'icon'  => 'volume down',
      ],
      1 => [
        'title' => $translator->translate('priority'."\004". 'Very low'),
        'color' => 'gsitverylow',
        'icon'  => 'volume off',
      ],
    ];
  }


  public static function getRelatedPages($rootUrl)
  {
    global $translator;

    return [
      [
        'title' => $translator->translatePlural('Project', 'Projects', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Project task', 'Project tasks', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Project team', 'Project teams', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Project', 'Projects', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('GANTT'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Kanban'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Cost', 'Costs', 2),
        'icon' => 'money bill alternate',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Itil item', 'Itil items', 2),
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
        'title' => $translator->translatePlural('Contract', 'Contract', 2),
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
