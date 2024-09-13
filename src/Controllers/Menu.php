<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

final class Menu
{
  public static function getMenu(Request $request)
  {
    global $translator;

    $menu = new self();
    $basepath = \App\Controllers\Toolbox::getRootPath($request);
    $activePath = $basepath . $menu->getActivePath($request);

    return [
      [
        'name' => $translator->translate('Home'),
        'icon' => 'home',
        'sub'  => [],
      ],
      [
        'name' => $translator->translate('Assets'),
        'icon' => 'laptop house',
        'sub'  => [
          [
            'name'  => $translator->translatePlural('Computer', 'Computers', 2),
            'link'  => $basepath . '/computers',
            'icon'  => 'laptop',
            'class' => $activePath == $basepath . '/computers' ? 'active' : '',
          ],
          [
            'name'  => $translator->translatePlural('Monitor', 'Monitors', 2),
            'link'  => $basepath . '/monitors',
            'icon'  => 'desktop',
            'class' => $activePath == $basepath . '/monitors' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Software', 'Software', 2),
            'link' => $basepath . '/softwares',
            'icon' => 'cube',
            'class' => $activePath == $basepath . '/softwares' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Network device', 'Network devices', 2),
            'link' => $basepath . '/networkequipments',
            'icon' => 'network wired',
            'class' => $activePath == $basepath . '/networkequipments' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Device', 'Devices', 2),
            'link' => $basepath . '/peripherals',
            'icon' => 'usb',
            'class' => $activePath == $basepath . '/peripherals' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Printer', 'Printers', 2),
            'link' => $basepath . '/printers',
            'icon' => 'print',
            'class' => $activePath == $basepath . '/printers' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Cartridge', 'Cartridges', 2),
            'link' => $basepath . '/cartridgeitems',
            'icon' => 'fill drip',
            'class' => $activePath == $basepath . '/cartridgeitems' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Consumable', 'Consumables', 2),
            'link' => $basepath . '/consumableitems',
            'icon' => 'box open',
            'class' => $activePath == $basepath . '/consumableitems' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Phone', 'Phones', 2),
            'link' => $basepath . '/phones',
            'icon' => 'phone',
            'class' => $activePath == $basepath . '/phones' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Rack', 'Racks', 2),
            'link' => $basepath . '/racks',
            'icon' => 'server',
            'class' => $activePath == $basepath . '/racks' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Enclosure', 'Enclosures', 2),
            'link' => $basepath . '/enclosures',
            'icon' => 'th',
            'class' => $activePath == $basepath . '/enclosures' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('PDU', 'PDUs', 2),
            'link' => $basepath . '/pdus',
            'icon' => 'plug',
            'class' => $activePath == $basepath . '/pdus' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Passive device', 'Passive devices', 2),
            'link' => $basepath . '/passivedcequipments',
            'icon' => 'th list',
            'class' => $activePath == $basepath . '/passivedcequipments' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Simcard', 'Simcards', 2),
            'link' => $basepath . '/item_devicesimcards',
            'icon' => 'sim card',
            'class' => $activePath == $basepath . '/item_devicesimcards' ? 'active' : '',
          ],
        ],
      ],
      [
        'name' => $translator->translate('Assistance'),
        'icon' => 'hands helping',
        'sub'  => [
          [
            'name'  => $translator->translatePlural('Ticket', 'Tickets', 2),
            'link'  => $basepath . '/tickets',
            'icon'  => 'hands helping',
            'class' => $activePath == $basepath . '/tickets' ? 'active' : '',
          ],
          [
            'name'  => $translator->translatePlural('Problem', 'Problems', 2),
            'link'  => $basepath . '/problems',
            'icon'  => 'exclamation triangle',
            'class' => $activePath == $basepath . '/problems' ? 'active' : '',
          ],
          [
            'name'  => $translator->translatePlural('Change', 'Changes', 2),
            'link'  => $basepath . '/changes',
            'icon'  => 'clipboard check',
            'class' => $activePath == $basepath . '/changes' ? 'active' : '',
          ],
          [
            'name'  => $translator->translate('Recurrent tickets'),
            'link'  => $basepath . '/ticketrecurrents',
            'icon'  => 'stopwatch',
            'class' => $activePath == $basepath . '/ticketrecurrents' ? 'active' : '',
          ],
        ],
      ],
      [
        'name' => $translator->translate('Management'),
        'icon' => 'block layout',
        'sub'  => [
          [
            'name' => $translator->translatePlural('License', 'Licenses', 2),
            'link' => $basepath . '/softwarelicenses',
            'icon' => 'key',
            'class' => $activePath == $basepath . '/softwarelicenses' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Budget', 'Budgets', 2),
            'link' => $basepath . '/budgets',
            'icon' => 'calculator',
            'class' => $activePath == $basepath . '/budgets' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Supplier', 'Suppliers', 2),
            'link' => $basepath . '/suppliers',
            'icon' => 'dolly',
            'class' => $activePath == $basepath . '/suppliers' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Contact', 'Contacts', 2),
            'link' => $basepath . '/contacts',
            'icon' => 'user tie',
            'class' => $activePath == $basepath . '/contacts' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Contract', 'Contracts', 2),
            'link' => $basepath . '/contracts',
            'icon' => 'file signature',
            'class' => $activePath == $basepath . '/contracts' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Document', 'Documents', 2),
            'link' => $basepath . '/documents',
            'icon' => 'file',
            'class' => $activePath == $basepath . '/documents' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Line', 'Lines', 2),
            'link' => $basepath . '/lines',
            'icon' => 'phone',
            'class' => $activePath == $basepath . '/lines' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Certificate', 'Certificates', 2),
            'link' => $basepath . '/certificates',
            'icon' => 'certificate',
            'class' => $activePath == $basepath . '/certificates' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Data center', 'Data centers', 2),
            'link' => $basepath . '/datacenters',
            'icon' => 'warehouse',
            'class' => $activePath == $basepath . '/datacenters' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Cluster', 'Clusters', 2),
            'link' => $basepath . '/clusters',
            'icon' => 'project diagram',
            'class' => $activePath == $basepath . '/clusters' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Domain', 'Domains', 2),
            'link' => $basepath . '/domains',
            'icon' => 'globe americas',
            'class' => $activePath == $basepath . '/domains' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Appliance', 'Appliances', 2),
            'link' => $basepath . '/appliances',
            'icon' => 'cubes',
            'class' => $activePath == $basepath . '/appliances' ? 'active' : '',
          ],

        ],
      ],
      [
        'name' => $translator->translate('Tools'),
        'icon' => 'toolbox',
        'sub'  => [
          [
            'name' => $translator->translatePlural('Project', 'Projects', 2),
            'link' => $basepath . '/projects',
            'icon' => 'columns',
            'class' => $activePath == $basepath . '/projects' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Note', 'Notes', 2),
            'link' => $basepath . '/reminders',
            'icon' => 'sticky note',
            'class' => $activePath == $basepath . '/reminders' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('RSS feed', 'RSS feed', 2),
            'link' => $basepath . '/rssfeeds',
            'icon' => 'rss',
            'class' => $activePath == $basepath . '/rssfeeds' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Saved search', 'Saved searches', 2),
            'link' => $basepath . '/savedsearchs',
            'icon' => 'bookmark',
            'class' => $activePath == $basepath . '/savedsearchs' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Alert', 'Alerts', 2),
            'link' => $basepath . '/news',
            'icon' => 'bell',
            'class' => $activePath == $basepath . '/news' ? 'active' : '',
          ],
        ],
      ],
      [
        'name' => $translator->translate('Administration'),
        'icon' => 'screwdriver',
        'sub'  => [
          [
            'name' => $translator->translatePlural('User', 'Users', 2),
            'link' => $basepath . '/users',
            'icon' => 'user',
            'class' => $activePath == $basepath . '/users' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Group', 'Groups', 2),
            'link' => $basepath . '/groups',
            'icon' => 'users',
            'class' => $activePath == $basepath . '/groups' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Entity', 'Entities', 2),
            'link' => $basepath . '/entities',
            'icon' => 'layer group',
            'class' => $activePath == $basepath . '/entities' ? 'active' : '',
          ],
          // [
          //   'name' => $translator->translatePlural('Rule', 'Rules', 2),
          //   'link' => $basepath . '/rules',
          //   'icon' => 'book',
          //   'class' => $activePath == $basepath . '/rules' ? 'active' : '',
          // ],
          [
            'name' => $translator->translate('Business rules for tickets'),
            'link' => $basepath . '/rules/tickets',
            'icon' => 'magic',
            'class' => $activePath == $basepath . '/rules/tickets' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Profile', 'Profiles', 2),
            'link' => $basepath . '/profiles',
            'icon' => 'user check',
            'class' => $activePath == $basepath . '/profiles' ? 'active' : '',
          ],
          [
            'name' => $translator->translate('Notification queue'),
            'link' => $basepath . '/queuednotifications',
            'icon' => 'list alt',
            'class' => $activePath == $basepath . '/queuednotifications' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Log', 'Logs', 2),
            'link' => $basepath . '/events',
            'icon' => 'scroll',
            'class' => $activePath == $basepath . '/events' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Form', 'Forms', 2),
            'link' => $basepath . '/forms',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/forms' ? 'active' : '',
          ],
        ],
      ],
      [
        'name' => $translator->translate('Setup'),
        'icon' => 'tools',
        'sub'  => [
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Location', 'Locations', 2),
            'link' => $basepath . '/dropdowns/locations',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/locations' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Status of items', 'Statuses of items', 2),
            'link' => $basepath . '/dropdowns/states',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/states' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Manufacturer', 'Manufacturers', 2),
            'link' => $basepath . '/dropdowns/manufacturers',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/manufacturers' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Blacklist', 'Blacklists', 2),
            'link' => $basepath . '/dropdowns/blacklists',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/blacklists' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translate('Blacklisted mail content'),
            'link' => $basepath . '/dropdowns/blacklistedmailcontents',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/blacklistedmailcontents' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('ITIL category', 'ITIL categories', 2),
            'link' => $basepath . '/dropdowns/itilcategories',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itilcategories' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Task category', 'Task categories', 2),
            'link' => $basepath . '/dropdowns/taskcategories',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/taskcategories' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Task template', 'Task templates', 2),
            'link' => $basepath . '/dropdowns/tasktemplates',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/tasktemplates' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Solution type', 'Solution types', 2),
            'link' => $basepath . '/dropdowns/solutiontypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/solutiontypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Solution template', 'Solution templates', 2),
            'link' => $basepath . '/dropdowns/solutiontemplates',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/solutiontemplates' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Request source', 'Request sources', 2),
            'link' => $basepath . '/dropdowns/requesttypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/requesttypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Followup template', 'Followup templates', 2),
            'link' => $basepath . '/dropdowns/itilfollowuptemplates',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itilfollowuptemplates' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Project state', 'Project states', 2),
            'link' => $basepath . '/dropdowns/projectstates',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/projectstates' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Project type', 'Project types', 2),
            'link' => $basepath . '/dropdowns/projecttypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/projecttypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Project tasks type', 'Project tasks types', 2),
            'link' => $basepath . '/dropdowns/projecttasktypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/projecttasktypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Project task template', 'Project task templates', 2),
            'link' => $basepath . '/dropdowns/projecttasktemplates',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/projecttasktemplates' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Event category', 'Event categories', 2),
            'link' => $basepath . '/dropdowns/planningeventcategories',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/planningeventcategories' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('External events template', 'External events templates', 2),
            'link' => $basepath . '/dropdowns/planningexternaleventtemplates',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/planningexternaleventtemplates' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Computer type', 'Computer types', 2),
            'link' => $basepath . '/dropdowns/computertypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/computertypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Networking equipment type', 'Networking equipment types', 2),
            'link' => $basepath . '/dropdowns/networkequipmenttypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/networkequipmenttypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Printer type', 'Printer types', 2),
            'link' => $basepath . '/dropdowns/printertypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/printertypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Monitor type', 'Monitor types', 2),
            'link' => $basepath . '/dropdowns/monitortypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/monitortypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Peripheral type', 'Peripheral types', 2),
            'link' => $basepath . '/dropdowns/peripheraltypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/peripheraltypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Phone type', 'Phone types', 2),
            'link' => $basepath . '/dropdowns/phonetypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/phonetypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('License type', 'License types', 2),
            'link' => $basepath . '/dropdowns/softwarelicensetypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/softwarelicensetypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Cartridge type', 'Cartridge types', 2),
            'link' => $basepath . '/dropdowns/cartridgeitemtypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/cartridgeitemtypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Consumable type', 'Consumable types', 2),
            'link' => $basepath . '/dropdowns/consumableitemtypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/consumableitemtypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Contract type', 'Contract types', 2),
            'link' => $basepath . '/dropdowns/contracttypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/contracttypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Contact type', 'Contact types', 2),
            'link' => $basepath . '/dropdowns/contacttypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/contacttypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Generic type', 'Generic types', 2),
            'link' => $basepath . '/dropdowns/itemdevicegenerictype',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicegenerictype' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Sensor type', 'Sensor types', 2),
            'link' => $basepath . '/dropdowns/itemdevicesensortype',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicesensortype' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Memory type', 'Memory types', 2),
            'link' => $basepath . '/dropdowns/itemdevicememorytype',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicememorytype' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Third party type', 'Third party types', 2),
            'link' => $basepath . '/dropdowns/suppliertypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/suppliertypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Interface type (Hard drive...)', 'Interface types (Hard drive...)', 2),
            'link' => $basepath . '/dropdowns/interfacetypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/interfacetypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Case type', 'Case types', 2),
            'link' => $basepath . '/dropdowns/itemdevicecasetype',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicecasetype' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Phone power supply type', 'Phone power supply types', 2),
            'link' => $basepath . '/dropdowns/phonepowersupplies',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/phonepowersupplies' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('File system', 'File systems', 2),
            'link' => $basepath . '/dropdowns/filesystems',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/filesystems' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Certificate type', 'Certificate types', 2),
            'link' => $basepath . '/dropdowns/certificatetypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/certificatetypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Budget type', 'Budget types', 2),
            'link' => $basepath . '/dropdowns/budgettypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/budgettypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Simcard type', 'Simcard types', 2),
            'link' => $basepath . '/dropdowns/devicesimcardtypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/devicesimcardtypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Line type', 'Line types', 2),
            'link' => $basepath . '/dropdowns/linetypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/linetypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Rack type', 'Rack types', 2),
            'link' => $basepath . '/dropdowns/racktypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/racktypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('PDU type', 'PDU types', 2),
            'link' => $basepath . '/dropdowns/pdutypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/pdutypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Passive device type', 'Passive device types', 2),
            'link' => $basepath . '/dropdowns/passivedcequipmenttypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/passivedcequipmenttypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Cluster type', 'Cluster types', 2),
            'link' => $basepath . '/dropdowns/clustertypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/clustertypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Computer model', 'Computer models', 2),
            'link' => $basepath . '/dropdowns/computermodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/computermodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Networking equipment model', 'Networking equipment models', 2),
            'link' => $basepath . '/dropdowns/networkequipmentmodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/networkequipmentmodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Printer model', 'Printer models', 2),
            'link' => $basepath . '/dropdowns/printermodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/printermodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Monitor model', 'Monitor models', 2),
            'link' => $basepath . '/dropdowns/monitormodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/monitormodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Peripheral model', 'Peripheral models', 2),
            'link' => $basepath . '/dropdowns/peripheralmodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/peripheralmodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Phone model', 'Phone models', 2),
            'link' => $basepath . '/dropdowns/phonemodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/phonemodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Device case model', 'Device case models', 2),
            'link' => $basepath . '/dropdowns/itemdevicecasemodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicecasemodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Device control model', 'Device control models', 2),
            'link' => $basepath . '/dropdowns/itemdevicecontrolmodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicecontrolmodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Device drive model', 'Device drive models', 2),
            'link' => $basepath . '/dropdowns/itemdevicedrivemodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicedrivemodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Device generic model', 'Device generic models', 2),
            'link' => $basepath . '/dropdowns/itemdevicegenericmodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicegenericmodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Device graphic card model', 'Device graphic card models', 2),
            'link' => $basepath . '/dropdowns/itemdevicegraphiccardmodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicegraphiccardmodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Device hard drive model', 'Device hard drive models', 2),
            'link' => $basepath . '/dropdowns/itemdeviceharddrivemodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdeviceharddrivemodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Device memory model', 'Device memory models', 2),
            'link' => $basepath . '/dropdowns/itemdevicememorymodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicememorymodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('System board model', 'System board models', 2),
            'link' => $basepath . '/dropdowns/itemdevicemotherboardmodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicemotherboardmodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Network card model', 'Network card models', 2),
            'link' => $basepath . '/dropdowns/itemdevicenetworkcardmodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicenetworkcardmodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Other component model', 'Other component models', 2),
            'link' => $basepath . '/dropdowns/itemdevicepcimodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicepcimodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Device power supply model', 'Device power supply models', 2),
            'link' => $basepath . '/dropdowns/itemdevicepowersupplymodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicepowersupplymodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Device processor model', 'Device processor models', 2),
            'link' => $basepath . '/dropdowns/itemdeviceprocessormodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdeviceprocessormodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Device sound card model', 'Device sound card models', 2),
            'link' => $basepath . '/dropdowns/itemdevicesoundcardmodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicesoundcardmodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Device sensor model', 'Device sensor models', 2),
            'link' => $basepath . '/dropdowns/itemdevicesensormodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/itemdevicesensormodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Rack model', 'Rack models', 2),
            'link' => $basepath . '/dropdowns/rackmodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/rackmodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Enclosure model', 'Enclosure models', 2),
            'link' => $basepath . '/dropdowns/enclosuremodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/enclosuremodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('PDU model', 'PDU models', 2),
            'link' => $basepath . '/dropdowns/pdumodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/pdumodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Passive device model', 'Passive device models', 2),
            'link' => $basepath . '/dropdowns/passivedcequipmentmodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/passivedcequipmentmodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Virtualization system', 'Virtualization systems', 2),
            'link' => $basepath . '/dropdowns/virtualmachinetypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/virtualmachinetypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Virtualization model', 'Virtualization models', 2),
            'link' => $basepath . '/dropdowns/virtualmachinesystems',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/virtualmachinesystems' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('State of the virtual machine', 'States of the virtual machine', 2),
            'link' => $basepath . '/dropdowns/virtualmachinestates',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/virtualmachinestates' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Document heading', 'Document headings', 2),
            'link' => $basepath . '/dropdowns/documentcategories',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/documentcategories' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Document type', 'Document types', 2),
            'link' => $basepath . '/dropdowns/documenttypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/documenttypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Business criticity', 'Business criticities', 2),
            'link' => $basepath . '/dropdowns/businesscriticities',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/businesscriticities' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Knowledge base category', 'Knowledge base categories', 2),
            'link' => $basepath . '/dropdowns/knowbaseitemcategories',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/knowbaseitemcategories' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Calendar', 'Calendars', 2),
            'link' => $basepath . '/dropdowns/calendars',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/calendars' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Close time', 'Close times', 2),
            'link' => $basepath . '/dropdowns/holidays',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/holidays' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Operating system', 'Operating systems', 2),
            'link' => $basepath . '/dropdowns/operatingsystems',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/operatingsystems' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Version of the operating system', 'Versions of the operating systems', 2),
            'link' => $basepath . '/dropdowns/operatingsystemversions',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/operatingsystemversions' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Service pack', 'Service packs', 2),
            'link' => $basepath . '/dropdowns/operatingsystemservicepacks',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/operatingsystemservicepacks' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Operating system architecture', 'Operating system architectures', 2),
            'link' => $basepath . '/dropdowns/operatingsystemarchitectures',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/operatingsystemarchitectures' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Edition', 'Editions', 2),
            'link' => $basepath . '/dropdowns/operatingsystemeditions',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/operatingsystemeditions' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Kernel', 'Kernels', 2),
            'link' => $basepath . '/dropdowns/operatingsystemkernels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/operatingsystemkernels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Kernel version', 'Kernel versions', 2),
            'link' => $basepath . '/dropdowns/operatingsystemkernelversions',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/operatingsystemkernelversions' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Update Source', 'Update Sources', 2),
            'link' => $basepath . '/dropdowns/autoupdatesystems',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/autoupdatesystems' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Network interface', 'Network interfaces', 2),
            'link' => $basepath . '/dropdowns/networkinterfaces',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/networkinterfaces' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Network outlet', 'Network outlets', 2),
            'link' => $basepath . '/dropdowns/netpoints',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/netpoints' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Network', 'Networks', 2),
            'link' => $basepath . '/dropdowns/networks',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/networks' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('VLAN', 'VLANs', 2),
            'link' => $basepath . '/dropdowns/vlans',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/vlans' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Line operator', 'Line operators', 2),
            'link' => $basepath . '/dropdowns/lineoperators',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/lineoperators' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Domain type', 'Domain types', 2),
            'link' => $basepath . '/dropdowns/domaintypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/domaintypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Domain relation', 'Domains relations', 2),
            'link' => $basepath . '/dropdowns/domainrelations',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/domainrelations' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Record type', 'Records types', 2),
            'link' => $basepath . '/dropdowns/domainrecordtypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/domainrecordtypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('IP network', 'IP networks', 2),
            'link' => $basepath . '/dropdowns/ipnetworks',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/ipnetworks' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Internet domain', 'Internet domains', 2),
            'link' => $basepath . '/dropdowns/fqdns',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/fqdns' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Wifi network', 'Wifi networks', 2),
            'link' => $basepath . '/dropdowns/wifinetworks',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/wifinetworks' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Network name', 'Network names', 2),
            'link' => $basepath . '/dropdowns/networknames',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/networknames' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Software category', 'Software categories', 2),
            'link' => $basepath . '/dropdowns/softwarecategories',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/softwarecategories' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('User title', 'Users titles', 2),
            'link' => $basepath . '/dropdowns/usertitles',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/usertitles' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('User category', 'User categories', 2),
            'link' => $basepath . '/dropdowns/usercategories',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/usercategories' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('LDAP criterion', 'LDAP criteria', 2),
            'link' => $basepath . '/dropdowns/rulerightparameters',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/rulerightparameters' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Ignored value for the unicity', 'Ignored values for the unicity', 2),
            'link' => $basepath . '/dropdowns/fieldblacklists',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/fieldblacklists' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Field storage of the login in the HTTP request', 'Fields storage of the login in the HTTP request', 2),
            'link' => $basepath . '/dropdowns/ssovariables',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/ssovariables' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Plug', 'Plugs', 2),
            'link' => $basepath . '/dropdowns/plugs',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/plugs' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Appliance type', 'Appliance types', 2),
            'link' => $basepath . '/dropdowns/appliancetypes',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/appliancetypes' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Appliance environment', 'Appliance environments', 2),
            'link' => $basepath . '/dropdowns/applianceenvironments',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/applianceenvironments' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Oauth IMAP application', 'Oauth IMAP applications', 2),
            'link' => $basepath . '/dropdowns/oauthimapapplications',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/oauthimapapplications' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2) . ' - ' . $translator->translatePlural('Form category', 'Form categories', 2),
            'link' => $basepath . '/dropdowns/formcreatorcategories',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/dropdowns/formcreatorcategories' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Power supply', 'Power supplies', 2),
            'link' => $basepath . '/devices/itemdevicepowersupplies',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicepowersupplies' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Battery', 'Batteries', 2),
            'link' => $basepath . '/devices/itemdevicebatteries',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicebatteries' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Case', 'Cases', 2),
            'link' => $basepath . '/devices/itemdevicecases',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicecases' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Sensor', 'Sensors', 2),
            'link' => $basepath . '/devices/itemdevicesensors',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicesensors' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Simcard', 'Simcards', 2),
            'link' => $basepath . '/devices/itemdevicesimcards',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicesimcards' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Graphics card', 'Graphics cards', 2),
            'link' => $basepath . '/devices/itemdevicegraphiccards',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicegraphiccards' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('System board', 'System boards', 2),
            'link' => $basepath . '/devices/itemdevicemotherboards',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicemotherboards' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Network card', 'Network cards', 2),
            'link' => $basepath . '/devices/itemdevicenetworkcards',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicenetworkcards' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Soundcard', 'Soundcards', 2),
            'link' => $basepath . '/devices/itemdevicesoundcardmodels',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicesoundcardmodels' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Generic device', 'Generic devices', 2),
            'link' => $basepath . '/devices/itemdevicegenerics',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicegenerics' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Controller', 'Controllers', 2),
            'link' => $basepath . '/devices/itemdevicecontrols',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicecontrols' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Hard drive', 'Hard drives', 2),
            'link' => $basepath . '/devices/itemdeviceharddrives',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdeviceharddrives' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Firmware', 'Firmware', 2),
            'link' => $basepath . '/devices/itemdevicefirmwares',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicefirmwares' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Drive', 'Drives', 2),
            'link' => $basepath . '/devices/itemdevicedrives',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicedrives' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Memory', 'Memory', 2),
            'link' => $basepath . '/devices/itemdevicememories',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicememories' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('Processor', 'Processors', 2),
            'link' => $basepath . '/devices/itemdeviceprocessors',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdeviceprocessors' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Component', 'Components', 2) . ' - ' . $translator->translatePlural('PCI device', 'PCI devices', 2),
            'link' => $basepath . '/devices/itemdevicepcis',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/devices/itemdevicepcis' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Notification', 'Notifications', 2) . ' - ' . $translator->translatePlural('Notification template', 'Notification templates', 2),
            'link' => $basepath . '/notifications/notificationtemplates',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/notifications/notificationtemplates' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Notification', 'Notifications', 2) . ' - ' . $translator->translatePlural('Notification', 'Notifications', 2),
            'link' => $basepath . '/notifications/notifications',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/notifications/notifications' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Service level', 'Service levels', 2),
            'link' => $basepath . '/slms',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/slms' ? 'active' : '',
          ],
          [
            'name' => $translator->translate('Fields unicity'),
            'link' => $basepath . '/fieldunicities',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/fieldunicities' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('Automatic action', 'Automatic actions', 2),
            'link' => $basepath . '/crontasks',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/crontasks' ? 'active' : '',
          ],
          [
            'name' => $translator->translatePlural('External link', 'External links', 2),
            'link' => $basepath . '/links',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/links' ? 'active' : '',
          ],
          [
            'name' => "#".$translator->translatePlural('Receiver', 'Receivers', 2),
            'link' => $basepath . '/mailcollectors',
            'icon' => 'edit',
            'class' => $activePath == $basepath . '/mailcollectors' ? 'active' : '',
          ],





        ],
      ],
    ];
  }

  private function getActivePath(Request $request)
  {
    $routeContext = RouteContext::fromRequest($request);
    $route = $routeContext->getRoute();
    $groups = $route->getGroups();
    if (count($groups) == 0)
    {
      return '';
    }
    // get first group
    $group = current($groups);
    return $group->getPattern();
  }
}

// ITAM
//   Hardware inventory
//      Ordinateurs
//      Moniteurs
//      Périphériques
//      Imprimantes
//      Cartouches
//      Consommables
//      Téléphones
//      Baies
//      Châssis
//      PDU
//      Équipements passifs
//      Cartes SIM
//   User data
//   Administrative data
//      Documents
//   Contract & cost management
//      Licences
//      Contrats
//      Lignes
//      Certificats
//   Software inventory
//      Logiciels
//      Systèmes d'exploitation
//      Applicatifs
//   Network inventory
//      Matériels réseau

// ITSM




// Service strategie
//      Budgets
//      Tickets demande

// Service design
//      Niveaux de services
//      Fournisseurs
//      Contacts

// Service transaction
//      Changements
//      Assets
//      Base de connaissances

// Service operations
//      Service desk
//      Tickets incidents
//      Problèmes




//////////////////// OLD //////////////////

// Assistance
//      Créer un ticket
//      Planning
//      Statistiques
//      Tickets récurrents
//      Formulaires

// Gestion
//      Data centers
//      Clusters
//      Domaines

// Outils
//      Projets
//      Notes
//      Flux RSS
//      Réservations
//      Rapports
//      Recherches sauvegardées
//      Data Injection
//      Alertes

// Administration
//      Utilisateurs
//      Groupes
//      Entités
//      Règles
//      Dictionnaires
//      Profils
//      File d'attente des notifications
//      Journaux
//      FusionInventory
//      Formulaires

// Configuration
//      Intitulés
//      Composants
//      Notifications
//      Générale
//      Unicité des champs
//      Actions automatiques
//      Authentification
//      Collecteurs
//      Liens externes
//      Plugins
//      Notifications generation
//      Tasks Workflows
//      Applications Oauth IMAP
