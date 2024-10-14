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
        'dbname' => 'state_id',
        'itemtype' => '\App\Models\State',
      ],
      [
        'id'    => 4,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'type',
        'dbname' => 'computertype_id',
        'itemtype' => '\App\Models\Computertype',
      ],
      [
        'id'    => 70,
        'title' => $translator->translatePlural('User', 'Users', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'user',
        'dbname' => 'user_id',
        'itemtype' => '\App\Models\User',
      ],
      [
        'id'    => 23,
        'title' => $translator->translatePlural('Manufacturer', 'Manufacturers', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'manufacturer',
        'dbname' => 'manufacturer_id',
        'itemtype' => '\App\Models\Manufacturer',
      ],
      [
        'id'    => 40,
        'title' => $translator->translatePlural('Model', 'Models', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'model',
        'dbname' => 'computermodel_id',
        'itemtype' => '\App\Models\Computermodel',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Serial number'),
        'type'  => 'input',
        'name'  => 'serial',
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Inventory number'),
        'type'  => 'input',
        'name'  => 'otherserial',
      ],
      [
        'id'    => 3,
        'title' => $translator->translatePlural('Location', 'Locations', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'location',
        'dbname' => 'location_id',
        'itemtype' => '\App\Models\Location',
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
        'id'    => 7,
        'title' => $translator->translate('Alternate username'),
        'type'  => 'input',
        'name'  => 'contact',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Alternate username number'),
        'type'  => 'input',
        'name'  => 'contact_num',
      ],
      [
        'id'    => 71,
        'title' => $translator->translatePlural('Group', 'Groups', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'group',
        'dbname' => 'group_id',
        'itemtype' => '\App\Models\Group',
      ],
      [
        'id'    => 32,
        'title' => $translator->translate('Network', 'Networks', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'network',
        'dbname' => 'network_id',
        'itemtype' => '\App\Models\Network',
      ],
      [
        'id'    => 47,
        'title' => $translator->translate('UUID'),
        'type'  => 'input',
        'name'  => 'uuid',
      ],
      [
        'id'    => 42,
        'title' => $translator->translate('Update Source', 'Update Sources', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'autoupdatesystem',
        'dbname' => 'autoupdatesystem_id',
        'itemtype' => '\App\Models\Autoupdatesystem',
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
        'name'  => 'udpated_at',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 121,
        'title' => $translator->translate('Creation date'),
        'type'  => 'datetime',
        'name'  => 'created_at',
        'readonly'  => 'readonly',
      ],
    ];
  }
  public static function getDefinitionOperatingSystem()
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
        'id'    => 2,
        'title' => $translator->translatePlural('Architecture', 'Architectures', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'architecture',
        'dbname' => 'operatingsystemarchitecture_id',
        'itemtype' => '\App\Models\Operatingsystemarchitecture',
      ],
      [
        'id'    => 3,
        'title' => $translator->translatePlural('Kernel', 'Kernels', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'kernelversion',
        'dbname' => 'operatingsystemkernelversion_id',
        'itemtype' => '\App\Models\Operatingsystemkernelversion',
      ],
      [
        'id'    => 4,
        'title' => $translator->translatePlural('Version', 'Versions', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'version',
        'dbname' => 'operatingsystemversion_id',
        'itemtype' => '\App\Models\Operatingsystemversion',
      ],
      [
        'id'    => 5,
        'title' => $translator->translatePlural('Service pack', 'Service packs', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'servicepack',
        'dbname' => 'operatingsystemservicepack_id',
        'itemtype' => '\App\Models\Operatingsystemservicepack',
      ],
      [
        'id'    => 6,
        'title' => $translator->translatePlural('Edition', 'Editions', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'edition',
        'dbname' => 'operatingsystemedition_id',
        'itemtype' => '\App\Models\Operatingsystemedition',
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Product ID'),
        'type'  => 'input',
        'name'  => 'licenseid',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Serial number'),
        'type'  => 'input',
        'name'  => 'licensenumber',
      ],
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Computer', 'Computers', 1),
        'icon' => 'home',
        'link' => $rootUrl,
      ],
      [
        'title' => $translator->translatePlural('Operating system', 'Operating systems', 1),
        'icon' => 'laptop house',
        'link' => $rootUrl . '/operatingsystem',
      ],
      [
        'title' => $translator->translatePlural('Component', 'Components', 2),
        'icon' => 'microchip',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Volume', 'Volumes', 2),
        'icon' => 'hdd',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Software', 'Software', 2),
        'icon' => 'cube',
        'link' => $rootUrl . '/softwares',
      ],
      [
        'title' => $translator->translatePlural('Connection', 'Connections', 2),
        'icon' => 'linkify',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Network port', 'Network ports', 2),
        'icon' => 'ethernet',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Document', 'Documents', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Virtualization'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Antivirus', 'Antiviruses', 2),
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
        'title' => $translator->translatePlural('Certificate', 'Certificates', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Lock', 'Locks', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Note', 'Notes', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Reservation', 'Reservations', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Domain', 'Domains', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Appliance', 'Appliances', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => $rootUrl . '/history',
      ],
      [
        'title' => $translator->translate('Information d\'import'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
    ];
  }
}
