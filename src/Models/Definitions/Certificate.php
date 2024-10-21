<?php

namespace App\Models\Definitions;

class Certificate
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
        'id'    => 31,
        'title' => $translator->translate('Status'),
        'type'  => 'dropdown_remote',
        'name'  => 'state',
        'dbname' => 'state_id',
        'itemtype' => '\App\Models\State',
        'fillable' => true,
      ],
      [
        'id'    => 3,
        'title' => $translator->translatePlural('Location', 'Locations', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'location',
        'dbname' => 'location_id',
        'itemtype' => '\App\Models\Location',
        'fillable' => true,
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Serial number'),
        'type'  => 'input',
        'name'  => 'serial',
        'fillable' => true,
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Inventory number'),
        'type'  => 'input',
        'name'  => 'otherserial',
        'fillable' => true,
      ],
      [
        'id'    => 7,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'type',
        'dbname' => 'certificatetype_id',
        'itemtype' => '\App\Models\Certificatetype',
        'fillable' => true,
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('DNS suffix'),
        'type'  => 'input',
        'name'  => 'dns_suffix',
        'fillable' => true,
      ],
      [
        'id'    => 18,
        'title' => $translator->translate('DNS name'),
        'type'  => 'input',
        'name'  => 'dns_name',
        'fillable' => true,
      ],
      [
        'id'    => 9,
        'title' => $translator->translate('Self-signed'),
        'type'  => 'boolean',
        'name'  => 'is_autosign',
        'fillable' => true,
      ],
      [
        'id'    => 10,
        'title' => $translator->translate('Expiration date'),
        'type'  => 'date',
        'name'  => 'date_expiration',
        'fillable' => true,
      ],
      [
        'id'    => 11,
        'title' => $translator->translate('Command used'),
        'type'  => 'textarea',
        'name'  => 'command',
        'fillable' => true,
      ],
      [
        'id'    => 12,
        'title' => $translator->translate('Certificate request (CSR)'),
        'type'  => 'textarea',
        'name'  => 'certificate_request',
        'fillable' => true,
      ],
      [
        'id'    => 13,
        'title' => $translator->translatePlural('Certificate', 'Certificates', 1),
        'type'  => 'textarea',
        'name'  => 'certificate_item',
        'fillable' => true,
      ],
      [
        'id'    => 15,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
        'fillable' => true,
      ],
      [
        'id'    => 23,
        'title' => sprintf(
          $translator->translate('%1$s (%2$s)'),
          $translator->translatePlural('Manufacturer', 'Manufacturers', 1),
          $translator->translate('Root CA')
        ),
        'type'  => 'dropdown_remote',
        'name'  => 'manufacturer',
        'dbname' => 'manufacturer_id',
        'itemtype' => '\App\Models\Manufacturer',
        'fillable' => true,
      ],
      [
        'id'    => 24,
        'title' => $translator->translate('Technician in charge of the hardware'),
        'type'  => 'dropdown_remote',
        'name'  => 'userstech',
        'dbname' => 'user_id_tech',
        'itemtype' => '\App\Models\User',
        'fillable' => true,
      ],
      [
        'id'    => 49,
        'title' => $translator->translate('Group in charge of the hardware'),
        'type'  => 'dropdown_remote',
        'name'  => 'groupstech',
        'dbname' => 'group_id_tech',
        'itemtype' => '\App\Models\Group',
        'fillable' => true,
      ],
      [
        'id'    => 70,
        'title' => $translator->translatePlural('User', 'Users', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'user',
        'dbname' => 'user_id',
        'itemtype' => '\App\Models\User',
        'fillable' => true,
      ],
      [
        'id'    => 71,
        'title' => $translator->translatePlural('Group', 'Groups', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'group',
        'dbname' => 'group_id',
        'itemtype' => '\App\Models\Group',
        'fillable' => true,
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Alternate username'),
        'type'  => 'input',
        'name'  => 'contact',
        'fillable' => true,
      ],
      [
        'id'    => 17,
        'title' => $translator->translate('Alternate username number'),
        'type'  => 'input',
        'name'  => 'contact_num',
        'fillable' => true,
      ],
      // [
      //   'id'    => 61,
      //   'title' => $translator->translate('Template name'),
      //   'type'  => 'input',
      //   'name'  => 'template_name',
      // ],
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

      /*
      $tab[] = [
        'id'                 => 'common',
        'name'               => __('Characteristics')
      ];

      $tab[] = [
        'id'                 => '14',
        'table'              => 'glpi_certificates_items',
        'field'              => 'items_id',
        'name'               => _n('Associated item', 'Associated items', Session::getPluralNumber()),
        'nosearch'           => true,
        'massiveaction'      => false,
        'forcegroupby'       => true,
        'additionalfields'   => ['itemtype'],
        'joinparams'         => ['jointype' => 'child']
      ];


      $tab[] = [
        'id'                 => '72',
        'table'              => 'glpi_certificates_items',
        'field'              => 'id',
        'name'               => _x('quantity', 'Number of associated items'),
        'forcegroupby'       => true,
        'usehaving'          => true,
        'datatype'           => 'count',
        'massiveaction'      => false,
        'joinparams'         => [
        'jointype'           => 'child'
        ]
      ];

      // add objectlock search options
      $tab = array_merge($tab, ObjectLock::rawSearchOptionsToAdd(get_class($this)));
      $tab = array_merge($tab, Notepad::rawSearchOptionsToAdd());
      */
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Certificate', 'Certificates', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Associated item', 'Associated items', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Domain', 'Domains', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Management'),
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
        'title' => $translator->translate('Knowledge base'),
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
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => '',
      ],
    ];
  }
}
