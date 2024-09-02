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
            'link' => $basepath . '/itemdevicesimcard',
            'icon' => 'sim card',
            'class' => $activePath == $basepath . '/itemdevicesimcard' ? 'active' : '',
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
          // [
          //   'name' => $translator->translatePlural('User', 'Users', 2),
          //   'link' => $basepath . '/users',
          //   'icon' => 'user',
          //   'class' => $activePath == $basepath . '/users' ? 'active' : '',
          // ],
          // [
          //   'name' => $translator->translatePlural('Group', 'Groups', 2),
          //   'link' => $basepath . '/groups',
          //   'icon' => 'users',
          //   'class' => $activePath == $basepath . '/groups' ? 'active' : '',
          // ],
          // [
          //   'name' => $translator->translatePlural('Entity', 'Entities', 2),
          //   'link' => $basepath . '/entities',
          //   'icon' => 'layer group',
          //   'class' => $activePath == $basepath . '/entities' ? 'active' : '',
          // ],
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
          // [
          //   'name' => $translator->translatePlural(''Profile', 'Profiles', 2'),
          //   'link' => $basepath . '/profiles',
          //   'icon' => 'user check',
          //   'class' => $activePath == $basepath . '/profiles' ? 'active' : '',
          // ],
          // [
          //   'name' => $translator->translate('Notification queue'),
          //   'link' => $basepath . '/queuednotifications',
          //   'icon' => 'list alt',
          //   'class' => $activePath == $basepath . '/queuednotifications' ? 'active' : '',
          // ],
          // [
          //   'name' => $translator->translatePlural('Log', 'Logs', 2),
          //   'link' => $basepath . '/events',
          //   'icon' => 'scroll',
          //   'class' => $activePath == $basepath . '/events' ? 'active' : '',
          // ],
          // [
          //   'name' => $translator->translatePlural('Form', 'Forms', 2),
          //   'link' => $basepath . '/forms',
          //   'icon' => 'edit',
          //   'class' => $activePath == $basepath . '/forms' ? 'active' : '',
          // ],
        ],
      ],
      [
        'name' => $translator->translate('Setup'),
        'icon' => 'tools',
        'sub'  => [
          // [
          //   'name' => $translator->translatePlural('Dropdown', 'Dropdowns', 2),
          //   'link' => $basepath . '/dropdowns',
          //   'icon' => 'edit',
          //   'class' => $activePath == $basepath . '/dropdowns' ? 'active' : '',
          // ],
          // [
          //   'name' => $translator->translatePlural('Component', 'Components', 2),
          //   'link' => $basepath . '/devices',
          //   'icon' => 'square outline',
          //   'class' => $activePath == $basepath . '/devices' ? 'active' : '',
          // ],
          // [
          //   'name' => $translator->translatePlural('Notification', 'Notifications', 2),
          //   'link' => $basepath . '/notifications',
          //   'icon' => 'bell',
          //   'class' => $activePath == $basepath . '/notifications' ? 'active' : '',
          // ],
          // [
          //   'name' => $translator->translatePlural('Service level', 'Service levels', 2),
          //   'link' => $basepath . '/slms',
          //   'icon' => 'file contract',
          //   'class' => $activePath == $basepath . '/slms' ? 'active' : '',
          // ],
          // [
          //   'name' => $translator->translate('Fields unicity'),
          //   'link' => $basepath . '/fieldunicitys',
          //   'icon' => 'fingerprint',
          //   'class' => $activePath == $basepath . '/fieldunicitys' ? 'active' : '',
          // ],
          // [
          //   'name' => $translator->translatePlural('Automatic action', 'Automatic actions', 2),
          //   'link' => $basepath . '/crontasks',
          //   'icon' => 'stopwatch',
          //   'class' => $activePath == $basepath . '/crontasks' ? 'active' : '',
          // ],
          // [
          //   'name' => $translator->translatePlural('Receiver', 'Receivers', 2),
          //   'link' => $basepath . '/collectors',
          //   'icon' => 'inbox',
          //   'class' => $activePath == $basepath . '/collectors' ? 'active' : '',
          // ],
          // [
          //   'name' => $translator->translatePlural('External link', 'External links', 2),
          //   'link' => $basepath . '/links',
          //   'icon' => 'linkify',
          //   'class' => $activePath == $basepath . '/links' ? 'active' : '',
          // ],
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
