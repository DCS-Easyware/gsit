<?php

namespace App;

use Slim\Routing\RouteCollectorProxy;

final class Route
{
  public static function setRoutes(&$app, $prefix)
  {
    // Enable OPTIONS method for all routes
    $app->options($prefix . '/{routes:.+}', function ($request, $response, $args)
    {
      return $response;
    });

    // The ping - pong ;)
    // $app->get($prefix . '/ping', \App\v1\Controllers\Ping::class . ':getPing');

    $app->map(['POST'], '/dropdown', \App\Controllers\Dropdown::class . ':getAll');

    $app->group($prefix . '/login', function (RouteCollectorProxy $login)
    {
      $login->map(['GET'], '', \App\Controllers\Login::class . ':getLogin');
      $login->map(['POST'], '', \App\Controllers\Login::class . ':postLogin');
    });

    $app->group($prefix . '/computers', function (RouteCollectorProxy $computers)
    {
      $computers->map(['GET'], '', \App\Controllers\Computer::class . ':getAll');
      $computers->map(['POST'], '', \App\Controllers\Computer::class . ':postItem');
      $computers->group("/{id:[0-9]+}", function (RouteCollectorProxy $computerId)
      {
        $computerId->map(['GET'], '', \App\Controllers\Computer::class . ':showItem');
        $computerId->map(['POST'], '', \App\Controllers\Computer::class . ':updateItem');
        $computerId->map(['GET'], '/operatingsystem', \App\Controllers\Computer::class . ':showOperatingSystem');
        $computerId->map(['GET'], '/softwares', \App\Controllers\Computer::class . ':showSoftwares');
      });
    });
    $app->group($prefix . '/monitors', function (RouteCollectorProxy $monitors)
    {
      $monitors->map(['GET'], '', \App\Controllers\Monitor::class . ':getAll');
      $monitors->map(['POST'], '', \App\Controllers\Monitor::class . ':postItem');
      $monitors->group("/{id:[0-9]+}", function (RouteCollectorProxy $monitorId)
      {
        $monitorId->map(['GET'], '', \App\Controllers\Monitor::class . ':showItem');
        $monitorId->map(['POST'], '', \App\Controllers\Monitor::class . ':updateItem');
      });
    });
    $app->group($prefix . '/softwares', function (RouteCollectorProxy $softwares)
    {
      $softwares->map(['GET'], '', \App\Controllers\Software::class . ':getAll');
      $softwares->map(['POST'], '', \App\Controllers\Software::class . ':postItem');
      $softwares->group("/{id:[0-9]+}", function (RouteCollectorProxy $softwareId)
      {
        $softwareId->map(['GET'], '', \App\Controllers\Software::class . ':showItem');
        $softwareId->map(['POST'], '', \App\Controllers\Software::class . ':updateItem');
      });
    });
    $app->group($prefix . '/networkequipments', function (RouteCollectorProxy $networkequipments)
    {
      $networkequipments->map(['GET'], '', \App\Controllers\NetworkEquipment::class . ':getAll');
      $networkequipments->map(['POST'], '', \App\Controllers\NetworkEquipment::class . ':postItem');
      $networkequipments->group("/{id:[0-9]+}", function (RouteCollectorProxy $networkequipmentId)
      {
        $networkequipmentId->map(['GET'], '', \App\Controllers\NetworkEquipment::class . ':showItem');
        $networkequipmentId->map(['POST'], '', \App\Controllers\NetworkEquipment::class . ':updateItem');
      });
    });
    $app->group($prefix . '/peripherals', function (RouteCollectorProxy $peripherals)
    {
      $peripherals->map(['GET'], '', \App\Controllers\Peripheral::class . ':getAll');
      $peripherals->map(['POST'], '', \App\Controllers\Peripheral::class . ':postItem');
      $peripherals->group("/{id:[0-9]+}", function (RouteCollectorProxy $peripheralId)
      {
        $peripheralId->map(['GET'], '', \App\Controllers\Peripheral::class . ':showItem');
        $peripheralId->map(['POST'], '', \App\Controllers\Peripheral::class . ':updateItem');
      });
    });
    $app->group($prefix . '/printers', function (RouteCollectorProxy $printers)
    {
      $printers->map(['GET'], '', \App\Controllers\Printer::class . ':getAll');
      $printers->map(['POST'], '', \App\Controllers\Printer::class . ':postItem');
      $printers->group("/{id:[0-9]+}", function (RouteCollectorProxy $printerId)
      {
        $printerId->map(['GET'], '', \App\Controllers\Printer::class . ':showItem');
        $printerId->map(['POST'], '', \App\Controllers\Printer::class . ':updateItem');
      });
    });
    $app->group($prefix . '/cartridgeitems', function (RouteCollectorProxy $cartridgeitems)
    {
      $cartridgeitems->map(['GET'], '', \App\Controllers\CartridgeItem::class . ':getAll');
      $cartridgeitems->map(['POST'], '', \App\Controllers\CartridgeItem::class . ':postItem');
      $cartridgeitems->group("/{id:[0-9]+}", function (RouteCollectorProxy $cartridgeitemId)
      {
        $cartridgeitemId->map(['GET'], '', \App\Controllers\CartridgeItem::class . ':showItem');
        $cartridgeitemId->map(['POST'], '', \App\Controllers\CartridgeItem::class . ':updateItem');
      });
    });
    $app->group($prefix . '/consumableitems', function (RouteCollectorProxy $consumableitems)
    {
      $consumableitems->map(['GET'], '', \App\Controllers\ConsumableItem::class . ':getAll');
      $consumableitems->map(['POST'], '', \App\Controllers\ConsumableItem::class . ':postItem');
      $consumableitems->group("/{id:[0-9]+}", function (RouteCollectorProxy $consumableitemId)
      {
        $consumableitemId->map(['GET'], '', \App\Controllers\ConsumableItem::class . ':showItem');
        $consumableitemId->map(['POST'], '', \App\Controllers\ConsumableItem::class . ':updateItem');
      });
    });
    $app->group($prefix . '/phones', function (RouteCollectorProxy $phones)
    {
      $phones->map(['GET'], '', \App\Controllers\Phone::class . ':getAll');
      $phones->map(['POST'], '', \App\Controllers\Phone::class . ':postItem');
      $phones->group("/{id:[0-9]+}", function (RouteCollectorProxy $phoneId)
      {
        $phoneId->map(['GET'], '', \App\Controllers\Phone::class . ':showItem');
        $phoneId->map(['POST'], '', \App\Controllers\Phone::class . ':updateItem');
      });
    });
    $app->group($prefix . '/racks', function (RouteCollectorProxy $racks)
    {
      $racks->map(['GET'], '', \App\Controllers\Rack::class . ':getAll');
      $racks->map(['POST'], '', \App\Controllers\Rack::class . ':postItem');
      $racks->group("/{id:[0-9]+}", function (RouteCollectorProxy $rackId)
      {
        $rackId->map(['GET'], '', \App\Controllers\Rack::class . ':showItem');
        $rackId->map(['POST'], '', \App\Controllers\Rack::class . ':updateItem');
      });
    });
    $app->group($prefix . '/enclosures', function (RouteCollectorProxy $enclosures)
    {
      $enclosures->map(['GET'], '', \App\Controllers\Enclosure::class . ':getAll');
      $enclosures->map(['POST'], '', \App\Controllers\Enclosure::class . ':postItem');
      $enclosures->group("/{id:[0-9]+}", function (RouteCollectorProxy $enclosureId)
      {
        $enclosureId->map(['GET'], '', \App\Controllers\Enclosure::class . ':showItem');
        $enclosureId->map(['POST'], '', \App\Controllers\Enclosure::class . ':updateItem');
      });
    });
    $app->group($prefix . '/pdus', function (RouteCollectorProxy $pdus)
    {
      $pdus->map(['GET'], '', \App\Controllers\PDU::class . ':getAll');
      $pdus->map(['POST'], '', \App\Controllers\PDU::class . ':postItem');
      $pdus->group("/{id:[0-9]+}", function (RouteCollectorProxy $pduId)
      {
        $pduId->map(['GET'], '', \App\Controllers\PDU::class . ':showItem');
        $pduId->map(['POST'], '', \App\Controllers\PDU::class . ':updateItem');
      });
    });
    $app->group($prefix . '/passivedcequipments', function (RouteCollectorProxy $passivedcequipments)
    {
      $passivedcequipments->map(['GET'], '', \App\Controllers\PassivedcEquipment::class . ':getAll');
      $passivedcequipments->map(['POST'], '', \App\Controllers\PassivedcEquipment::class . ':postItem');
      $passivedcequipments->group("/{id:[0-9]+}", function (RouteCollectorProxy $passivedcequipmentId)
      {
        $passivedcequipmentId->map(['GET'], '', \App\Controllers\PassivedcEquipment::class . ':showItem');
        $passivedcequipmentId->map(['POST'], '', \App\Controllers\PassivedcEquipment::class . ':updateItem');
      });
    });
    $app->group($prefix . '/item_devicesimcards', function (RouteCollectorProxy $item_devicesimcards)
    {
      $item_devicesimcards->map(['GET'], '', \App\Controllers\Item_DeviceSimcard::class . ':getAll');
      $item_devicesimcards->map(['POST'], '', \App\Controllers\Item_DeviceSimcard::class . ':postItem');
      $item_devicesimcards->group("/{id:[0-9]+}", function (RouteCollectorProxy $item_devicesimcardId)
      {
        $item_devicesimcardId->map(['GET'], '', \App\Controllers\Item_DeviceSimcard::class . ':showItem');
        $item_devicesimcardId->map(['POST'], '', \App\Controllers\Item_DeviceSimcard::class . ':updateItem');
      });
    });

    $app->post('/itilfollowups', \App\Controllers\Itilfollowup::class . ':postItem');

    $app->group($prefix . '/tickets', function (RouteCollectorProxy $tickets)
    {
      $tickets->map(['GET'], '', \App\Controllers\Ticket::class . ':getAll');
      $tickets->map(['POST'], '', \App\Controllers\Ticket::class . ':postItem');

      $tickets->group("/{id:[0-9]+}", function (RouteCollectorProxy $ticketId)
      {
        $ticketId->map(['GET'], '', \App\Controllers\Ticket::class . ':showItem');
        $ticketId->map(['POST'], '', \App\Controllers\Ticket::class . ':updateItem');
      });
    });
    $app->group($prefix . '/problems', function (RouteCollectorProxy $problems)
    {
      $problems->map(['GET'], '', \App\Controllers\Problem::class . ':getAll');
      $problems->map(['POST'], '', \App\Controllers\Problem::class . ':postItem');

      $problems->group("/{id:[0-9]+}", function (RouteCollectorProxy $problemId)
      {
        $problemId->map(['GET'], '', \App\Controllers\Problem::class . ':showItem');
        $problemId->map(['POST'], '', \App\Controllers\Problem::class . ':updateItem');
      });
    });
    $app->group($prefix . '/changes', function (RouteCollectorProxy $changes)
    {
      $changes->map(['GET'], '', \App\Controllers\Change::class . ':getAll');
      $changes->map(['POST'], '', \App\Controllers\Change::class . ':postItem');

      $changes->group("/{id:[0-9]+}", function (RouteCollectorProxy $changeId)
      {
        $changeId->map(['GET'], '', \App\Controllers\Change::class . ':showItem');
        $changeId->map(['POST'], '', \App\Controllers\Change::class . ':updateItem');
      });
    });
    $app->group($prefix . '/ticketrecurrents', function (RouteCollectorProxy $ticketrecurrents)
    {
      $ticketrecurrents->map(['GET'], '', \App\Controllers\TicketRecurrent::class . ':getAll');
      $ticketrecurrents->map(['POST'], '', \App\Controllers\TicketRecurrent::class . ':postItem');

      $ticketrecurrents->group("/{id:[0-9]+}", function (RouteCollectorProxy $ticketrecurrentId)
      {
        $ticketrecurrentId->map(['GET'], '', \App\Controllers\TicketRecurrent::class . ':showItem');
        $ticketrecurrentId->map(['POST'], '', \App\Controllers\TicketRecurrent::class . ':updateItem');
      });
    });


    $app->group($prefix . '/softwarelicenses', function (RouteCollectorProxy $softwarelicenses)
    {
      $softwarelicenses->map(['GET'], '', \App\Controllers\SoftwareLicense::class . ':getAll');
      $softwarelicenses->map(['POST'], '', \App\Controllers\SoftwareLicense::class . ':postItem');
      $softwarelicenses->group("/{id:[0-9]+}", function (RouteCollectorProxy $softwarelicenseId)
      {
        $softwarelicenseId->map(['GET'], '', \App\Controllers\SoftwareLicense::class . ':showItem');
        $softwarelicenseId->map(['POST'], '', \App\Controllers\SoftwareLicense::class . ':updateItem');
      });
    });
    $app->group($prefix . '/budgets', function (RouteCollectorProxy $budgets)
    {
      $budgets->map(['GET'], '', \App\Controllers\Budget::class . ':getAll');
      $budgets->map(['POST'], '', \App\Controllers\Budget::class . ':postItem');
      $budgets->group("/{id:[0-9]+}", function (RouteCollectorProxy $budgetId)
      {
        $budgetId->map(['GET'], '', \App\Controllers\Budget::class . ':showItem');
        $budgetId->map(['POST'], '', \App\Controllers\Budget::class . ':updateItem');
      });
    });
    $app->group($prefix . '/suppliers', function (RouteCollectorProxy $suppliers)
    {
      $suppliers->map(['GET'], '', \App\Controllers\Supplier::class . ':getAll');
      $suppliers->map(['POST'], '', \App\Controllers\Supplier::class . ':postItem');
      $suppliers->group("/{id:[0-9]+}", function (RouteCollectorProxy $supplierId)
      {
        $supplierId->map(['GET'], '', \App\Controllers\Supplier::class . ':showItem');
        $supplierId->map(['POST'], '', \App\Controllers\Supplier::class . ':updateItem');
      });
    });
    $app->group($prefix . '/contacts', function (RouteCollectorProxy $contacts)
    {
      $contacts->map(['GET'], '', \App\Controllers\Contact::class . ':getAll');
      $contacts->map(['POST'], '', \App\Controllers\Contact::class . ':postItem');
      $contacts->group("/{id:[0-9]+}", function (RouteCollectorProxy $contactId)
      {
        $contactId->map(['GET'], '', \App\Controllers\Contact::class . ':showItem');
        $contactId->map(['POST'], '', \App\Controllers\Contact::class . ':updateItem');
      });
    });
    $app->group($prefix . '/contracts', function (RouteCollectorProxy $contracts)
    {
      $contracts->map(['GET'], '', \App\Controllers\Contract::class . ':getAll');
      $contracts->map(['POST'], '', \App\Controllers\Contract::class . ':postItem');
      $contracts->group("/{id:[0-9]+}", function (RouteCollectorProxy $contractId)
      {
        $contractId->map(['GET'], '', \App\Controllers\Contract::class . ':showItem');
        $contractId->map(['POST'], '', \App\Controllers\Contract::class . ':updateItem');
      });
    });
    $app->group($prefix . '/documents', function (RouteCollectorProxy $documents)
    {
      $documents->map(['GET'], '', \App\Controllers\Document::class . ':getAll');
      $documents->map(['POST'], '', \App\Controllers\Document::class . ':postItem');
      $documents->group("/{id:[0-9]+}", function (RouteCollectorProxy $documentId)
      {
        $documentId->map(['GET'], '', \App\Controllers\Document::class . ':showItem');
        $documentId->map(['POST'], '', \App\Controllers\Document::class . ':updateItem');
      });
    });
    $app->group($prefix . '/lines', function (RouteCollectorProxy $lines)
    {
      $lines->map(['GET'], '', \App\Controllers\Line::class . ':getAll');
      $lines->map(['POST'], '', \App\Controllers\Line::class . ':postItem');
      $lines->group("/{id:[0-9]+}", function (RouteCollectorProxy $lineId)
      {
        $lineId->map(['GET'], '', \App\Controllers\Line::class . ':showItem');
        $lineId->map(['POST'], '', \App\Controllers\Line::class . ':updateItem');
      });
    });
    $app->group($prefix . '/certificates', function (RouteCollectorProxy $certificates)
    {
      $certificates->map(['GET'], '', \App\Controllers\Certificate::class . ':getAll');
      $certificates->map(['POST'], '', \App\Controllers\Certificate::class . ':postItem');
      $certificates->group("/{id:[0-9]+}", function (RouteCollectorProxy $certificateId)
      {
        $certificateId->map(['GET'], '', \App\Controllers\Certificate::class . ':showItem');
        $certificateId->map(['POST'], '', \App\Controllers\Certificate::class . ':updateItem');
      });
    });
    $app->group($prefix . '/datacenters', function (RouteCollectorProxy $datacenters)
    {
      $datacenters->map(['GET'], '', \App\Controllers\Datacenter::class . ':getAll');
      $datacenters->map(['POST'], '', \App\Controllers\Datacenter::class . ':postItem');
      $datacenters->group("/{id:[0-9]+}", function (RouteCollectorProxy $datacenterId)
      {
        $datacenterId->map(['GET'], '', \App\Controllers\Datacenter::class . ':showItem');
        $datacenterId->map(['POST'], '', \App\Controllers\Datacenter::class . ':updateItem');
      });
    });
    $app->group($prefix . '/clusters', function (RouteCollectorProxy $clusters)
    {
      $clusters->map(['GET'], '', \App\Controllers\Cluster::class . ':getAll');
      $clusters->map(['POST'], '', \App\Controllers\Cluster::class . ':postItem');
      $clusters->group("/{id:[0-9]+}", function (RouteCollectorProxy $clusterId)
      {
        $clusterId->map(['GET'], '', \App\Controllers\Cluster::class . ':showItem');
        $clusterId->map(['POST'], '', \App\Controllers\Cluster::class . ':updateItem');
      });
    });
    $app->group($prefix . '/domains', function (RouteCollectorProxy $domains)
    {
      $domains->map(['GET'], '', \App\Controllers\Domain::class . ':getAll');
      $domains->map(['POST'], '', \App\Controllers\Domain::class . ':postItem');
      $domains->group("/{id:[0-9]+}", function (RouteCollectorProxy $domainId)
      {
        $domainId->map(['GET'], '', \App\Controllers\Domain::class . ':showItem');
        $domainId->map(['POST'], '', \App\Controllers\Domain::class . ':updateItem');
      });
    });
    $app->group($prefix . '/appliances', function (RouteCollectorProxy $appliances)
    {
      $appliances->map(['GET'], '', \App\Controllers\Appliance::class . ':getAll');
      $appliances->map(['POST'], '', \App\Controllers\Appliance::class . ':postItem');
      $appliances->group("/{id:[0-9]+}", function (RouteCollectorProxy $applianceId)
      {
        $applianceId->map(['GET'], '', \App\Controllers\Appliance::class . ':showItem');
        $applianceId->map(['POST'], '', \App\Controllers\Appliance::class . ':updateItem');
      });
    });


    $app->group($prefix . '/projects', function (RouteCollectorProxy $projects)
    {
      $projects->map(['GET'], '', \App\Controllers\Project::class . ':getAll');
      $projects->map(['POST'], '', \App\Controllers\Project::class . ':postItem');
      $projects->group("/{id:[0-9]+}", function (RouteCollectorProxy $projectId)
      {
        $projectId->map(['GET'], '', \App\Controllers\Project::class . ':showItem');
        $projectId->map(['POST'], '', \App\Controllers\Project::class . ':updateItem');
      });
    });
    $app->group($prefix . '/reminders', function (RouteCollectorProxy $reminders)
    {
      $reminders->map(['GET'], '', \App\Controllers\Reminder::class . ':getAll');
      $reminders->map(['POST'], '', \App\Controllers\Reminder::class . ':postItem');
      $reminders->group("/{id:[0-9]+}", function (RouteCollectorProxy $reminderId)
      {
        $reminderId->map(['GET'], '', \App\Controllers\Reminder::class . ':showItem');
        $reminderId->map(['POST'], '', \App\Controllers\Reminder::class . ':updateItem');
      });
    });
    $app->group($prefix . '/rssfeeds', function (RouteCollectorProxy $rssfeeds)
    {
      $rssfeeds->map(['GET'], '', \App\Controllers\Rssfeed::class . ':getAll');
      $rssfeeds->map(['POST'], '', \App\Controllers\Rssfeed::class . ':postItem');
      $rssfeeds->group("/{id:[0-9]+}", function (RouteCollectorProxy $rssfeedId)
      {
        $rssfeedId->map(['GET'], '', \App\Controllers\Rssfeed::class . ':showItem');
        $rssfeedId->map(['POST'], '', \App\Controllers\Rssfeed::class . ':updateItem');
      });
    });
    $app->group($prefix . '/savedsearchs', function (RouteCollectorProxy $savedsearchs)
    {
      $savedsearchs->map(['GET'], '', \App\Controllers\SavedSearch::class . ':getAll');
      $savedsearchs->map(['POST'], '', \App\Controllers\SavedSearch::class . ':postItem');
      $savedsearchs->group("/{id:[0-9]+}", function (RouteCollectorProxy $savedsearchId)
      {
        $savedsearchId->map(['GET'], '', \App\Controllers\SavedSearch::class . ':showItem');
        $savedsearchId->map(['POST'], '', \App\Controllers\SavedSearch::class . ':updateItem');
      });
    });
    $app->group($prefix . '/news', function (RouteCollectorProxy $news)
    {
      $news->map(['GET'], '', \App\Controllers\News::class . ':getAll');
      $news->map(['POST'], '', \App\Controllers\News::class . ':postItem');
      $news->group("/{id:[0-9]+}", function (RouteCollectorProxy $newsId)
      {
        $newsId->map(['GET'], '', \App\Controllers\News::class . ':showItem');
        $newsId->map(['POST'], '', \App\Controllers\News::class . ':updateItem');
      });
    });


    $app->group($prefix . '/users', function (RouteCollectorProxy $users)
    {
      $users->map(['GET'], '', \App\Controllers\User::class . ':getAll');
      $users->map(['POST'], '', \App\Controllers\User::class . ':postItem');
      $users->group("/{id:[0-9]+}", function (RouteCollectorProxy $userId)
      {
        $userId->map(['GET'], '', \App\Controllers\User::class . ':showItem');
        $userId->map(['POST'], '', \App\Controllers\User::class . ':updateItem');
      });
    });
    $app->group($prefix . '/groups', function (RouteCollectorProxy $groups)
    {
      $groups->map(['GET'], '', \App\Controllers\Group::class . ':getAll');
      $groups->map(['POST'], '', \App\Controllers\Group::class . ':postItem');
      $groups->group("/{id:[0-9]+}", function (RouteCollectorProxy $groupId)
      {
        $groupId->map(['GET'], '', \App\Controllers\Group::class . ':showItem');
        $groupId->map(['POST'], '', \App\Controllers\Group::class . ':updateItem');
      });
    });
    $app->group($prefix . '/entities', function (RouteCollectorProxy $entities)
    {
      $entities->map(['GET'], '', \App\Controllers\Entity::class . ':getAll');
      $entities->map(['POST'], '', \App\Controllers\Entity::class . ':postItem');
      $entities->group("/{id:[0-9]+}", function (RouteCollectorProxy $entityId)
      {
        $entityId->map(['GET'], '', \App\Controllers\Entity::class . ':showItem');
        $entityId->map(['POST'], '', \App\Controllers\Entity::class . ':updateItem');
      });
    });
    $app->group($prefix . '/rules', function (RouteCollectorProxy $rules)
    {
      $rules->group("/tickets", function (RouteCollectorProxy $tickets)
      {
        $tickets->map(['GET'], '', \App\Controllers\Rules\Ticket::class . ':getAll');
      });
    });
    $app->group($prefix . '/profiles', function (RouteCollectorProxy $profiles)
    {
      $profiles->map(['GET'], '', \App\Controllers\Profile::class . ':getAll');
      $profiles->map(['POST'], '', \App\Controllers\Profile::class . ':postItem');
      $profiles->group("/{id:[0-9]+}", function (RouteCollectorProxy $profileId)
      {
        $profileId->map(['GET'], '', \App\Controllers\Profile::class . ':showItem');
        $profileId->map(['POST'], '', \App\Controllers\Profile::class . ':updateItem');
      });
    });
    $app->group($prefix . '/queuednotifications', function (RouteCollectorProxy $queuednotifications)
    {
      $queuednotifications->map(['GET'], '', \App\Controllers\QueuedNotification::class . ':getAll');
      $queuednotifications->map(['POST'], '', \App\Controllers\QueuedNotification::class . ':postItem');
      $queuednotifications->group("/{id:[0-9]+}", function (RouteCollectorProxy $queuednotificationId)
      {
        $queuednotificationId->map(['GET'], '', \App\Controllers\QueuedNotification::class . ':showItem');
        $queuednotificationId->map(['POST'], '', \App\Controllers\QueuedNotification::class . ':updateItem');
      });
    });
    $app->group($prefix . '/events', function (RouteCollectorProxy $events)
    {
      $events->map(['GET'], '', \App\Controllers\Event::class . ':getAll');
      $events->map(['POST'], '', \App\Controllers\Event::class . ':postItem');
      $events->group("/{id:[0-9]+}", function (RouteCollectorProxy $eventId)
      {
        $eventId->map(['GET'], '', \App\Controllers\Event::class . ':showItem');
        $eventId->map(['POST'], '', \App\Controllers\Event::class . ':updateItem');
      });
    });
    $app->group($prefix . '/forms', function (RouteCollectorProxy $forms)
    {
      $forms->map(['GET'], '', \App\Controllers\Form::class . ':getAll');
      $forms->map(['POST'], '', \App\Controllers\Form::class . ':postItem');
      $forms->group("/{id:[0-9]+}", function (RouteCollectorProxy $formId)
      {
        $formId->map(['GET'], '', \App\Controllers\Form::class . ':showItem');
        $formId->map(['POST'], '', \App\Controllers\Form::class . ':updateItem');
      });
    });
    $app->group($prefix . '/dropdowns', function (RouteCollectorProxy $dropdowns)
    {
      $dropdowns->group('/locations', function (RouteCollectorProxy $locations)
      {
        $locations->map(['GET'], '', \App\Controllers\Location::class . ':getAll');
        $locations->map(['POST'], '', \App\Controllers\Location::class . ':postItem');
        $locations->group("/{id:[0-9]+}", function (RouteCollectorProxy $locationId)
        {
          $locationId->map(['GET'], '', \App\Controllers\Location::class . ':showItem');
          $locationId->map(['POST'], '', \App\Controllers\Location::class . ':updateItem');
        });
      });
      $dropdowns->group('/states', function (RouteCollectorProxy $states)
      {
        $states->map(['GET'], '', \App\Controllers\State::class . ':getAll');
        $states->map(['POST'], '', \App\Controllers\State::class . ':postItem');
        $states->group("/{id:[0-9]+}", function (RouteCollectorProxy $stateId)
        {
          $stateId->map(['GET'], '', \App\Controllers\State::class . ':showItem');
          $stateId->map(['POST'], '', \App\Controllers\State::class . ':updateItem');
        });
      });
      $dropdowns->group('/manufacturers', function (RouteCollectorProxy $manufacturers)
      {
        $manufacturers->map(['GET'], '', \App\Controllers\Manufacturer::class . ':getAll');
        $manufacturers->map(['POST'], '', \App\Controllers\Manufacturer::class . ':postItem');
        $manufacturers->group("/{id:[0-9]+}", function (RouteCollectorProxy $manufacturerId)
        {
          $manufacturerId->map(['GET'], '', \App\Controllers\Manufacturer::class . ':showItem');
          $manufacturerId->map(['POST'], '', \App\Controllers\Manufacturer::class . ':updateItem');
        });
      });
      $dropdowns->group('/blacklists', function (RouteCollectorProxy $blacklists)
      {
        $blacklists->map(['GET'], '', \App\Controllers\Blacklist::class . ':getAll');
        $blacklists->map(['POST'], '', \App\Controllers\Blacklist::class . ':postItem');
        $blacklists->group("/{id:[0-9]+}", function (RouteCollectorProxy $blacklistId)
        {
          $blacklistId->map(['GET'], '', \App\Controllers\Blacklist::class . ':showItem');
          $blacklistId->map(['POST'], '', \App\Controllers\Blacklist::class . ':updateItem');
        });
      });
      $dropdowns->group('/blacklistedmailcontents', function (RouteCollectorProxy $blacklistedmailcontents)
      {
        $blacklistedmailcontents->map(['GET'], '', \App\Controllers\BlacklistedMailContent::class . ':getAll');
        $blacklistedmailcontents->map(['POST'], '', \App\Controllers\BlacklistedMailContent::class . ':postItem');
        $blacklistedmailcontents->group("/{id:[0-9]+}", function (RouteCollectorProxy $blacklistedmailcontentId)
        {
          $blacklistedmailcontentId->map(['GET'], '', \App\Controllers\BlacklistedMailContent::class . ':showItem');
          $blacklistedmailcontentId->map(['POST'], '', \App\Controllers\BlacklistedMailContent::class . ':updateItem');
        });
      });
      $dropdowns->group('/itilcategories', function (RouteCollectorProxy $itilcategories)
      {
        $itilcategories->map(['GET'], '', \App\Controllers\ITILCategory::class . ':getAll');
        $itilcategories->map(['POST'], '', \App\Controllers\ITILCategory::class . ':postItem');
        $itilcategories->group("/{id:[0-9]+}", function (RouteCollectorProxy $itilcategoryId)
        {
          $itilcategoryId->map(['GET'], '', \App\Controllers\ITILCategory::class . ':showItem');
          $itilcategoryId->map(['POST'], '', \App\Controllers\ITILCategory::class . ':updateItem');
        });
      });
      $dropdowns->group('/taskcategories', function (RouteCollectorProxy $taskcategories)
      {
        $taskcategories->map(['GET'], '', \App\Controllers\TaskCategory::class . ':getAll');
        $taskcategories->map(['POST'], '', \App\Controllers\TaskCategory::class . ':postItem');
        $taskcategories->group("/{id:[0-9]+}", function (RouteCollectorProxy $taskcategoryId)
        {
          $taskcategoryId->map(['GET'], '', \App\Controllers\TaskCategory::class . ':showItem');
          $taskcategoryId->map(['POST'], '', \App\Controllers\TaskCategory::class . ':updateItem');
        });
      });
      $dropdowns->group('/tasktemplates', function (RouteCollectorProxy $tasktemplates)
      {
        $tasktemplates->map(['GET'], '', \App\Controllers\TaskTemplate::class . ':getAll');
        $tasktemplates->map(['POST'], '', \App\Controllers\TaskTemplate::class . ':postItem');
        $tasktemplates->group("/{id:[0-9]+}", function (RouteCollectorProxy $tasktemplateId)
        {
          $tasktemplateId->map(['GET'], '', \App\Controllers\TaskTemplate::class . ':showItem');
          $tasktemplateId->map(['POST'], '', \App\Controllers\TaskTemplate::class . ':updateItem');
        });
      });
      $dropdowns->group('/solutiontypes', function (RouteCollectorProxy $solutiontypes)
      {
        $solutiontypes->map(['GET'], '', \App\Controllers\SolutionType::class . ':getAll');
        $solutiontypes->map(['POST'], '', \App\Controllers\SolutionType::class . ':postItem');
        $solutiontypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $solutiontypeId)
        {
          $solutiontypeId->map(['GET'], '', \App\Controllers\SolutionType::class . ':showItem');
          $solutiontypeId->map(['POST'], '', \App\Controllers\SolutionType::class . ':updateItem');
        });
      });
      $dropdowns->group('/solutiontemplates', function (RouteCollectorProxy $solutiontemplates)
      {
        $solutiontemplates->map(['GET'], '', \App\Controllers\SolutionTemplate::class . ':getAll');
        $solutiontemplates->map(['POST'], '', \App\Controllers\SolutionTemplate::class . ':postItem');
        $solutiontemplates->group("/{id:[0-9]+}", function (RouteCollectorProxy $solutiontemplateId)
        {
          $solutiontemplateId->map(['GET'], '', \App\Controllers\SolutionTemplate::class . ':showItem');
          $solutiontemplateId->map(['POST'], '', \App\Controllers\SolutionTemplate::class . ':updateItem');
        });
      });
      $dropdowns->group('/requesttypes', function (RouteCollectorProxy $requesttypes)
      {
        $requesttypes->map(['GET'], '', \App\Controllers\RequestType::class . ':getAll');
        $requesttypes->map(['POST'], '', \App\Controllers\RequestType::class . ':postItem');
        $requesttypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $requesttypeId)
        {
          $requesttypeId->map(['GET'], '', \App\Controllers\RequestType::class . ':showItem');
          $requesttypeId->map(['POST'], '', \App\Controllers\RequestType::class . ':updateItem');
        });
      });
      $dropdowns->group('/itilfollowuptemplates', function (RouteCollectorProxy $itilfollowuptemplates)
      {
        $itilfollowuptemplates->map(['GET'], '', \App\Controllers\ITILFollowupTemplate::class . ':getAll');
        $itilfollowuptemplates->map(['POST'], '', \App\Controllers\ITILFollowupTemplate::class . ':postItem');
        $itilfollowuptemplates->group("/{id:[0-9]+}", function (RouteCollectorProxy $itilfollowuptemplateId)
        {
          $itilfollowuptemplateId->map(['GET'], '', \App\Controllers\ITILFollowupTemplate::class . ':showItem');
          $itilfollowuptemplateId->map(['POST'], '', \App\Controllers\ITILFollowupTemplate::class . ':updateItem');
        });
      });
      $dropdowns->group('/projectstates', function (RouteCollectorProxy $projectstates)
      {
        $projectstates->map(['GET'], '', \App\Controllers\ProjectState::class . ':getAll');
        $projectstates->map(['POST'], '', \App\Controllers\ProjectState::class . ':postItem');
        $projectstates->group("/{id:[0-9]+}", function (RouteCollectorProxy $projectstateId)
        {
          $projectstateId->map(['GET'], '', \App\Controllers\ProjectState::class . ':showItem');
          $projectstateId->map(['POST'], '', \App\Controllers\ProjectState::class . ':updateItem');
        });
      });
      $dropdowns->group('/projecttypes', function (RouteCollectorProxy $projecttypes)
      {
        $projecttypes->map(['GET'], '', \App\Controllers\ProjectType::class . ':getAll');
        $projecttypes->map(['POST'], '', \App\Controllers\ProjectType::class . ':postItem');
        $projecttypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $projecttypeId)
        {
          $projecttypeId->map(['GET'], '', \App\Controllers\ProjectType::class . ':showItem');
          $projecttypeId->map(['POST'], '', \App\Controllers\ProjectType::class . ':updateItem');
        });
      });
      $dropdowns->group('/projecttasktypes', function (RouteCollectorProxy $projecttasktypes)
      {
        $projecttasktypes->map(['GET'], '', \App\Controllers\ProjectTaskType::class . ':getAll');
        $projecttasktypes->map(['POST'], '', \App\Controllers\ProjectTaskType::class . ':postItem');
        $projecttasktypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $projecttasktypeId)
        {
          $projecttasktypeId->map(['GET'], '', \App\Controllers\ProjectTaskType::class . ':showItem');
          $projecttasktypeId->map(['POST'], '', \App\Controllers\ProjectTaskType::class . ':updateItem');
        });
      });
      $dropdowns->group('/projecttasktemplates', function (RouteCollectorProxy $projecttasktemplates)
      {
        $projecttasktemplates->map(['GET'], '', \App\Controllers\ProjectTaskTemplate::class . ':getAll');
        $projecttasktemplates->map(['POST'], '', \App\Controllers\ProjectTaskTemplate::class . ':postItem');
        $projecttasktemplates->group("/{id:[0-9]+}", function (RouteCollectorProxy $projecttasktemplateId)
        {
          $projecttasktemplateId->map(['GET'], '', \App\Controllers\ProjectTaskTemplate::class . ':showItem');
          $projecttasktemplateId->map(['POST'], '', \App\Controllers\ProjectTaskTemplate::class . ':updateItem');
        });
      });
      $dropdowns->group('/planningeventcategories', function (RouteCollectorProxy $planningeventcategories)
      {
        $planningeventcategories->map(['GET'], '', \App\Controllers\PlanningEventCategory::class . ':getAll');
        $planningeventcategories->map(['POST'], '', \App\Controllers\PlanningEventCategory::class . ':postItem');
        $planningeventcategories->group("/{id:[0-9]+}", function (RouteCollectorProxy $planningeventcategoryId)
        {
          $planningeventcategoryId->map(['GET'], '', \App\Controllers\PlanningEventCategory::class . ':showItem');
          $planningeventcategoryId->map(['POST'], '', \App\Controllers\PlanningEventCategory::class . ':updateItem');
        });
      });
      $dropdowns->group('/planningexternaleventtemplates', function (RouteCollectorProxy $planningexternaleventtemplates)
      {
        $planningexternaleventtemplates->map(['GET'], '', \App\Controllers\PlanningExternalEventTemplate::class . ':getAll');
        $planningexternaleventtemplates->map(['POST'], '', \App\Controllers\PlanningExternalEventTemplate::class . ':postItem');
        $planningexternaleventtemplates->group("/{id:[0-9]+}", function (RouteCollectorProxy $planningexternaleventtemplateId)
        {
          $planningexternaleventtemplateId->map(['GET'], '', \App\Controllers\PlanningExternalEventTemplate::class . ':showItem');
          $planningexternaleventtemplateId->map(['POST'], '', \App\Controllers\PlanningExternalEventTemplate::class . ':updateItem');
        });
      });
      $dropdowns->group('/computertypes', function (RouteCollectorProxy $computertypes)
      {
        $computertypes->map(['GET'], '', \App\Controllers\ComputerType::class . ':getAll');
        $computertypes->map(['POST'], '', \App\Controllers\ComputerType::class . ':postItem');
        $computertypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $computertypeId)
        {
          $computertypeId->map(['GET'], '', \App\Controllers\ComputerType::class . ':showItem');
          $computertypeId->map(['POST'], '', \App\Controllers\ComputerType::class . ':updateItem');
        });
      });
      $dropdowns->group('/networkequipmenttypes', function (RouteCollectorProxy $networkequipmenttypes)
      {
        $networkequipmenttypes->map(['GET'], '', \App\Controllers\NetworkEquipmentType::class . ':getAll');
        $networkequipmenttypes->map(['POST'], '', \App\Controllers\NetworkEquipmentType::class . ':postItem');
        $networkequipmenttypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $networkequipmenttypeId)
        {
          $networkequipmenttypeId->map(['GET'], '', \App\Controllers\NetworkEquipmentType::class . ':showItem');
          $networkequipmenttypeId->map(['POST'], '', \App\Controllers\NetworkEquipmentType::class . ':updateItem');
        });
      });
      $dropdowns->group('/printertypes', function (RouteCollectorProxy $printertypes)
      {
        $printertypes->map(['GET'], '', \App\Controllers\PrinterType::class . ':getAll');
        $printertypes->map(['POST'], '', \App\Controllers\PrinterType::class . ':postItem');
        $printertypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $printertypeId)
        {
          $printertypeId->map(['GET'], '', \App\Controllers\PrinterType::class . ':showItem');
          $printertypeId->map(['POST'], '', \App\Controllers\PrinterType::class . ':updateItem');
        });
      });
      $dropdowns->group('/monitortypes', function (RouteCollectorProxy $monitortypes)
      {
        $monitortypes->map(['GET'], '', \App\Controllers\MonitorType::class . ':getAll');
        $monitortypes->map(['POST'], '', \App\Controllers\MonitorType::class . ':postItem');
        $monitortypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $monitortypeId)
        {
          $monitortypeId->map(['GET'], '', \App\Controllers\MonitorType::class . ':showItem');
          $monitortypeId->map(['POST'], '', \App\Controllers\MonitorType::class . ':updateItem');
        });
      });
      $dropdowns->group('/peripheraltypes', function (RouteCollectorProxy $peripheraltypes)
      {
        $peripheraltypes->map(['GET'], '', \App\Controllers\PeripheralType::class . ':getAll');
        $peripheraltypes->map(['POST'], '', \App\Controllers\PeripheralType::class . ':postItem');
        $peripheraltypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $peripheraltypeId)
        {
          $peripheraltypeId->map(['GET'], '', \App\Controllers\PeripheralType::class . ':showItem');
          $peripheraltypeId->map(['POST'], '', \App\Controllers\PeripheralType::class . ':updateItem');
        });
      });
      $dropdowns->group('/phonetypes', function (RouteCollectorProxy $phonetypes)
      {
        $phonetypes->map(['GET'], '', \App\Controllers\PhoneType::class . ':getAll');
        $phonetypes->map(['POST'], '', \App\Controllers\PhoneType::class . ':postItem');
        $phonetypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $phonetypeId)
        {
          $phonetypeId->map(['GET'], '', \App\Controllers\PhoneType::class . ':showItem');
          $phonetypeId->map(['POST'], '', \App\Controllers\PhoneType::class . ':updateItem');
        });
      });
      $dropdowns->group('/softwarelicensetypes', function (RouteCollectorProxy $softwarelicensetypes)
      {
        $softwarelicensetypes->map(['GET'], '', \App\Controllers\SoftwareLicenseType::class . ':getAll');
        $softwarelicensetypes->map(['POST'], '', \App\Controllers\SoftwareLicenseType::class . ':postItem');
        $softwarelicensetypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $softwarelicensetypeId)
        {
          $softwarelicensetypeId->map(['GET'], '', \App\Controllers\SoftwareLicenseType::class . ':showItem');
          $softwarelicensetypeId->map(['POST'], '', \App\Controllers\SoftwareLicenseType::class . ':updateItem');
        });
      });
      $dropdowns->group('/cartridgeitemtypes', function (RouteCollectorProxy $cartridgeitemtypes)
      {
        $cartridgeitemtypes->map(['GET'], '', \App\Controllers\CartridgeItemType::class . ':getAll');
        $cartridgeitemtypes->map(['POST'], '', \App\Controllers\CartridgeItemType::class . ':postItem');
        $cartridgeitemtypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $cartridgeitemtypeId)
        {
          $cartridgeitemtypeId->map(['GET'], '', \App\Controllers\CartridgeItemType::class . ':showItem');
          $cartridgeitemtypeId->map(['POST'], '', \App\Controllers\CartridgeItemType::class . ':updateItem');
        });
      });
      $dropdowns->group('/consumableitemtypes', function (RouteCollectorProxy $consumableitemtypes)
      {
        $consumableitemtypes->map(['GET'], '', \App\Controllers\ConsumableItemType::class . ':getAll');
        $consumableitemtypes->map(['POST'], '', \App\Controllers\ConsumableItemType::class . ':postItem');
        $consumableitemtypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $consumableitemtypeId)
        {
          $consumableitemtypeId->map(['GET'], '', \App\Controllers\ConsumableItemType::class . ':showItem');
          $consumableitemtypeId->map(['POST'], '', \App\Controllers\ConsumableItemType::class . ':updateItem');
        });
      });
      $dropdowns->group('/contracttypes', function (RouteCollectorProxy $contracttypes)
      {
        $contracttypes->map(['GET'], '', \App\Controllers\ContractType::class . ':getAll');
        $contracttypes->map(['POST'], '', \App\Controllers\ContractType::class . ':postItem');
        $contracttypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $contracttypeId)
        {
          $contracttypeId->map(['GET'], '', \App\Controllers\ContractType::class . ':showItem');
          $contracttypeId->map(['POST'], '', \App\Controllers\ContractType::class . ':updateItem');
        });
      });
      $dropdowns->group('/contacttypes', function (RouteCollectorProxy $contacttypes)
      {
        $contacttypes->map(['GET'], '', \App\Controllers\ContactType::class . ':getAll');
        $contacttypes->map(['POST'], '', \App\Controllers\ContactType::class . ':postItem');
        $contacttypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $contacttypeId)
        {
          $contacttypeId->map(['GET'], '', \App\Controllers\ContactType::class . ':showItem');
          $contacttypeId->map(['POST'], '', \App\Controllers\ContactType::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicegenerictype', function (RouteCollectorProxy $itemdevicegenerictype)
      {
        $itemdevicegenerictype->map(['GET'], '', \App\Controllers\ItemDeviceGenericType::class . ':getAll');
        $itemdevicegenerictype->map(['POST'], '', \App\Controllers\ItemDeviceGenericType::class . ':postItem');
        $itemdevicegenerictype->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicegenerictypeId)
        {
          $itemdevicegenerictypeId->map(['GET'], '', \App\Controllers\ItemDeviceGenericType::class . ':showItem');
          $itemdevicegenerictypeId->map(['POST'], '', \App\Controllers\ItemDeviceGenericType::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicesensortype', function (RouteCollectorProxy $itemdevicesensortype)
      {
        $itemdevicesensortype->map(['GET'], '', \App\Controllers\ItemDeviceSensorType::class . ':getAll');
        $itemdevicesensortype->map(['POST'], '', \App\Controllers\ItemDeviceSensorType::class . ':postItem');
        $itemdevicesensortype->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicesensortypeId)
        {
          $itemdevicesensortypeId->map(['GET'], '', \App\Controllers\ItemDeviceSensorType::class . ':showItem');
          $itemdevicesensortypeId->map(['POST'], '', \App\Controllers\ItemDeviceSensorType::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicememorytype', function (RouteCollectorProxy $itemdevicememorytype)
      {
        $itemdevicememorytype->map(['GET'], '', \App\Controllers\ItemDeviceMemoryType::class . ':getAll');
        $itemdevicememorytype->map(['POST'], '', \App\Controllers\ItemDeviceMemoryType::class . ':postItem');
        $itemdevicememorytype->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicememorytypeId)
        {
          $itemdevicememorytypeId->map(['GET'], '', \App\Controllers\ItemDeviceMemoryType::class . ':showItem');
          $itemdevicememorytypeId->map(['POST'], '', \App\Controllers\ItemDeviceMemoryType::class . ':updateItem');
        });
      });
      $dropdowns->group('/suppliertypes', function (RouteCollectorProxy $suppliertypes)
      {
        $suppliertypes->map(['GET'], '', \App\Controllers\SupplierType::class . ':getAll');
        $suppliertypes->map(['POST'], '', \App\Controllers\SupplierType::class . ':postItem');
        $suppliertypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $suppliertypeId)
        {
          $suppliertypeId->map(['GET'], '', \App\Controllers\SupplierType::class . ':showItem');
          $suppliertypeId->map(['POST'], '', \App\Controllers\SupplierType::class . ':updateItem');
        });
      });
      $dropdowns->group('/interfacetypes', function (RouteCollectorProxy $interfacetypes)
      {
        $interfacetypes->map(['GET'], '', \App\Controllers\InterfaceType::class . ':getAll');
        $interfacetypes->map(['POST'], '', \App\Controllers\InterfaceType::class . ':postItem');
        $interfacetypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $interfacetypeId)
        {
          $interfacetypeId->map(['GET'], '', \App\Controllers\InterfaceType::class . ':showItem');
          $interfacetypeId->map(['POST'], '', \App\Controllers\InterfaceType::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicecasetype', function (RouteCollectorProxy $itemdevicecasetype)
      {
        $itemdevicecasetype->map(['GET'], '', \App\Controllers\ItemDeviceCaseType::class . ':getAll');
        $itemdevicecasetype->map(['POST'], '', \App\Controllers\ItemDeviceCaseType::class . ':postItem');
        $itemdevicecasetype->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicecasetypeId)
        {
          $itemdevicecasetypeId->map(['GET'], '', \App\Controllers\ItemDeviceCaseType::class . ':showItem');
          $itemdevicecasetypeId->map(['POST'], '', \App\Controllers\ItemDeviceCaseType::class . ':updateItem');
        });
      });
      $dropdowns->group('/phonepowersupplies', function (RouteCollectorProxy $phonepowersupplies)
      {
        $phonepowersupplies->map(['GET'], '', \App\Controllers\PhonePowerSupply::class . ':getAll');
        $phonepowersupplies->map(['POST'], '', \App\Controllers\PhonePowerSupply::class . ':postItem');
        $phonepowersupplies->group("/{id:[0-9]+}", function (RouteCollectorProxy $phonepowersupplyId)
        {
          $phonepowersupplyId->map(['GET'], '', \App\Controllers\PhonePowerSupply::class . ':showItem');
          $phonepowersupplyId->map(['POST'], '', \App\Controllers\PhonePowerSupply::class . ':updateItem');
        });
      });
      $dropdowns->group('/filesystems', function (RouteCollectorProxy $filesystems)
      {
        $filesystems->map(['GET'], '', \App\Controllers\FileSystem::class . ':getAll');
        $filesystems->map(['POST'], '', \App\Controllers\FileSystem::class . ':postItem');
        $filesystems->group("/{id:[0-9]+}", function (RouteCollectorProxy $filesystemId)
        {
          $filesystemId->map(['GET'], '', \App\Controllers\FileSystem::class . ':showItem');
          $filesystemId->map(['POST'], '', \App\Controllers\FileSystem::class . ':updateItem');
        });
      });
      $dropdowns->group('/certificatetypes', function (RouteCollectorProxy $certificatetypes)
      {
        $certificatetypes->map(['GET'], '', \App\Controllers\CertificateType::class . ':getAll');
        $certificatetypes->map(['POST'], '', \App\Controllers\CertificateType::class . ':postItem');
        $certificatetypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $certificatetypeId)
        {
          $certificatetypeId->map(['GET'], '', \App\Controllers\CertificateType::class . ':showItem');
          $certificatetypeId->map(['POST'], '', \App\Controllers\CertificateType::class . ':updateItem');
        });
      });
      $dropdowns->group('/budgettypes', function (RouteCollectorProxy $budgettypes)
      {
        $budgettypes->map(['GET'], '', \App\Controllers\BudgetType::class . ':getAll');
        $budgettypes->map(['POST'], '', \App\Controllers\BudgetType::class . ':postItem');
        $budgettypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $budgettypeId)
        {
          $budgettypeId->map(['GET'], '', \App\Controllers\BudgetType::class . ':showItem');
          $budgettypeId->map(['POST'], '', \App\Controllers\BudgetType::class . ':updateItem');
        });
      });
      $dropdowns->group('/devicesimcardtypes', function (RouteCollectorProxy $devicesimcardtypes)
      {
        $devicesimcardtypes->map(['GET'], '', \App\Controllers\ItemDeviceSimcardType::class . ':getAll');
        $devicesimcardtypes->map(['POST'], '', \App\Controllers\ItemDeviceSimcardType::class . ':postItem');
        $devicesimcardtypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $devicesimcardtypeId)
        {
          $devicesimcardtypeId->map(['GET'], '', \App\Controllers\ItemDeviceSimcardType::class . ':showItem');
          $devicesimcardtypeId->map(['POST'], '', \App\Controllers\ItemDeviceSimcardType::class . ':updateItem');
        });
      });
      $dropdowns->group('/linetypes', function (RouteCollectorProxy $linetypes)
      {
        $linetypes->map(['GET'], '', \App\Controllers\LineType::class . ':getAll');
        $linetypes->map(['POST'], '', \App\Controllers\LineType::class . ':postItem');
        $linetypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $linetypeId)
        {
          $linetypeId->map(['GET'], '', \App\Controllers\LineType::class . ':showItem');
          $linetypeId->map(['POST'], '', \App\Controllers\LineType::class . ':updateItem');
        });
      });
      $dropdowns->group('/racktypes', function (RouteCollectorProxy $racktypes)
      {
        $racktypes->map(['GET'], '', \App\Controllers\RackType::class . ':getAll');
        $racktypes->map(['POST'], '', \App\Controllers\RackType::class . ':postItem');
        $racktypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $racktypeId)
        {
          $racktypeId->map(['GET'], '', \App\Controllers\RackType::class . ':showItem');
          $racktypeId->map(['POST'], '', \App\Controllers\RackType::class . ':updateItem');
        });
      });
      $dropdowns->group('/pdutypes', function (RouteCollectorProxy $pdutypes)
      {
        $pdutypes->map(['GET'], '', \App\Controllers\PDUType::class . ':getAll');
        $pdutypes->map(['POST'], '', \App\Controllers\PDUType::class . ':postItem');
        $pdutypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $pdutypeId)
        {
          $pdutypeId->map(['GET'], '', \App\Controllers\PDUType::class . ':showItem');
          $pdutypeId->map(['POST'], '', \App\Controllers\PDUType::class . ':updateItem');
        });
      });
      $dropdowns->group('/passivedcequipmenttypes', function (RouteCollectorProxy $passivedcequipmenttypes)
      {
        $passivedcequipmenttypes->map(['GET'], '', \App\Controllers\PassivedcEquipmentType::class . ':getAll');
        $passivedcequipmenttypes->map(['POST'], '', \App\Controllers\PassivedcEquipmentType::class . ':postItem');
        $passivedcequipmenttypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $passivedcequipmenttypeId)
        {
          $passivedcequipmenttypeId->map(['GET'], '', \App\Controllers\PassivedcEquipmentType::class . ':showItem');
          $passivedcequipmenttypeId->map(['POST'], '', \App\Controllers\PassivedcEquipmentType::class . ':updateItem');
        });
      });
      $dropdowns->group('/clustertypes', function (RouteCollectorProxy $clustertypes)
      {
        $clustertypes->map(['GET'], '', \App\Controllers\ClusterType::class . ':getAll');
        $clustertypes->map(['POST'], '', \App\Controllers\ClusterType::class . ':postItem');
        $clustertypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $clustertypeId)
        {
          $clustertypeId->map(['GET'], '', \App\Controllers\ClusterType::class . ':showItem');
          $clustertypeId->map(['POST'], '', \App\Controllers\ClusterType::class . ':updateItem');
        });
      });
      $dropdowns->group('/computermodels', function (RouteCollectorProxy $computermodels)
      {
        $computermodels->map(['GET'], '', \App\Controllers\ComputerModel::class . ':getAll');
        $computermodels->map(['POST'], '', \App\Controllers\ComputerModel::class . ':postItem');
        $computermodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $computermodelId)
        {
          $computermodelId->map(['GET'], '', \App\Controllers\ComputerModel::class . ':showItem');
          $computermodelId->map(['POST'], '', \App\Controllers\ComputerModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/networkequipmentmodels', function (RouteCollectorProxy $networkequipmentmodels)
      {
        $networkequipmentmodels->map(['GET'], '', \App\Controllers\NetworkEquipmentModel::class . ':getAll');
        $networkequipmentmodels->map(['POST'], '', \App\Controllers\NetworkEquipmentModel::class . ':postItem');
        $networkequipmentmodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $networkequipmentmodelId)
        {
          $networkequipmentmodelId->map(['GET'], '', \App\Controllers\NetworkEquipmentModel::class . ':showItem');
          $networkequipmentmodelId->map(['POST'], '', \App\Controllers\NetworkEquipmentModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/printermodels', function (RouteCollectorProxy $printermodels)
      {
        $printermodels->map(['GET'], '', \App\Controllers\PrinterModel::class . ':getAll');
        $printermodels->map(['POST'], '', \App\Controllers\PrinterModel::class . ':postItem');
        $printermodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $printermodelId)
        {
          $printermodelId->map(['GET'], '', \App\Controllers\PrinterModel::class . ':showItem');
          $printermodelId->map(['POST'], '', \App\Controllers\PrinterModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/monitormodels', function (RouteCollectorProxy $monitormodels)
      {
        $monitormodels->map(['GET'], '', \App\Controllers\MonitorModel::class . ':getAll');
        $monitormodels->map(['POST'], '', \App\Controllers\MonitorModel::class . ':postItem');
        $monitormodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $monitormodelId)
        {
          $monitormodelId->map(['GET'], '', \App\Controllers\MonitorModel::class . ':showItem');
          $monitormodelId->map(['POST'], '', \App\Controllers\MonitorModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/peripheralmodels', function (RouteCollectorProxy $peripheralmodels)
      {
        $peripheralmodels->map(['GET'], '', \App\Controllers\PeripheralModel::class . ':getAll');
        $peripheralmodels->map(['POST'], '', \App\Controllers\PeripheralModel::class . ':postItem');
        $peripheralmodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $peripheralmodelId)
        {
          $peripheralmodelId->map(['GET'], '', \App\Controllers\PeripheralModel::class . ':showItem');
          $peripheralmodelId->map(['POST'], '', \App\Controllers\PeripheralModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/phonemodels', function (RouteCollectorProxy $phonemodels)
      {
        $phonemodels->map(['GET'], '', \App\Controllers\PhoneModel::class . ':getAll');
        $phonemodels->map(['POST'], '', \App\Controllers\PhoneModel::class . ':postItem');
        $phonemodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $phonemodelId)
        {
          $phonemodelId->map(['GET'], '', \App\Controllers\PhoneModel::class . ':showItem');
          $phonemodelId->map(['POST'], '', \App\Controllers\PhoneModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicecasemodels', function (RouteCollectorProxy $itemdevicecasemodels)
      {
        $itemdevicecasemodels->map(['GET'], '', \App\Controllers\ItemDeviceCaseModel::class . ':getAll');
        $itemdevicecasemodels->map(['POST'], '', \App\Controllers\ItemDeviceCaseModel::class . ':postItem');
        $itemdevicecasemodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicecasemodelId)
        {
          $itemdevicecasemodelId->map(['GET'], '', \App\Controllers\ItemDeviceCaseModel::class . ':showItem');
          $itemdevicecasemodelId->map(['POST'], '', \App\Controllers\ItemDeviceCaseModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicecontrolmodels', function (RouteCollectorProxy $itemdevicecontrolmodels)
      {
        $itemdevicecontrolmodels->map(['GET'], '', \App\Controllers\ItemDeviceControlModel::class . ':getAll');
        $itemdevicecontrolmodels->map(['POST'], '', \App\Controllers\ItemDeviceControlModel::class . ':postItem');
        $itemdevicecontrolmodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicecontrolmodelId)
        {
          $itemdevicecontrolmodelId->map(['GET'], '', \App\Controllers\ItemDeviceControlModel::class . ':showItem');
          $itemdevicecontrolmodelId->map(['POST'], '', \App\Controllers\ItemDeviceControlModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicedrivemodels', function (RouteCollectorProxy $itemdevicedrivemodels)
      {
        $itemdevicedrivemodels->map(['GET'], '', \App\Controllers\ItemDeviceDriveModel::class . ':getAll');
        $itemdevicedrivemodels->map(['POST'], '', \App\Controllers\ItemDeviceDriveModel::class . ':postItem');
        $itemdevicedrivemodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicedrivemodelId)
        {
          $itemdevicedrivemodelId->map(['GET'], '', \App\Controllers\ItemDeviceDriveModel::class . ':showItem');
          $itemdevicedrivemodelId->map(['POST'], '', \App\Controllers\ItemDeviceDriveModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicegenericmodels', function (RouteCollectorProxy $itemdevicegenericmodels)
      {
        $itemdevicegenericmodels->map(['GET'], '', \App\Controllers\ItemDeviceGenericModel::class . ':getAll');
        $itemdevicegenericmodels->map(['POST'], '', \App\Controllers\ItemDeviceGenericModel::class . ':postItem');
        $itemdevicegenericmodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicegenericmodelId)
        {
          $itemdevicegenericmodelId->map(['GET'], '', \App\Controllers\ItemDeviceGenericModel::class . ':showItem');
          $itemdevicegenericmodelId->map(['POST'], '', \App\Controllers\ItemDeviceGenericModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicegraphiccardmodels', function (RouteCollectorProxy $itemdevicegraphiccardmodels)
      {
        $itemdevicegraphiccardmodels->map(['GET'], '', \App\Controllers\ItemDeviceGraphicCardModel::class . ':getAll');
        $itemdevicegraphiccardmodels->map(['POST'], '', \App\Controllers\ItemDeviceGraphicCardModel::class . ':postItem');
        $itemdevicegraphiccardmodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicegraphiccardmodelId)
        {
          $itemdevicegraphiccardmodelId->map(['GET'], '', \App\Controllers\ItemDeviceGraphicCardModel::class . ':showItem');
          $itemdevicegraphiccardmodelId->map(['POST'], '', \App\Controllers\ItemDeviceGraphicCardModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdeviceharddrivemodels', function (RouteCollectorProxy $itemdeviceharddrivemodels)
      {
        $itemdeviceharddrivemodels->map(['GET'], '', \App\Controllers\ItemDeviceHardDriveModel::class . ':getAll');
        $itemdeviceharddrivemodels->map(['POST'], '', \App\Controllers\ItemDeviceHardDriveModel::class . ':postItem');
        $itemdeviceharddrivemodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdeviceharddrivemodelId)
        {
          $itemdeviceharddrivemodelId->map(['GET'], '', \App\Controllers\ItemDeviceHardDriveModel::class . ':showItem');
          $itemdeviceharddrivemodelId->map(['POST'], '', \App\Controllers\ItemDeviceHardDriveModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicememorymodels', function (RouteCollectorProxy $itemdevicememorymodels)
      {
        $itemdevicememorymodels->map(['GET'], '', \App\Controllers\ItemDeviceMemoryModel::class . ':getAll');
        $itemdevicememorymodels->map(['POST'], '', \App\Controllers\ItemDeviceMemoryModel::class . ':postItem');
        $itemdevicememorymodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicememorymodelId)
        {
          $itemdevicememorymodelId->map(['GET'], '', \App\Controllers\ItemDeviceMemoryModel::class . ':showItem');
          $itemdevicememorymodelId->map(['POST'], '', \App\Controllers\ItemDeviceMemoryModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicemotherboardmodels', function (RouteCollectorProxy $itemdevicemotherboardmodels)
      {
        $itemdevicemotherboardmodels->map(['GET'], '', \App\Controllers\ItemDeviceMotherBoardModel::class . ':getAll');
        $itemdevicemotherboardmodels->map(['POST'], '', \App\Controllers\ItemDeviceMotherBoardModel::class . ':postItem');
        $itemdevicemotherboardmodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicemotherboardmodelId)
        {
          $itemdevicemotherboardmodelId->map(['GET'], '', \App\Controllers\ItemDeviceMotherBoardModel::class . ':showItem');
          $itemdevicemotherboardmodelId->map(['POST'], '', \App\Controllers\ItemDeviceMotherBoardModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicenetworkcardmodels', function (RouteCollectorProxy $itemdevicenetworkcardmodels)
      {
        $itemdevicenetworkcardmodels->map(['GET'], '', \App\Controllers\ItemDeviceNetworkCardModel::class . ':getAll');
        $itemdevicenetworkcardmodels->map(['POST'], '', \App\Controllers\ItemDeviceNetworkCardModel::class . ':postItem');
        $itemdevicenetworkcardmodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicenetworkcardmodelId)
        {
          $itemdevicenetworkcardmodelId->map(['GET'], '', \App\Controllers\ItemDeviceNetworkCardModel::class . ':showItem');
          $itemdevicenetworkcardmodelId->map(['POST'], '', \App\Controllers\ItemDeviceNetworkCardModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicepcimodels', function (RouteCollectorProxy $itemdevicepcimodels)
      {
        $itemdevicepcimodels->map(['GET'], '', \App\Controllers\ItemDevicePciModel::class . ':getAll');
        $itemdevicepcimodels->map(['POST'], '', \App\Controllers\ItemDevicePciModel::class . ':postItem');
        $itemdevicepcimodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicepcimodelId)
        {
          $itemdevicepcimodelId->map(['GET'], '', \App\Controllers\ItemDevicePciModel::class . ':showItem');
          $itemdevicepcimodelId->map(['POST'], '', \App\Controllers\ItemDevicePciModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicepowersupplymodels', function (RouteCollectorProxy $itemdevicepowersupplymodels)
      {
        $itemdevicepowersupplymodels->map(['GET'], '', \App\Controllers\ItemDevicePowerSupplyModel::class . ':getAll');
        $itemdevicepowersupplymodels->map(['POST'], '', \App\Controllers\ItemDevicePowerSupplyModel::class . ':postItem');
        $itemdevicepowersupplymodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicepowersupplymodelId)
        {
          $itemdevicepowersupplymodelId->map(['GET'], '', \App\Controllers\ItemDevicePowerSupplyModel::class . ':showItem');
          $itemdevicepowersupplymodelId->map(['POST'], '', \App\Controllers\ItemDevicePowerSupplyModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdeviceprocessormodels', function (RouteCollectorProxy $itemdeviceprocessormodels)
      {
        $itemdeviceprocessormodels->map(['GET'], '', \App\Controllers\ItemDeviceProcessorModel::class . ':getAll');
        $itemdeviceprocessormodels->map(['POST'], '', \App\Controllers\ItemDeviceProcessorModel::class . ':postItem');
        $itemdeviceprocessormodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdeviceprocessormodelId)
        {
          $itemdeviceprocessormodelId->map(['GET'], '', \App\Controllers\ItemDeviceProcessorModel::class . ':showItem');
          $itemdeviceprocessormodelId->map(['POST'], '', \App\Controllers\ItemDeviceProcessorModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicesoundcardmodels', function (RouteCollectorProxy $itemdevicesoundcardmodels)
      {
        $itemdevicesoundcardmodels->map(['GET'], '', \App\Controllers\ItemDeviceSoundCardModel::class . ':getAll');
        $itemdevicesoundcardmodels->map(['POST'], '', \App\Controllers\ItemDeviceSoundCardModel::class . ':postItem');
        $itemdevicesoundcardmodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicesoundcardmodelId)
        {
          $itemdevicesoundcardmodelId->map(['GET'], '', \App\Controllers\ItemDeviceSoundCardModel::class . ':showItem');
          $itemdevicesoundcardmodelId->map(['POST'], '', \App\Controllers\ItemDeviceSoundCardModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/itemdevicesensormodels', function (RouteCollectorProxy $itemdevicesensormodels)
      {
        $itemdevicesensormodels->map(['GET'], '', \App\Controllers\ItemDeviceSensorModel::class . ':getAll');
        $itemdevicesensormodels->map(['POST'], '', \App\Controllers\ItemDeviceSensorModel::class . ':postItem');
        $itemdevicesensormodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicesensormodelId)
        {
          $itemdevicesensormodelId->map(['GET'], '', \App\Controllers\ItemDeviceSensorModel::class . ':showItem');
          $itemdevicesensormodelId->map(['POST'], '', \App\Controllers\ItemDeviceSensorModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/rackmodels', function (RouteCollectorProxy $rackmodels)
      {
        $rackmodels->map(['GET'], '', \App\Controllers\RackModel::class . ':getAll');
        $rackmodels->map(['POST'], '', \App\Controllers\RackModel::class . ':postItem');
        $rackmodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $rackmodelId)
        {
          $rackmodelId->map(['GET'], '', \App\Controllers\RackModel::class . ':showItem');
          $rackmodelId->map(['POST'], '', \App\Controllers\RackModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/enclosuremodels', function (RouteCollectorProxy $enclosuremodels)
      {
        $enclosuremodels->map(['GET'], '', \App\Controllers\EnclosureModel::class . ':getAll');
        $enclosuremodels->map(['POST'], '', \App\Controllers\EnclosureModel::class . ':postItem');
        $enclosuremodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $enclosuremodelId)
        {
          $enclosuremodelId->map(['GET'], '', \App\Controllers\EnclosureModel::class . ':showItem');
          $enclosuremodelId->map(['POST'], '', \App\Controllers\EnclosureModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/pdumodels', function (RouteCollectorProxy $pdumodels)
      {
        $pdumodels->map(['GET'], '', \App\Controllers\PDUModel::class . ':getAll');
        $pdumodels->map(['POST'], '', \App\Controllers\PDUModel::class . ':postItem');
        $pdumodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $pdumodelId)
        {
          $pdumodelId->map(['GET'], '', \App\Controllers\PDUModel::class . ':showItem');
          $pdumodelId->map(['POST'], '', \App\Controllers\PDUModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/passivedcequipmentmodels', function (RouteCollectorProxy $passivedcequipmentmodels)
      {
        $passivedcequipmentmodels->map(['GET'], '', \App\Controllers\PassivedcEquipmentModel::class . ':getAll');
        $passivedcequipmentmodels->map(['POST'], '', \App\Controllers\PassivedcEquipmentModel::class . ':postItem');
        $passivedcequipmentmodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $passivedcequipmentmodelId)
        {
          $passivedcequipmentmodelId->map(['GET'], '', \App\Controllers\PassivedcEquipmentModel::class . ':showItem');
          $passivedcequipmentmodelId->map(['POST'], '', \App\Controllers\PassivedcEquipmentModel::class . ':updateItem');
        });
      });
      $dropdowns->group('/virtualmachinetypes', function (RouteCollectorProxy $virtualmachinetypes)
      {
        $virtualmachinetypes->map(['GET'], '', \App\Controllers\VirtualMachineType::class . ':getAll');
        $virtualmachinetypes->map(['POST'], '', \App\Controllers\VirtualMachineType::class . ':postItem');
        $virtualmachinetypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $virtualmachinetypeId)
        {
          $virtualmachinetypeId->map(['GET'], '', \App\Controllers\VirtualMachineType::class . ':showItem');
          $virtualmachinetypeId->map(['POST'], '', \App\Controllers\VirtualMachineType::class . ':updateItem');
        });
      });
      $dropdowns->group('/virtualmachinesystems', function (RouteCollectorProxy $virtualmachinesystems)
      {
        $virtualmachinesystems->map(['GET'], '', \App\Controllers\VirtualMachineSystem::class . ':getAll');
        $virtualmachinesystems->map(['POST'], '', \App\Controllers\VirtualMachineSystem::class . ':postItem');
        $virtualmachinesystems->group("/{id:[0-9]+}", function (RouteCollectorProxy $virtualmachinesystemId)
        {
          $virtualmachinesystemId->map(['GET'], '', \App\Controllers\VirtualMachineSystem::class . ':showItem');
          $virtualmachinesystemId->map(['POST'], '', \App\Controllers\VirtualMachineSystem::class . ':updateItem');
        });
      });
      $dropdowns->group('/virtualmachinestates', function (RouteCollectorProxy $virtualmachinestates)
      {
        $virtualmachinestates->map(['GET'], '', \App\Controllers\VirtualMachineState::class . ':getAll');
        $virtualmachinestates->map(['POST'], '', \App\Controllers\VirtualMachineState::class . ':postItem');
        $virtualmachinestates->group("/{id:[0-9]+}", function (RouteCollectorProxy $virtualmachinestateId)
        {
          $virtualmachinestateId->map(['GET'], '', \App\Controllers\VirtualMachineState::class . ':showItem');
          $virtualmachinestateId->map(['POST'], '', \App\Controllers\VirtualMachineState::class . ':updateItem');
        });
      });
      $dropdowns->group('/documentcategories', function (RouteCollectorProxy $documentcategories)
      {
        $documentcategories->map(['GET'], '', \App\Controllers\DocumentCategory::class . ':getAll');
        $documentcategories->map(['POST'], '', \App\Controllers\DocumentCategory::class . ':postItem');
        $documentcategories->group("/{id:[0-9]+}", function (RouteCollectorProxy $documentcategoryId)
        {
          $documentcategoryId->map(['GET'], '', \App\Controllers\DocumentCategory::class . ':showItem');
          $documentcategoryId->map(['POST'], '', \App\Controllers\DocumentCategory::class . ':updateItem');
        });
      });
      $dropdowns->group('/documenttypes', function (RouteCollectorProxy $documenttypes)
      {
        $documenttypes->map(['GET'], '', \App\Controllers\DocumentType::class . ':getAll');
        $documenttypes->map(['POST'], '', \App\Controllers\DocumentType::class . ':postItem');
        $documenttypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $documenttypeId)
        {
          $documenttypeId->map(['GET'], '', \App\Controllers\DocumentType::class . ':showItem');
          $documenttypeId->map(['POST'], '', \App\Controllers\DocumentType::class . ':updateItem');
        });
      });
      $dropdowns->group('/businesscriticities', function (RouteCollectorProxy $businesscriticities)
      {
        $businesscriticities->map(['GET'], '', \App\Controllers\BusinessCriticity::class . ':getAll');
        $businesscriticities->map(['POST'], '', \App\Controllers\BusinessCriticity::class . ':postItem');
        $businesscriticities->group("/{id:[0-9]+}", function (RouteCollectorProxy $businesscriticityId)
        {
          $businesscriticityId->map(['GET'], '', \App\Controllers\BusinessCriticity::class . ':showItem');
          $businesscriticityId->map(['POST'], '', \App\Controllers\BusinessCriticity::class . ':updateItem');
        });
      });
      $dropdowns->group('/knowbaseitemcategories', function (RouteCollectorProxy $knowbaseitemcategories)
      {
        $knowbaseitemcategories->map(['GET'], '', \App\Controllers\KnowbaseItemCategory::class . ':getAll');
        $knowbaseitemcategories->map(['POST'], '', \App\Controllers\KnowbaseItemCategory::class . ':postItem');
        $knowbaseitemcategories->group("/{id:[0-9]+}", function (RouteCollectorProxy $knowbaseitemcategoryId)
        {
          $knowbaseitemcategoryId->map(['GET'], '', \App\Controllers\KnowbaseItemCategory::class . ':showItem');
          $knowbaseitemcategoryId->map(['POST'], '', \App\Controllers\KnowbaseItemCategory::class . ':updateItem');
        });
      });
      $dropdowns->group('/calendars', function (RouteCollectorProxy $calendars)
      {
        $calendars->map(['GET'], '', \App\Controllers\Calendar::class . ':getAll');
        $calendars->map(['POST'], '', \App\Controllers\Calendar::class . ':postItem');
        $calendars->group("/{id:[0-9]+}", function (RouteCollectorProxy $calendarId)
        {
          $calendarId->map(['GET'], '', \App\Controllers\Calendar::class . ':showItem');
          $calendarId->map(['POST'], '', \App\Controllers\Calendar::class . ':updateItem');
        });
      });
      $dropdowns->group('/holidays', function (RouteCollectorProxy $holidays)
      {
        $holidays->map(['GET'], '', \App\Controllers\Holiday::class . ':getAll');
        $holidays->map(['POST'], '', \App\Controllers\Holiday::class . ':postItem');
        $holidays->group("/{id:[0-9]+}", function (RouteCollectorProxy $holidayId)
        {
          $holidayId->map(['GET'], '', \App\Controllers\Holiday::class . ':showItem');
          $holidayId->map(['POST'], '', \App\Controllers\Holiday::class . ':updateItem');
        });
      });
      $dropdowns->group('/operatingsystems', function (RouteCollectorProxy $operatingsystems)
      {
        $operatingsystems->map(['GET'], '', \App\Controllers\OperatingSystem::class . ':getAll');
        $operatingsystems->map(['POST'], '', \App\Controllers\OperatingSystem::class . ':postItem');
        $operatingsystems->group("/{id:[0-9]+}", function (RouteCollectorProxy $operatingsystemId)
        {
          $operatingsystemId->map(['GET'], '', \App\Controllers\OperatingSystem::class . ':showItem');
          $operatingsystemId->map(['POST'], '', \App\Controllers\OperatingSystem::class . ':updateItem');
        });
      });
      $dropdowns->group('/operatingsystemversions', function (RouteCollectorProxy $operatingsystemversions)
      {
        $operatingsystemversions->map(['GET'], '', \App\Controllers\OperatingSystemVersion::class . ':getAll');
        $operatingsystemversions->map(['POST'], '', \App\Controllers\OperatingSystemVersion::class . ':postItem');
        $operatingsystemversions->group("/{id:[0-9]+}", function (RouteCollectorProxy $operatingsystemversionId)
        {
          $operatingsystemversionId->map(['GET'], '', \App\Controllers\OperatingSystemVersion::class . ':showItem');
          $operatingsystemversionId->map(['POST'], '', \App\Controllers\OperatingSystemVersion::class . ':updateItem');
        });
      });
      $dropdowns->group('/operatingsystemservicepacks', function (RouteCollectorProxy $operatingsystemservicepacks)
      {
        $operatingsystemservicepacks->map(['GET'], '', \App\Controllers\OperatingSystemServicePack::class . ':getAll');
        $operatingsystemservicepacks->map(['POST'], '', \App\Controllers\OperatingSystemServicePack::class . ':postItem');
        $operatingsystemservicepacks->group("/{id:[0-9]+}", function (RouteCollectorProxy $operatingsystemservicepackId)
        {
          $operatingsystemservicepackId->map(['GET'], '', \App\Controllers\OperatingSystemServicePack::class . ':showItem');
          $operatingsystemservicepackId->map(['POST'], '', \App\Controllers\OperatingSystemServicePack::class . ':updateItem');
        });
      });
      $dropdowns->group('/operatingsystemarchitectures', function (RouteCollectorProxy $operatingsystemarchitectures)
      {
        $operatingsystemarchitectures->map(['GET'], '', \App\Controllers\OperatingSystemArchitecture::class . ':getAll');
        $operatingsystemarchitectures->map(['POST'], '', \App\Controllers\OperatingSystemArchitecture::class . ':postItem');
        $operatingsystemarchitectures->group("/{id:[0-9]+}", function (RouteCollectorProxy $operatingsystemarchitectureId)
        {
          $operatingsystemarchitectureId->map(['GET'], '', \App\Controllers\OperatingSystemArchitecture::class . ':showItem');
          $operatingsystemarchitectureId->map(['POST'], '', \App\Controllers\OperatingSystemArchitecture::class . ':updateItem');
        });
      });
      $dropdowns->group('/operatingsystemeditions', function (RouteCollectorProxy $operatingsystemeditions)
      {
        $operatingsystemeditions->map(['GET'], '', \App\Controllers\OperatingSystemEdition::class . ':getAll');
        $operatingsystemeditions->map(['POST'], '', \App\Controllers\OperatingSystemEdition::class . ':postItem');
        $operatingsystemeditions->group("/{id:[0-9]+}", function (RouteCollectorProxy $operatingsystemeditionId)
        {
          $operatingsystemeditionId->map(['GET'], '', \App\Controllers\OperatingSystemEdition::class . ':showItem');
          $operatingsystemeditionId->map(['POST'], '', \App\Controllers\OperatingSystemEdition::class . ':updateItem');
        });
      });
      $dropdowns->group('/operatingsystemkernels', function (RouteCollectorProxy $operatingsystemkernels)
      {
        $operatingsystemkernels->map(['GET'], '', \App\Controllers\OperatingSystemKernel::class . ':getAll');
        $operatingsystemkernels->map(['POST'], '', \App\Controllers\OperatingSystemKernel::class . ':postItem');
        $operatingsystemkernels->group("/{id:[0-9]+}", function (RouteCollectorProxy $operatingsystemkernelId)
        {
          $operatingsystemkernelId->map(['GET'], '', \App\Controllers\OperatingSystemKernel::class . ':showItem');
          $operatingsystemkernelId->map(['POST'], '', \App\Controllers\OperatingSystemKernel::class . ':updateItem');
        });
      });
      $dropdowns->group('/operatingsystemkernelversions', function (RouteCollectorProxy $operatingsystemkernelversions)
      {
        $operatingsystemkernelversions->map(['GET'], '', \App\Controllers\OperatingSystemKernelVersion::class . ':getAll');
        $operatingsystemkernelversions->map(['POST'], '', \App\Controllers\OperatingSystemKernelVersion::class . ':postItem');
        $operatingsystemkernelversions->group("/{id:[0-9]+}", function (RouteCollectorProxy $operatingsystemkernelversionId)
        {
          $operatingsystemkernelversionId->map(['GET'], '', \App\Controllers\OperatingSystemKernelVersion::class . ':showItem');
          $operatingsystemkernelversionId->map(['POST'], '', \App\Controllers\OperatingSystemKernelVersion::class . ':updateItem');
        });
      });
      $dropdowns->group('/autoupdatesystems', function (RouteCollectorProxy $autoupdatesystems)
      {
        $autoupdatesystems->map(['GET'], '', \App\Controllers\AutoUpdateSystem::class . ':getAll');
        $autoupdatesystems->map(['POST'], '', \App\Controllers\AutoUpdateSystem::class . ':postItem');
        $autoupdatesystems->group("/{id:[0-9]+}", function (RouteCollectorProxy $autoupdatesystemId)
        {
          $autoupdatesystemId->map(['GET'], '', \App\Controllers\AutoUpdateSystem::class . ':showItem');
          $autoupdatesystemId->map(['POST'], '', \App\Controllers\AutoUpdateSystem::class . ':updateItem');
        });
      });
      $dropdowns->group('/networkinterfaces', function (RouteCollectorProxy $networkinterfaces)
      {
        $networkinterfaces->map(['GET'], '', \App\Controllers\NetworkInterface::class . ':getAll');
        $networkinterfaces->map(['POST'], '', \App\Controllers\NetworkInterface::class . ':postItem');
        $networkinterfaces->group("/{id:[0-9]+}", function (RouteCollectorProxy $networkinterfaceId)
        {
          $networkinterfaceId->map(['GET'], '', \App\Controllers\NetworkInterface::class . ':showItem');
          $networkinterfaceId->map(['POST'], '', \App\Controllers\NetworkInterface::class . ':updateItem');
        });
      });
      $dropdowns->group('/netpoints', function (RouteCollectorProxy $netpoints)
      {
        $netpoints->map(['GET'], '', \App\Controllers\Netpoint::class . ':getAll');
        $netpoints->map(['POST'], '', \App\Controllers\Netpoint::class . ':postItem');
        $netpoints->group("/{id:[0-9]+}", function (RouteCollectorProxy $netpointId)
        {
          $netpointId->map(['GET'], '', \App\Controllers\Netpoint::class . ':showItem');
          $netpointId->map(['POST'], '', \App\Controllers\Netpoint::class . ':updateItem');
        });
      });
      $dropdowns->group('/networks', function (RouteCollectorProxy $networks)
      {
        $networks->map(['GET'], '', \App\Controllers\Network::class . ':getAll');
        $networks->map(['POST'], '', \App\Controllers\Network::class . ':postItem');
        $networks->group("/{id:[0-9]+}", function (RouteCollectorProxy $networkId)
        {
          $networkId->map(['GET'], '', \App\Controllers\Network::class . ':showItem');
          $networkId->map(['POST'], '', \App\Controllers\Network::class . ':updateItem');
        });
      });
      $dropdowns->group('/vlans', function (RouteCollectorProxy $vlans)
      {
        $vlans->map(['GET'], '', \App\Controllers\Vlan::class . ':getAll');
        $vlans->map(['POST'], '', \App\Controllers\Vlan::class . ':postItem');
        $vlans->group("/{id:[0-9]+}", function (RouteCollectorProxy $vlanId)
        {
          $vlanId->map(['GET'], '', \App\Controllers\Vlan::class . ':showItem');
          $vlanId->map(['POST'], '', \App\Controllers\Vlan::class . ':updateItem');
        });
      });
      $dropdowns->group('/lineoperators', function (RouteCollectorProxy $lineoperators)
      {
        $lineoperators->map(['GET'], '', \App\Controllers\LineOperator::class . ':getAll');
        $lineoperators->map(['POST'], '', \App\Controllers\LineOperator::class . ':postItem');
        $lineoperators->group("/{id:[0-9]+}", function (RouteCollectorProxy $lineoperatorId)
        {
          $lineoperatorId->map(['GET'], '', \App\Controllers\LineOperator::class . ':showItem');
          $lineoperatorId->map(['POST'], '', \App\Controllers\LineOperator::class . ':updateItem');
        });
      });
      $dropdowns->group('/domaintypes', function (RouteCollectorProxy $domaintypes)
      {
        $domaintypes->map(['GET'], '', \App\Controllers\DomainType::class . ':getAll');
        $domaintypes->map(['POST'], '', \App\Controllers\DomainType::class . ':postItem');
        $domaintypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $domaintypeId)
        {
          $domaintypeId->map(['GET'], '', \App\Controllers\DomainType::class . ':showItem');
          $domaintypeId->map(['POST'], '', \App\Controllers\DomainType::class . ':updateItem');
        });
      });
      $dropdowns->group('/domainrelations', function (RouteCollectorProxy $domainrelations)
      {
        $domainrelations->map(['GET'], '', \App\Controllers\DomainRelation::class . ':getAll');
        $domainrelations->map(['POST'], '', \App\Controllers\DomainRelation::class . ':postItem');
        $domainrelations->group("/{id:[0-9]+}", function (RouteCollectorProxy $domainrelationId)
        {
          $domainrelationId->map(['GET'], '', \App\Controllers\DomainRelation::class . ':showItem');
          $domainrelationId->map(['POST'], '', \App\Controllers\DomainRelation::class . ':updateItem');
        });
      });
      $dropdowns->group('/domainrecordtypes', function (RouteCollectorProxy $domainrecordtypes)
      {
        $domainrecordtypes->map(['GET'], '', \App\Controllers\DomainRecordType::class . ':getAll');
        $domainrecordtypes->map(['POST'], '', \App\Controllers\DomainRecordType::class . ':postItem');
        $domainrecordtypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $domainrecordtypeId)
        {
          $domainrecordtypeId->map(['GET'], '', \App\Controllers\DomainRecordType::class . ':showItem');
          $domainrecordtypeId->map(['POST'], '', \App\Controllers\DomainRecordType::class . ':updateItem');
        });
      });
      $dropdowns->group('/ipnetworks', function (RouteCollectorProxy $ipnetworks)
      {
        $ipnetworks->map(['GET'], '', \App\Controllers\IPNetwork::class . ':getAll');
        $ipnetworks->map(['POST'], '', \App\Controllers\IPNetwork::class . ':postItem');
        $ipnetworks->group("/{id:[0-9]+}", function (RouteCollectorProxy $ipnetworkId)
        {
          $ipnetworkId->map(['GET'], '', \App\Controllers\IPNetwork::class . ':showItem');
          $ipnetworkId->map(['POST'], '', \App\Controllers\IPNetwork::class . ':updateItem');
        });
      });
      $dropdowns->group('/fqdns', function (RouteCollectorProxy $fqdns)
      {
        $fqdns->map(['GET'], '', \App\Controllers\FQDN::class . ':getAll');
        $fqdns->map(['POST'], '', \App\Controllers\FQDN::class . ':postItem');
        $fqdns->group("/{id:[0-9]+}", function (RouteCollectorProxy $fqdnId)
        {
          $fqdnId->map(['GET'], '', \App\Controllers\FQDN::class . ':showItem');
          $fqdnId->map(['POST'], '', \App\Controllers\FQDN::class . ':updateItem');
        });
      });
      $dropdowns->group('/wifinetworks', function (RouteCollectorProxy $wifinetworks)
      {
        $wifinetworks->map(['GET'], '', \App\Controllers\WifiNetwork::class . ':getAll');
        $wifinetworks->map(['POST'], '', \App\Controllers\WifiNetwork::class . ':postItem');
        $wifinetworks->group("/{id:[0-9]+}", function (RouteCollectorProxy $wifinetworkId)
        {
          $wifinetworkId->map(['GET'], '', \App\Controllers\WifiNetwork::class . ':showItem');
          $wifinetworkId->map(['POST'], '', \App\Controllers\WifiNetwork::class . ':updateItem');
        });
      });
      $dropdowns->group('/networknames', function (RouteCollectorProxy $networknames)
      {
        $networknames->map(['GET'], '', \App\Controllers\NetworkName::class . ':getAll');
        $networknames->map(['POST'], '', \App\Controllers\NetworkName::class . ':postItem');
        $networknames->group("/{id:[0-9]+}", function (RouteCollectorProxy $networknameId)
        {
          $networknameId->map(['GET'], '', \App\Controllers\NetworkName::class . ':showItem');
          $networknameId->map(['POST'], '', \App\Controllers\NetworkName::class . ':updateItem');
        });
      });
      $dropdowns->group('/softwarecategories', function (RouteCollectorProxy $softwarecategories)
      {
        $softwarecategories->map(['GET'], '', \App\Controllers\SoftwareCategory::class . ':getAll');
        $softwarecategories->map(['POST'], '', \App\Controllers\SoftwareCategory::class . ':postItem');
        $softwarecategories->group("/{id:[0-9]+}", function (RouteCollectorProxy $softwarecategoryId)
        {
          $softwarecategoryId->map(['GET'], '', \App\Controllers\SoftwareCategory::class . ':showItem');
          $softwarecategoryId->map(['POST'], '', \App\Controllers\SoftwareCategory::class . ':updateItem');
        });
      });
      $dropdowns->group('/usertitles', function (RouteCollectorProxy $usertitles)
      {
        $usertitles->map(['GET'], '', \App\Controllers\UserTitle::class . ':getAll');
        $usertitles->map(['POST'], '', \App\Controllers\UserTitle::class . ':postItem');
        $usertitles->group("/{id:[0-9]+}", function (RouteCollectorProxy $usertitleId)
        {
          $usertitleId->map(['GET'], '', \App\Controllers\UserTitle::class . ':showItem');
          $usertitleId->map(['POST'], '', \App\Controllers\UserTitle::class . ':updateItem');
        });
      });
      $dropdowns->group('/usercategories', function (RouteCollectorProxy $usercategories)
      {
        $usercategories->map(['GET'], '', \App\Controllers\UserCategory::class . ':getAll');
        $usercategories->map(['POST'], '', \App\Controllers\UserCategory::class . ':postItem');
        $usercategories->group("/{id:[0-9]+}", function (RouteCollectorProxy $usercategoryId)
        {
          $usercategoryId->map(['GET'], '', \App\Controllers\UserCategory::class . ':showItem');
          $usercategoryId->map(['POST'], '', \App\Controllers\UserCategory::class . ':updateItem');
        });
      });
      $dropdowns->group('/rulerightparameters', function (RouteCollectorProxy $rulerightparameters)
      {
        $rulerightparameters->map(['GET'], '', \App\Controllers\RuleRightParameter::class . ':getAll');
        $rulerightparameters->map(['POST'], '', \App\Controllers\RuleRightParameter::class . ':postItem');
        $rulerightparameters->group("/{id:[0-9]+}", function (RouteCollectorProxy $rulerightparameterId)
        {
          $rulerightparameterId->map(['GET'], '', \App\Controllers\RuleRightParameter::class . ':showItem');
          $rulerightparameterId->map(['POST'], '', \App\Controllers\RuleRightParameter::class . ':updateItem');
        });
      });
      $dropdowns->group('/fieldblacklists', function (RouteCollectorProxy $fieldblacklists)
      {
        $fieldblacklists->map(['GET'], '', \App\Controllers\Fieldblacklist::class . ':getAll');
        $fieldblacklists->map(['POST'], '', \App\Controllers\Fieldblacklist::class . ':postItem');
        $fieldblacklists->group("/{id:[0-9]+}", function (RouteCollectorProxy $fieldblacklistId)
        {
          $fieldblacklistId->map(['GET'], '', \App\Controllers\Fieldblacklist::class . ':showItem');
          $fieldblacklistId->map(['POST'], '', \App\Controllers\Fieldblacklist::class . ':updateItem');
        });
      });
      $dropdowns->group('/ssovariables', function (RouteCollectorProxy $ssovariables)
      {
        $ssovariables->map(['GET'], '', \App\Controllers\SsoVariable::class . ':getAll');
        $ssovariables->map(['POST'], '', \App\Controllers\SsoVariable::class . ':postItem');
        $ssovariables->group("/{id:[0-9]+}", function (RouteCollectorProxy $ssovariableId)
        {
          $ssovariableId->map(['GET'], '', \App\Controllers\SsoVariable::class . ':showItem');
          $ssovariableId->map(['POST'], '', \App\Controllers\SsoVariable::class . ':updateItem');
        });
      });
      $dropdowns->group('/plugs', function (RouteCollectorProxy $plugs)
      {
        $plugs->map(['GET'], '', \App\Controllers\Plug::class . ':getAll');
        $plugs->map(['POST'], '', \App\Controllers\Plug::class . ':postItem');
        $plugs->group("/{id:[0-9]+}", function (RouteCollectorProxy $plugId)
        {
          $plugId->map(['GET'], '', \App\Controllers\Plug::class . ':showItem');
          $plugId->map(['POST'], '', \App\Controllers\Plug::class . ':updateItem');
        });
      });
      $dropdowns->group('/appliancetypes', function (RouteCollectorProxy $appliancetypes)
      {
        $appliancetypes->map(['GET'], '', \App\Controllers\ApplianceType::class . ':getAll');
        $appliancetypes->map(['POST'], '', \App\Controllers\ApplianceType::class . ':postItem');
        $appliancetypes->group("/{id:[0-9]+}", function (RouteCollectorProxy $appliancetypeId)
        {
          $appliancetypeId->map(['GET'], '', \App\Controllers\ApplianceType::class . ':showItem');
          $appliancetypeId->map(['POST'], '', \App\Controllers\ApplianceType::class . ':updateItem');
        });
      });
      $dropdowns->group('/applianceenvironments', function (RouteCollectorProxy $applianceenvironments)
      {
        $applianceenvironments->map(['GET'], '', \App\Controllers\ApplianceEnvironment::class . ':getAll');
        $applianceenvironments->map(['POST'], '', \App\Controllers\ApplianceEnvironment::class . ':postItem');
        $applianceenvironments->group("/{id:[0-9]+}", function (RouteCollectorProxy $applianceenvironmentId)
        {
          $applianceenvironmentId->map(['GET'], '', \App\Controllers\ApplianceEnvironment::class . ':showItem');
          $applianceenvironmentId->map(['POST'], '', \App\Controllers\ApplianceEnvironment::class . ':updateItem');
        });
      });
      $dropdowns->group('/oauthimapapplications', function (RouteCollectorProxy $oauthimapapplications)
      {
        $oauthimapapplications->map(['GET'], '', \App\Controllers\OauthimapApplication::class . ':getAll');
        $oauthimapapplications->map(['POST'], '', \App\Controllers\OauthimapApplication::class . ':postItem');
        $oauthimapapplications->group("/{id:[0-9]+}", function (RouteCollectorProxy $oauthimapapplicationId)
        {
          $oauthimapapplicationId->map(['GET'], '', \App\Controllers\OauthimapApplication::class . ':showItem');
          $oauthimapapplicationId->map(['POST'], '', \App\Controllers\OauthimapApplication::class . ':updateItem');
        });
      });
      $dropdowns->group('/formcreatorcategories', function (RouteCollectorProxy $formcreatorcategories)
      {
        $formcreatorcategories->map(['GET'], '', \App\Controllers\FormcreatorCategory::class . ':getAll');
        $formcreatorcategories->map(['POST'], '', \App\Controllers\FormcreatorCategory::class . ':postItem');
        $formcreatorcategories->group("/{id:[0-9]+}", function (RouteCollectorProxy $formcreatorcategoryId)
        {
          $formcreatorcategoryId->map(['GET'], '', \App\Controllers\FormcreatorCategory::class . ':showItem');
          $formcreatorcategoryId->map(['POST'], '', \App\Controllers\FormcreatorCategory::class . ':updateItem');
        });
      });
    });

    $app->group($prefix . '/devices', function (RouteCollectorProxy $devices)
    {
      $devices->group('/itemdevicepowersupplies', function (RouteCollectorProxy $itemdevicepowersupplies)
      {
        $itemdevicepowersupplies->map(['GET'], '', \App\Controllers\ItemDevicePowerSupply::class . ':getAll');
        $itemdevicepowersupplies->map(['POST'], '', \App\Controllers\ItemDevicePowerSupply::class . ':postItem');
        $itemdevicepowersupplies->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicepowersupplyId)
        {
          $itemdevicepowersupplyId->map(['GET'], '', \App\Controllers\ItemDevicePowerSupply::class . ':showItem');
          $itemdevicepowersupplyId->map(['POST'], '', \App\Controllers\ItemDevicePowerSupply::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicebatteries', function (RouteCollectorProxy $itemdevicebatteries)
      {
        $itemdevicebatteries->map(['GET'], '', \App\Controllers\ItemDeviceBattery::class . ':getAll');
        $itemdevicebatteries->map(['POST'], '', \App\Controllers\ItemDeviceBattery::class . ':postItem');
        $itemdevicebatteries->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicebatteryId)
        {
          $itemdevicebatteryId->map(['GET'], '', \App\Controllers\ItemDeviceBattery::class . ':showItem');
          $itemdevicebatteryId->map(['POST'], '', \App\Controllers\ItemDeviceBattery::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicecases', function (RouteCollectorProxy $itemdevicecases)
      {
        $itemdevicecases->map(['GET'], '', \App\Controllers\ItemDeviceCase::class . ':getAll');
        $itemdevicecases->map(['POST'], '', \App\Controllers\ItemDeviceCase::class . ':postItem');
        $itemdevicecases->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicecaseId)
        {
          $itemdevicecaseId->map(['GET'], '', \App\Controllers\ItemDeviceCase::class . ':showItem');
          $itemdevicecaseId->map(['POST'], '', \App\Controllers\ItemDeviceCase::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicesensors', function (RouteCollectorProxy $itemdevicesensors)
      {
        $itemdevicesensors->map(['GET'], '', \App\Controllers\ItemDeviceSensor::class . ':getAll');
        $itemdevicesensors->map(['POST'], '', \App\Controllers\ItemDeviceSensor::class . ':postItem');
        $itemdevicesensors->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicesensorId)
        {
          $itemdevicesensorId->map(['GET'], '', \App\Controllers\ItemDeviceSensor::class . ':showItem');
          $itemdevicesensorId->map(['POST'], '', \App\Controllers\ItemDeviceSensor::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicesimcards', function (RouteCollectorProxy $itemdevicesimcards)
      {
        $itemdevicesimcards->map(['GET'], '', \App\Controllers\ItemDeviceSimcard::class . ':getAll');
        $itemdevicesimcards->map(['POST'], '', \App\Controllers\ItemDeviceSimcard::class . ':postItem');
        $itemdevicesimcards->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicesimcardId)
        {
          $itemdevicesimcardId->map(['GET'], '', \App\Controllers\ItemDeviceSimcard::class . ':showItem');
          $itemdevicesimcardId->map(['POST'], '', \App\Controllers\ItemDeviceSimcard::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicegraphiccards', function (RouteCollectorProxy $itemdevicegraphiccards)
      {
        $itemdevicegraphiccards->map(['GET'], '', \App\Controllers\ItemDeviceGraphicCard::class . ':getAll');
        $itemdevicegraphiccards->map(['POST'], '', \App\Controllers\ItemDeviceGraphicCard::class . ':postItem');
        $itemdevicegraphiccards->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicegraphiccardId)
        {
          $itemdevicegraphiccardId->map(['GET'], '', \App\Controllers\ItemDeviceGraphicCard::class . ':showItem');
          $itemdevicegraphiccardId->map(['POST'], '', \App\Controllers\ItemDeviceGraphicCard::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicemotherboards', function (RouteCollectorProxy $itemdevicemotherboards)
      {
        $itemdevicemotherboards->map(['GET'], '', \App\Controllers\ItemDeviceMotherBoard::class . ':getAll');
        $itemdevicemotherboards->map(['POST'], '', \App\Controllers\ItemDeviceMotherBoard::class . ':postItem');
        $itemdevicemotherboards->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicemotherboardId)
        {
          $itemdevicemotherboardId->map(['GET'], '', \App\Controllers\ItemDeviceMotherBoard::class . ':showItem');
          $itemdevicemotherboardId->map(['POST'], '', \App\Controllers\ItemDeviceMotherBoard::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicenetworkcards', function (RouteCollectorProxy $itemdevicenetworkcards)
      {
        $itemdevicenetworkcards->map(['GET'], '', \App\Controllers\ItemDeviceNetworkCard::class . ':getAll');
        $itemdevicenetworkcards->map(['POST'], '', \App\Controllers\ItemDeviceNetworkCard::class . ':postItem');
        $itemdevicenetworkcards->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicenetworkcardId)
        {
          $itemdevicenetworkcardId->map(['GET'], '', \App\Controllers\ItemDeviceNetworkCard::class . ':showItem');
          $itemdevicenetworkcardId->map(['POST'], '', \App\Controllers\ItemDeviceNetworkCard::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicesoundcardmodels', function (RouteCollectorProxy $itemdevicesoundcardmodels)
      {
        $itemdevicesoundcardmodels->map(['GET'], '', \App\Controllers\ItemDeviceSoundCard::class . ':getAll');
        $itemdevicesoundcardmodels->map(['POST'], '', \App\Controllers\ItemDeviceSoundCard::class . ':postItem');
        $itemdevicesoundcardmodels->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicesoundcardmodelId)
        {
          $itemdevicesoundcardmodelId->map(['GET'], '', \App\Controllers\ItemDeviceSoundCard::class . ':showItem');
          $itemdevicesoundcardmodelId->map(['POST'], '', \App\Controllers\ItemDeviceSoundCard::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicegenerics', function (RouteCollectorProxy $itemdevicegenerics)
      {
        $itemdevicegenerics->map(['GET'], '', \App\Controllers\ItemDeviceGeneric::class . ':getAll');
        $itemdevicegenerics->map(['POST'], '', \App\Controllers\ItemDeviceGeneric::class . ':postItem');
        $itemdevicegenerics->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicegenericId)
        {
          $itemdevicegenericId->map(['GET'], '', \App\Controllers\ItemDeviceGeneric::class . ':showItem');
          $itemdevicegenericId->map(['POST'], '', \App\Controllers\ItemDeviceGeneric::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicecontrols', function (RouteCollectorProxy $itemdevicecontrols)
      {
        $itemdevicecontrols->map(['GET'], '', \App\Controllers\ItemDeviceControl::class . ':getAll');
        $itemdevicecontrols->map(['POST'], '', \App\Controllers\ItemDeviceControl::class . ':postItem');
        $itemdevicecontrols->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicecontrolId)
        {
          $itemdevicecontrolId->map(['GET'], '', \App\Controllers\ItemDeviceControl::class . ':showItem');
          $itemdevicecontrolId->map(['POST'], '', \App\Controllers\ItemDeviceControl::class . ':updateItem');
        });
      });
      $devices->group('/itemdeviceharddrives', function (RouteCollectorProxy $itemdeviceharddrives)
      {
        $itemdeviceharddrives->map(['GET'], '', \App\Controllers\ItemDeviceHardDrive::class . ':getAll');
        $itemdeviceharddrives->map(['POST'], '', \App\Controllers\ItemDeviceHardDrive::class . ':postItem');
        $itemdeviceharddrives->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdeviceharddriveId)
        {
          $itemdeviceharddriveId->map(['GET'], '', \App\Controllers\ItemDeviceHardDrive::class . ':showItem');
          $itemdeviceharddriveId->map(['POST'], '', \App\Controllers\ItemDeviceHardDrive::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicefirmwares', function (RouteCollectorProxy $itemdevicefirmwares)
      {
        $itemdevicefirmwares->map(['GET'], '', \App\Controllers\ItemDeviceFirmware::class . ':getAll');
        $itemdevicefirmwares->map(['POST'], '', \App\Controllers\ItemDeviceFirmware::class . ':postItem');
        $itemdevicefirmwares->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicefirmwareId)
        {
          $itemdevicefirmwareId->map(['GET'], '', \App\Controllers\ItemDeviceFirmware::class . ':showItem');
          $itemdevicefirmwareId->map(['POST'], '', \App\Controllers\ItemDeviceFirmware::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicedrives', function (RouteCollectorProxy $itemdevicedrives)
      {
        $itemdevicedrives->map(['GET'], '', \App\Controllers\ItemDeviceDrive::class . ':getAll');
        $itemdevicedrives->map(['POST'], '', \App\Controllers\ItemDeviceDrive::class . ':postItem');
        $itemdevicedrives->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicedriveId)
        {
          $itemdevicedriveId->map(['GET'], '', \App\Controllers\ItemDeviceDrive::class . ':showItem');
          $itemdevicedriveId->map(['POST'], '', \App\Controllers\ItemDeviceDrive::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicememories', function (RouteCollectorProxy $itemdevicememories)
      {
        $itemdevicememories->map(['GET'], '', \App\Controllers\ItemDeviceMemory::class . ':getAll');
        $itemdevicememories->map(['POST'], '', \App\Controllers\ItemDeviceMemory::class . ':postItem');
        $itemdevicememories->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicememoryId)
        {
          $itemdevicememoryId->map(['GET'], '', \App\Controllers\ItemDeviceMemory::class . ':showItem');
          $itemdevicememoryId->map(['POST'], '', \App\Controllers\ItemDeviceMemory::class . ':updateItem');
        });
      });
      $devices->group('/itemdeviceprocessors', function (RouteCollectorProxy $itemdeviceprocessors)
      {
        $itemdeviceprocessors->map(['GET'], '', \App\Controllers\ItemDeviceProcessor::class . ':getAll');
        $itemdeviceprocessors->map(['POST'], '', \App\Controllers\ItemDeviceProcessor::class . ':postItem');
        $itemdeviceprocessors->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdeviceprocessorId)
        {
          $itemdeviceprocessorId->map(['GET'], '', \App\Controllers\ItemDeviceProcessor::class . ':showItem');
          $itemdeviceprocessorId->map(['POST'], '', \App\Controllers\ItemDeviceProcessor::class . ':updateItem');
        });
      });
      $devices->group('/itemdevicepcis', function (RouteCollectorProxy $itemdevicepcis)
      {
        $itemdevicepcis->map(['GET'], '', \App\Controllers\ItemDevicePci::class . ':getAll');
        $itemdevicepcis->map(['POST'], '', \App\Controllers\ItemDevicePci::class . ':postItem');
        $itemdevicepcis->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicepciId)
        {
          $itemdevicepciId->map(['GET'], '', \App\Controllers\ItemDevicePci::class . ':showItem');
          $itemdevicepciId->map(['POST'], '', \App\Controllers\ItemDevicePci::class . ':updateItem');
        });
      });
    });

    $app->group($prefix . '/notifications', function (RouteCollectorProxy $notifications)
    {
      $notifications->group('/notificationtemplates', function (RouteCollectorProxy $notificationtemplates)
      {
        $notificationtemplates->map(['GET'], '', \App\Controllers\NotificationTemplate::class . ':getAll');
        $notificationtemplates->map(['POST'], '', \App\Controllers\NotificationTemplate::class . ':postItem');
        $notificationtemplates->group("/{id:[0-9]+}", function (RouteCollectorProxy $notificationtemplateId)
        {
          $notificationtemplateId->map(['GET'], '', \App\Controllers\NotificationTemplate::class . ':showItem');
          $notificationtemplateId->map(['POST'], '', \App\Controllers\NotificationTemplate::class . ':updateItem');
        });
      });
      $notifications->group('/notifications', function (RouteCollectorProxy $notifications)
      {
        $notifications->map(['GET'], '', \App\Controllers\Notification::class . ':getAll');
        $notifications->map(['POST'], '', \App\Controllers\Notification::class . ':postItem');
        $notifications->group("/{id:[0-9]+}", function (RouteCollectorProxy $notificationId)
        {
          $notificationId->map(['GET'], '', \App\Controllers\Notification::class . ':showItem');
          $notificationId->map(['POST'], '', \App\Controllers\Notification::class . ':updateItem');
        });
      });
    });

    $app->group($prefix . '/slms', function (RouteCollectorProxy $slms)
    {
      $slms->map(['GET'], '', \App\Controllers\Slm::class . ':getAll');
      $slms->map(['POST'], '', \App\Controllers\Slm::class . ':postItem');
      $slms->group("/{id:[0-9]+}", function (RouteCollectorProxy $slmId)
      {
        $slmId->map(['GET'], '', \App\Controllers\Slm::class . ':showItem');
        $slmId->map(['POST'], '', \App\Controllers\Slm::class . ':updateItem');
      });
    });

    $app->group($prefix . '/fieldunicities', function (RouteCollectorProxy $fieldunicities)
    {
      $fieldunicities->map(['GET'], '', \App\Controllers\Fieldunicity::class . ':getAll');
      $fieldunicities->map(['POST'], '', \App\Controllers\Fieldunicity::class . ':postItem');
      $fieldunicities->group("/{id:[0-9]+}", function (RouteCollectorProxy $fieldunicityId)
      {
        $fieldunicityId->map(['GET'], '', \App\Controllers\Fieldunicity::class . ':showItem');
        $fieldunicityId->map(['POST'], '', \App\Controllers\Fieldunicity::class . ':updateItem');
      });
    });

    $app->group($prefix . '/crontasks', function (RouteCollectorProxy $crontasks)
    {
      $crontasks->map(['GET'], '', \App\Controllers\Crontask::class . ':getAll');
      $crontasks->map(['POST'], '', \App\Controllers\Crontask::class . ':postItem');
      $crontasks->group("/{id:[0-9]+}", function (RouteCollectorProxy $crontaskId)
      {
        $crontaskId->map(['GET'], '', \App\Controllers\Crontask::class . ':showItem');
        $crontaskId->map(['POST'], '', \App\Controllers\Crontask::class . ':updateItem');
      });
    });

    $app->group($prefix . '/links', function (RouteCollectorProxy $links)
    {
      $links->map(['GET'], '', \App\Controllers\Link::class . ':getAll');
      $links->map(['POST'], '', \App\Controllers\Link::class . ':postItem');
      $links->group("/{id:[0-9]+}", function (RouteCollectorProxy $linkId)
      {
        $linkId->map(['GET'], '', \App\Controllers\Link::class . ':showItem');
        $linkId->map(['POST'], '', \App\Controllers\Link::class . ':updateItem');
      });
    });



  }
}
