<?php

namespace App\Controllers;

final class Menu
{

  static public function getMenu()
  {
    global $translator;
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
            'link'  => '/gsit/computers',
            'icon'  => 'laptop',
            'class' => 'active',
          ],
          [
            'name'  => $translator->translatePlural('Monitor', 'Monitors', 2),
            'link'  => '/gsit/monitors',
            'icon'  => 'desktop',
            'class' => '',
          ],
          [
            'name' => $translator->translatePlural('Software', 'Software', 2),
            'link' => '/gsit/softwares',
            'icon' => 'cube',
            'class' => '',
          ],
        ],
      ],
      [
        'name' => $translator->translate('Assistance'),
        'icon' => 'hands helping',
        'sub'  => [
          [
            'name'  => $translator->translatePlural('Ticket', 'Tickets', 2),
            'link'  => '/gsit/tickets',
            'icon'  => 'hands helping',
            'class' => '',
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

 