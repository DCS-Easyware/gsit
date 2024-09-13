<?php

namespace App\Models\Definitions;

class Appliance
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
        'id'    => 32,
        'title' => $translator->translate('Status'),
        'type'  => 'dropdown_remote',
        'name'  => 'state',
        'dbname' => 'states_id',
        'itemtype' => '\App\Models\State',
      ],
      [
        'id'    => 3,
        'title' => $translator->translatePlural('Location', 'Locations', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'location',
        'dbname' => 'locations_id',
        'itemtype' => '\App\Models\Location',
      ],
      [
        'id'    => 23,
        'title' => $translator->translatePlural('Manufacturer', 'Manufacturers', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'manufacturer',
        'dbname' => 'manufacturers_id',
        'itemtype' => '\App\Models\Manufacturer',
      ],
      [
        'id'    => 11,
        'title' => $translator->translatePlural('Appliance type', 'Appliance types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'type',
        'dbname' => 'appliancetypes_id',
        'itemtype' => '\App\Models\ApplianceType',
      ],
      [
        'id'    => 10,
        'title' => $translator->translatePlural('Appliance environment', 'Appliance environments', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'environment',
        'dbname' => 'applianceenvironments_id',
        'itemtype' => '\App\Models\ApplianceEnvironment',
      ],
      [
        'id'    => 24,
        'title' => $translator->translate('Technician in charge'),
        'type'  => 'dropdown_remote',
        'name'  => 'userstech',
        'dbname' => 'users_id_tech',
        'itemtype' => '\App\Models\User',
      ],
      [
        'id'    => 49,
        'title' => $translator->translate('Group in charge'),
        'type'  => 'dropdown_remote',
        'name'  => 'groupstech',
        'dbname' => 'groups_id_tech',
        'itemtype' => '\App\Models\Group',
      ],
      [
        'id'    => 6,
        'title' => $translator->translatePlural('User', 'Users', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'user',
        'dbname' => 'users_id',
        'itemtype' => '\App\Models\User',
      ],
      [
        'id'    => 8,
        'title' => $translator->translatePlural('Group', 'Groups', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'group',
        'dbname' => 'groups_id',
        'itemtype' => '\App\Models\Group',
      ],
      [
        'id'    => 12,
        'title' => $translator->translate('Serial number'),
        'type'  => 'input',
        'name'  => 'serial',
      ],
      [
        'id'    => 13,
        'title' => $translator->translate('Inventory number'),
        'type'  => 'input',
        'name'  => 'otherserial',
      ],
      [
        'id'    => 61,
        'title' => $translator->translate('Associable to a ticket'),
        'type'  => 'boolean',
        'name'  => 'is_helpdesk_visible',
      ],
      [
        'id'    => 4,
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
        'id'    => 7,
        'title' => $translator->translate('Child entities'),
        'type'  => 'boolean',
        'name'  => 'is_recursive',
      ],
      [
        'id'    => 9,
        'title' => $translator->translate('Last update'),
        'type'  => 'datetime',
        'name'  => 'date_mod',
        'readonly'  => 'readonly',
      ],
      /*

      $tab[] = [
        'id'   => 'common',
        'name' => __('Characteristics')
      ];

      // add objectlock search options
      $tab = array_merge($tab, ObjectLock::rawSearchOptionsToAdd(get_class($this)));

      $tab[] = [
        'id'            => '5',
        'table'         =>  Appliance_Item::getTable(),
        'field'         => 'items_id',
        'name'               => _n('Associated item', 'Associated items', 2),
        'nosearch'           => true,
        'massiveaction' => false,
        'forcegroupby'  =>  true,
        'additionalfields'   => ['itemtype'],
        'joinparams'    => ['jointype' => 'child']
      ];

      $tab[] = [
        'id'            => '31',
        'table'         => self::getTable(),
        'field'         => 'id',
        'name'          => __('ID'),
        'datatype'      => 'number',
        'massiveaction' => false
      ];

      $tab[] = [
        'id'            => '81',
        'table'         => Entity::getTable(),
        'field'         => 'entities_id',
        'name'          => sprintf('%s-%s', Entity::getTypeName(1), __('ID'))
      ];

      $tab = array_merge($tab, Certificate::rawSearchOptionsToAdd());
      */
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Appliance', 'Appliances', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Impact analysis'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Item', 'Items', 2),
        'icon' => 'desktop',
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
        'title' => $translator->translate('Management'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Certificate', 'Certificates', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Domain', 'Domains', 2),
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
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => '',
      ],
    ];
  }
}
