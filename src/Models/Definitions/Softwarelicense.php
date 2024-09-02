<?php

namespace App\Models\Definitions;

class Softwarelicense
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 10,
        'title' => $translator->translatePlural('Software', 'Softwares', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'software',
        'dbname' => 'softwares_id',
        'itemtype' => '\App\Models\Software',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 1,
        'title' => $translator->translate('Name'),
        'type'  => 'input',
        'name'  => 'name',
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
        'id'    => 11,
        'title' => $translator->translate('Serial number'),
        'type'  => 'input',
        'name'  => 'serial',
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Number'),
        'type'  => 'input',
        'name'  => 'number',
      ],
      [
        'id'    => 5,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'softwarelicensetype',
        'dbname' => 'softwarelicensetypes_id',
        'itemtype' => '\App\Models\Softwarelicensetype',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Expiration'),
        'type'  => 'date',
        'name'  => 'expire',
      ],
      [
        'id'    => 9,
        'title' => $translator->translate('Valid'),
        'type'  => 'boolean',
        'name'  => 'is_valid',
      ],
      [
        'id'    => 168,
        'title' => $translator->translate('Allow Over-Quota'),
        'type'  => 'boolean',
        'name'  => 'allow_overquota',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
      [
         'id'    => 24,
         'title' => $translator->translate('Technician in charge of the hardware'),
         'type'  => 'dropdown_remote',
         'name'  => 'userstech',
         'dbname' => 'users_id_tech',
         'itemtype' => '\App\Models\User',
       ],
       [
         'id'    => 49,
         'title' => $translator->translate('Group in charge of the hardware'),
         'type'  => 'dropdown_remote',
         'name'  => 'groupstech',
         'dbname' => 'groups_id_tech',
         'itemtype' => '\App\Models\Group',
       ],
       [
         'id'    => 70,
         'title' => $translator->translatePlural('User', 'Users', 1),
         'type'  => 'dropdown_remote',
         'name'  => 'user',
         'dbname' => 'users_id',
         'itemtype' => '\App\Models\User',
       ],
       [
         'id'    => 71,
         'title' => $translator->translatePlural('Group', 'Groups', 1),
         'type'  => 'dropdown_remote',
         'name'  => 'group',
         'dbname' => 'groups_id',
         'itemtype' => '\App\Models\Group',
       ],
       [
         'id'    => 31,
         'title' => $translator->translate('Status'),
         'type'  => 'dropdown_remote',
         'name'  => 'state',
         'dbname' => 'states_id',
         'itemtype' => '\App\Models\State',
       ],
       // [
       //   'id'    => 61,
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
        'id'    => 162,
        'title' => $translator->translate('Inventory number'),
        'type'  => 'input',
        'name'  => 'otherserial',
      ],
      [
        'id'    => 86,
        'title' => $translator->translate('Child entities'),
        'type'  => 'boolean',
        'name'  => 'is_recursive',
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Purchase version'),
        'type'  => 'dropdown_remote',
        'name'  => 'softwareversions_buy',
        'dbname' => 'softwareversions_id_buy',
        'itemtype' => '\App\Models\Softwareversion',
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Version in use'),
        'type'  => 'dropdown_remote',
        'name'  => 'softwareversions_use',
        'dbname' => 'softwareversions_id_use',
        'itemtype' => '\App\Models\Softwareversion',
      ],
      [
        'id'    => 23,
        'title' => $translator->translatePlural('Manufacturer', 'Manufacturers', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'manufacturer',
        'dbname' => 'manufacturers_id',
        'itemtype' => '\App\Models\Manufacturer',
      ],



/*


      $tab[] = [
         'id'                 => '13',
         'table'              => $this->getTable(),
         'field'              => 'completename',
         'name'               => __('Father'),
         'datatype'           => 'itemlink',
         'forcegroupby'       => true,
         'joinparams'        => ['condition' => "AND 1=1"]
      ];



*/
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;

    return [
      [
        'title' => $translator->translatePlural('License', 'Licenses', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('License', 'Licenses', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Summary'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Manufacturer', 'Manufacturers', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Item', 'Items', 2),
        'icon' => 'desktop',
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
        'title' => $translator->translatePlural('Note', 'Notes', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Certificate', 'Certificates', 2),
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
