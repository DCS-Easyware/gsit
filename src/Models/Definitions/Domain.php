<?php

namespace App\Models\Definitions;

class Domain
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
        'id'    => 2,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'type',
        'dbname' => 'domaintype_id',
        'itemtype' => '\App\Models\Domaintype',
        'fillable' => true,
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('Technician in charge'),
        'type'  => 'dropdown_remote',
        'name'  => 'userstech',
        'dbname' => 'user_id_tech',
        'itemtype' => '\App\Models\User',
        'fillable' => true,
      ],
      [
        'id'    => 10,
        'title' => $translator->translate('Group in charge'),
        'type'  => 'dropdown_remote',
        'name'  => 'groupstech',
        'dbname' => 'group_id_tech',
        'itemtype' => '\App\Models\Group',
        'fillable' => true,
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Creation date'),
        'type'  => 'date',
        'name'  => 'created_at',
        'fillable' => true,
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Expiration date'),
        'type'  => 'date',
        'name'  => 'date_expiration',
        'fillable' => true,
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
        'fillable' => true,
      ],
      [
        'id'    => 9,
        'title' => $translator->translate('Others'),
        'type'  => 'input',
        'name'  => 'others',
        'fillable' => true,
      ],
      [
        'id'    => 18,
        'title' => $translator->translate('Child entities'),
        'type'  => 'boolean',
        'name'  => 'is_recursive',
        'fillable' => true,
      ],
      [
        'id'    => 12,
        'title' => $translator->translate('Last update'),
        'type'  => 'datetime',
        'name'  => 'updated_at',
        'readonly'  => 'readonly',
      ],
      // [
      //   'id'    => 80,
      //   'title' => $translator->translatePlural('Entity', 'Entities', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'completename',
      //   'itemtype' => '\App\Models\Entity',
      // ],

      /*
      $tab = [];

      $tab[] = [
        'id'                 => 'common',
        'name'               => self::getTypeName(2)
      ];

      $tab[] = [
      'id'                 => '8',
        'table'              => 'glpi_domains_items',
        'field'              => 'items_id',
        'nosearch'           => true,
        'massiveaction'      => false,
        'name'               => _n('Associated item', 'Associated items', Session::getPluralNumber()),
        'forcegroupby'       => true,
        'joinparams'         => [
        'jointype'           => 'child'
        ]
      ];

      $tab[] = [
        'id'                 => '30',
        'table'              => $this->getTable(),
        'field'              => 'id',
        'name'               => __('ID'),
        'datatype'           => 'number'
      ];

      $tab[] = [
        'id'                 => '81',
        'table'              => 'glpi_entities',
        'field'              => 'entities_id',
        'name'               => __('Entity-ID')
      ];
      */
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Domain', 'Domains', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Impact analysis'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Record', 'Records', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Associated item', 'Associated items', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Management'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Ticket', 'Tickets', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Problem', 'Problems', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Change', 'Changes', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Contract', 'Contract', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Document', 'Documents', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Certificate', 'Certificates', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('External link', 'External links', 2),
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
