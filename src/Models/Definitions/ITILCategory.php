<?php

namespace App\Models\Definitions;

class ITILCategory
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 14,
        'title' => $translator->translate('Name'),
        'type'  => 'input',
        'name'  => 'name',
      ],
      [
        'id'    => 13,
        'title' => $translator->translate('As child of'),
        'type'  => 'dropdown_remote',
        'name'  => 'category',
        'dbname' => 'itilcategories_id',
        'itemtype' => '\App\Models\ITILCategory',
      ],
      [
        'id'    => 70,
        'title' => $translator->translate('Technician in charge of the hardware'),
        'type'  => 'dropdown_remote',
        'name'  => 'users',
        'dbname' => 'users_id',
        'itemtype' => '\App\Models\User',
      ],
      [
        'id'    => 71,
        'title' => $translator->translate('Group in charge of the hardware'),
        'type'  => 'dropdown_remote',
        'name'  => 'groups',
        'dbname' => 'groups_id',
        'itemtype' => '\App\Models\Group',
      ],
      [
        'id'    => 79,
        'title' => $translator->translate('Knowledge base'),
        'type'  => 'dropdown_remote',
        'name'  => 'knowbaseitemcategories',
        'dbname' => 'knowbaseitemcategories_id',
        'itemtype' => '\App\Models\KnowbaseItemCategory',
      ],
      [
        'id'    => 99,
        'title' => $translator->translate('Code representing the ticket category'),
        'type'  => 'input',
        'name'  => 'code',
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('Visible in the simplified interface'),
        'type'  => 'boolean',
        'name'  => 'is_helpdeskvisible',
      ],
      [
        'id'    => 74,
        'title' => $translator->translate('Visible for an incident'),
        'type'  => 'boolean',
        'name'  => 'is_incident',
      ],
      [
        'id'    => 75,
        'title' => $translator->translate('Visible for a request'),
        'type'  => 'boolean',
        'name'  => 'is_request',
      ],
      [
        'id'    => 76,
        'title' => $translator->translate('Visible for a problem'),
        'type'  => 'boolean',
        'name'  => 'is_problem',
      ],
      [
        'id'    => 85,
        'title' => $translator->translate('Visible for a change'),
        'type'  => 'boolean',
        'name'  => 'is_change',
      ],
      [
        'id'    => 72,
        'title' => $translator->translate('Template for a request'),
        'type'  => 'dropdown_remote',
        'name'  => 'tickettemplates_demand',
        'dbname' => 'tickettemplates_id_demand',
        'itemtype' => '\App\Models\TicketTemplate',
      ],
      [
        'id'    => 73,
        'title' => $translator->translate('Template for an incident'),
        'type'  => 'dropdown_remote',
        'name'  => 'tickettemplates_incident',
        'dbname' => 'tickettemplates_id_incident',
        'itemtype' => '\App\Models\TicketTemplate',
      ],
      [
        'id'    => 100,
        'title' => $translator->translate('Template for a change'),
        'type'  => 'dropdown_remote',
        'name'  => 'changetemplates',
        'dbname' => 'changetemplates_id',
        'itemtype' => '\App\Models\ChangeTemplate',
      ],
      [
        'id'    => 101,
        'title' => $translator->translate('Template for a problem'),
        'type'  => 'dropdown_remote',
        'name'  => 'problemtemplates',
        'dbname' => 'problemtemplates_id',
        'itemtype' => '\App\Models\ProblemTemplate',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
      [
        'id'    => 80,
        'title' => $translator->translate('Entity'),
        'type'  => 'dropdown_remote',
        'name'  => 'completename',
        'itemtype' => '\App\Models\Entity',
      ],
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
        'id'                => '1',
        'table'              => $this->getTable(),
        'field'              => 'completename',
        'name'               => __('Complete name'),
        'datatype'           => 'itemlink',
        'massiveaction'      => false
      ];

      $tab[] = [
        'id'                => '2',
        'table'              => $this->getTable(),
        'field'              => 'id',
        'name'               => __('ID'),
        'massiveaction'      => false,
        'datatype'           => 'number'
      ];

      // add objectlock search options
      $tab = array_merge($tab, ObjectLock::rawSearchOptionsToAdd(get_class($this)));

      $tab[] = [
        'id'                 => '77',
        'table'              => 'glpi_tickets',
        'field'              => 'id',
        'name'               => _x('quantity', 'Number of tickets'),
        'datatype'           => 'count',
        'forcegroupby'       => true,
        'massiveaction'      => false,
        'joinparams'         => [
        'jointype'           => 'child'
        ]
      ];

      $tab[] = [
        'id'                 => '78',
        'table'              => 'glpi_problems',
        'field'              => 'id',
        'name'               => _x('quantity', 'Number of problems'),
        'datatype'           => 'count',
        'forcegroupby'       => true,
        'massiveaction'      => false,
        'joinparams'         => [
        'jointype'           => 'child'
        ]
      ];

      $tab[] = [
        'id'                 => '98',
        'table'              => 'glpi_changes',
        'field'              => 'id',
        'name'               => _x('quantity', 'Number of changes'),
        'datatype'           => 'count',
        'forcegroupby'       => true,
        'massiveaction'      => false,
        'joinparams'         => [
        'jointype'           => 'child'
        ]
      ];
      */
    ];
  }

  public static function getRelatedPages()
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('ITIL category', 'ITIL categories', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('ITIL category', 'ITIL categories', 2),
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
