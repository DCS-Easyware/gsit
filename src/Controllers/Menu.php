<?php

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteContext;

final class Menu
{

  static public function getMenu(Request $request)
  {
    global $translator;

    $menu = new self();
    $basepath = $menu->getRootPath($request);
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
        ],
      ],
    // [ // TODO I think must delete this
      //   'name' => $translator->translate('Management'),
      //   'icon' => 'block layout',
      // ],
      [
        'name' => $translator->translate('Tools'),
        'icon' => 'toolbox',
        'sub'  => [

        ],
      ],
      [
        'name' => $translator->translate('Administration'),
        'icon' => 'screwdriver',
        'sub'  => [

        ],
      ],
      [
        'name' => $translator->translate('Setup'),
        'icon' => 'tools',
        'sub'  => [

        ],
      ],
    ];
  }

  private function getRootPath(Request $request)
  {
    $routeContext = RouteContext::fromRequest($request);
    return $routeContext->getBasePath();
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

 