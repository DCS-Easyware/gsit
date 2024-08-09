<?php

namespace App\Models\Definitions;

class Computer
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 2,
        'title' => $translator->translate('Name'),
        'type'  => 'input',
        'name'  => 'name',
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
      //   'id'    => 3,
      //   'title' => $translator->translatePlural('Location', 'Locations', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'locations_id',
      //   'itemtype' => '\App\Models\Location',
      // ],
      [
        'id'    => 4,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'type',
        'dbname' => 'computertypes_id',
        'itemtype' => '\App\Models\Computertype',
      ],
      // [
      //   'id'    => 24,
      //   'title' => $translator->translate('Technician in charge of the hardware'),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'users_id_tech',
      //   'itemtype' => '\App\Models\User',
      // ],
      [
        'id'    => 23,
        'title' => $translator->translatePlural('Manufacturer', 'Manufacturers', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'manufacturer',
        'dbname' => 'manufacturers_id',
        'itemtype' => '\App\Models\Manufacturer',
      ],
      // [
      //   'id'    => 49,
      //   'title' => $translator->translate('Group in charge of the hardware'),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'groups_id_tech',
      //   'itemtype' => '\App\Models\Group',
      // ],
      [
        'id'    => 40,
        'title' => $translator->translatePlural('Model', 'Models', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'model',
        'dbname' => 'computermodels_id',
        'itemtype' => '\App\Models\Computermodel',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Alternate username number'),
        'type'  => 'input',
        'name'  => 'contact_num',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Serial number'),
        'type'  => 'input',
        'name'  => 'serial',
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Alternate username'),
        'type'  => 'input',
        'name'  => 'contact',
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Inventory number'),
        'type'  => 'input',
        'name'  => 'otherserial',
      ],
      // [
      //   'id'    => 70,
      //   'title' => $translator->translatePlural('User', 'Users', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'users_id',
      //   'itemtype' => '\App\Models\User',
      // ],
      // [
      //   'id'    => 32,
      //   'title' => $translator->translate('Network', 'Networks', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'networks_id',
      //   'itemtype' => '\App\Models\Network',
      // ],
      // [
      //   'id'    => 71,
      //   'title' => $translator->translatePlural('Group', 'Groups', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'groups_id',
      //   'itemtype' => '\App\Models\Group',
      // ],
      [
        'id'    => 47,
        'title' => $translator->translate('UUID'),
        'type'  => 'input',
        'name'  => 'uuid',
      ],
      // [
      //   'id'    => 42,
      //   'title' => $translator->translate('Update Source', 'Update Sources', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'autoupdatesystems_id',
      //   'itemtype' => '\App\Models\AutoUpdateSystem',
      // ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ]
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;

    return [
      [
        'title' => $translator->translatePlural('Operating system', 'Operating systems', 1),
        'icon' => 'laptop house',
        'link' => $rootUrl.'/operatingsystem',
      ],
      [
        'title' => 'Composants',
        'icon' => 'microchip',
        'link' => '',
      ],
      [
        'title' => 'Volumes',
        'icon' => 'hdd',
        'link' => '',
      ],
      [
        'title' => 'Logiciels',
        'icon' => 'cube',
        'link' => $rootUrl.'/softwares',
      ],
      [
        'title' => 'Connexions',
        'icon' => 'linkify',
        'link' => '',
      ],
      [
        'title' => 'Ports réseau',
        'icon' => 'ethernet',
        'link' => '',
      ],
      [
        'title' => 'Documents',
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => 'Virtualisation',
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => 'Antivirus',
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => 'base de connaissances',
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => 'Tickets',
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => 'Problèmes',
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => 'Changements',
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => 'Certificats',
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => 'Verrous',
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => 'Notes',
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => 'Réservations',
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => 'Applicatifs',
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => 'Historique',
        'icon' => 'history',
        'link' => '',
      ],
    ];
  }
}
