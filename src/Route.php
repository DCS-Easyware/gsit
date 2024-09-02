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


    $app->group($prefix . '/computers', function (RouteCollectorProxy $computers)
    {
      $computers->map(['GET'], '', \App\Controllers\Computer::class . ':getAll');
      $computers->map(['POST'], '', \App\Controllers\Computer::class . ':postItem');
      $computers->group("/{id:[0-9]+}", function (RouteCollectorProxy $computerId)
      {
        $computerId->map(['GET'], '', \App\Controllers\Computer::class . ':showItem');
        $computerId->map(['POST'], '', \App\Controllers\Computer::class . ':updateItem');
        $computerId->map(['GET'], '/operatingsystem', \App\Controllers\Computer::class . ':showOperatingsystem');
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
      $networkequipments->map(['GET'], '', \App\Controllers\Networkequipment::class . ':getAll');
      $networkequipments->map(['POST'], '', \App\Controllers\Networkequipment::class . ':postItem');
      $networkequipments->group("/{id:[0-9]+}", function (RouteCollectorProxy $networkequipmentId)
      {
        $networkequipmentId->map(['GET'], '', \App\Controllers\Networkequipment::class . ':showItem');
        $networkequipmentId->map(['POST'], '', \App\Controllers\Networkequipment::class . ':updateItem');
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
      $cartridgeitems->map(['GET'], '', \App\Controllers\Cartridgeitem::class . ':getAll');
      $cartridgeitems->map(['POST'], '', \App\Controllers\Cartridgeitem::class . ':postItem');
      $cartridgeitems->group("/{id:[0-9]+}", function (RouteCollectorProxy $cartridgeitemId)
      {
        $cartridgeitemId->map(['GET'], '', \App\Controllers\Cartridgeitem::class . ':showItem');
        $cartridgeitemId->map(['POST'], '', \App\Controllers\Cartridgeitem::class . ':updateItem');
      });
    });
    $app->group($prefix . '/consumableitems', function (RouteCollectorProxy $consumableitems)
    {
      $consumableitems->map(['GET'], '', \App\Controllers\Consumableitem::class . ':getAll');
      $consumableitems->map(['POST'], '', \App\Controllers\Consumableitem::class . ':postItem');
      $consumableitems->group("/{id:[0-9]+}", function (RouteCollectorProxy $consumableitemId)
      {
        $consumableitemId->map(['GET'], '', \App\Controllers\Consumableitem::class . ':showItem');
        $consumableitemId->map(['POST'], '', \App\Controllers\Consumableitem::class . ':updateItem');
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
      $passivedcequipments->map(['GET'], '', \App\Controllers\Passivedcequipment::class . ':getAll');
      $passivedcequipments->map(['POST'], '', \App\Controllers\Passivedcequipment::class . ':postItem');
      $passivedcequipments->group("/{id:[0-9]+}", function (RouteCollectorProxy $passivedcequipmentId)
      {
        $passivedcequipmentId->map(['GET'], '', \App\Controllers\Passivedcequipment::class . ':showItem');
        $passivedcequipmentId->map(['POST'], '', \App\Controllers\Passivedcequipment::class . ':updateItem');
      });
    });
    $app->group($prefix . '/itemdevicesimcard', function (RouteCollectorProxy $itemdevicesimcard)
    {
      $itemdevicesimcard->map(['GET'], '', \App\Controllers\ItemDeviceSimcard::class . ':getAll');
      $itemdevicesimcard->map(['POST'], '', \App\Controllers\ItemDeviceSimcard::class . ':postItem');
      $itemdevicesimcard->group("/{id:[0-9]+}", function (RouteCollectorProxy $itemdevicesimcardId)
      {
        $itemdevicesimcardId->map(['GET'], '', \App\Controllers\ItemDeviceSimcard::class . ':showItem');
        $itemdevicesimcardId->map(['POST'], '', \App\Controllers\ItemDeviceSimcard::class . ':updateItem');
      });
    });


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
      $ticketrecurrents->map(['GET'], '', \App\Controllers\Ticketrecurrent::class . ':getAll');
      $ticketrecurrents->map(['POST'], '', \App\Controllers\Ticketrecurrent::class . ':postItem');

      $ticketrecurrents->group("/{id:[0-9]+}", function (RouteCollectorProxy $ticketrecurrentId)
      {
        $ticketrecurrentId->map(['GET'], '', \App\Controllers\Ticketrecurrent::class . ':showItem');
        $ticketrecurrentId->map(['POST'], '', \App\Controllers\Ticketrecurrent::class . ':updateItem');
      });
    });


    $app->group($prefix . '/softwarelicenses', function (RouteCollectorProxy $softwarelicenses)
    {
      $softwarelicenses->map(['GET'], '', \App\Controllers\Softwarelicense::class . ':getAll');
      $softwarelicenses->map(['POST'], '', \App\Controllers\Softwarelicense::class . ':postItem');
      $softwarelicenses->group("/{id:[0-9]+}", function (RouteCollectorProxy $softwarelicenseId)
      {
        $softwarelicenseId->map(['GET'], '', \App\Controllers\Softwarelicense::class . ':showItem');
        $softwarelicenseId->map(['POST'], '', \App\Controllers\Softwarelicense::class . ':updateItem');
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
      $savedsearchs->map(['GET'], '', \App\Controllers\Savedsearch::class . ':getAll');
      $savedsearchs->map(['POST'], '', \App\Controllers\Savedsearch::class . ':postItem');
      $savedsearchs->group("/{id:[0-9]+}", function (RouteCollectorProxy $savedsearchId)
      {
        $savedsearchId->map(['GET'], '', \App\Controllers\Savedsearch::class . ':showItem');
        $savedsearchId->map(['POST'], '', \App\Controllers\Savedsearch::class . ':updateItem');
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


    // $app->group($prefix . '/users', function (RouteCollectorProxy $users)
    // {
    //   $users->map(['GET'], '', \App\Controllers\User::class . ':getAll');
    //   $users->map(['POST'], '', \App\Controllers\User::class . ':postItem');
    //   $users->group("/{id:[0-9]+}", function (RouteCollectorProxy $userId)
    //   {
    //     $userId->map(['GET'], '', \App\Controllers\User::class . ':showItem');
    //     $userId->map(['POST'], '', \App\Controllers\User::class . ':updateItem');
    //   });
    // });
    // $app->group($prefix . '/groups', function (RouteCollectorProxy $groups)
    // {
    //   $groups->map(['GET'], '', \App\Controllers\Group::class . ':getAll');
    //   $groups->map(['POST'], '', \App\Controllers\Group::class . ':postItem');
    //   $groups->group("/{id:[0-9]+}", function (RouteCollectorProxy $groupId)
    //   {
    //     $groupId->map(['GET'], '', \App\Controllers\Group::class . ':showItem');
    //     $groupId->map(['POST'], '', \App\Controllers\Group::class . ':updateItem');
    //   });
    // });
    // $app->group($prefix . '/entities', function (RouteCollectorProxy $entities)
    // {
    //   $entities->map(['GET'], '', \App\Controllers\Entity::class . ':getAll');
    //   $entities->map(['POST'], '', \App\Controllers\Entity::class . ':postItem');
    //   $entities->group("/{id:[0-9]+}", function (RouteCollectorProxy $entityId)
    //   {
    //     $entityId->map(['GET'], '', \App\Controllers\Entity::class . ':showItem');
    //     $entityId->map(['POST'], '', \App\Controllers\Entity::class . ':updateItem');
    //   });
    // });
    $app->group($prefix . '/rules', function (RouteCollectorProxy $rules)
    {
      $rules->group("/tickets", function (RouteCollectorProxy $tickets)
      {
        $tickets->map(['GET'], '', \App\Controllers\Rules\Ticket::class . ':getAll');
      });
    });
    // $app->group($prefix . '/profiles', function (RouteCollectorProxy $profiles)
    // {
    //   $profiles->map(['GET'], '', \App\Controllers\Profile::class . ':getAll');
    //   $profiles->map(['POST'], '', \App\Controllers\Profile::class . ':postItem');
    //   $profiles->group("/{id:[0-9]+}", function (RouteCollectorProxy $profileId)
    //   {
    //     $profileId->map(['GET'], '', \App\Controllers\Profile::class . ':showItem');
    //     $profileId->map(['POST'], '', \App\Controllers\Profile::class . ':updateItem');
    //   });
    // });
    // $app->group($prefix . '/queuednotifications', function (RouteCollectorProxy $queuednotifications)
    // {
    //   $queuednotifications->map(['GET'], '', \App\Controllers\Queuednotification::class . ':getAll');
    //   $queuednotifications->map(['POST'], '', \App\Controllers\Queuednotification::class . ':postItem');
    //   $queuednotifications->group("/{id:[0-9]+}", function (RouteCollectorProxy $queuednotificationId)
    //   {
    //     $queuednotificationId->map(['GET'], '', \App\Controllers\Queuednotification::class . ':showItem');
    //     $queuednotificationId->map(['POST'], '', \App\Controllers\Queuednotification::class . ':updateItem');
    //   });
    // });
    // $app->group($prefix . '/events', function (RouteCollectorProxy $events)
    // {
    //   $events->map(['GET'], '', \App\Controllers\Event::class . ':getAll');
    //   $events->map(['POST'], '', \App\Controllers\Event::class . ':postItem');
    //   $events->group("/{id:[0-9]+}", function (RouteCollectorProxy $eventId)
    //   {
    //     $eventId->map(['GET'], '', \App\Controllers\Event::class . ':showItem');
    //     $eventId->map(['POST'], '', \App\Controllers\Event::class . ':updateItem');
    //   });
    // });
    // $app->group($prefix . '/forms', function (RouteCollectorProxy $forms)
    // {
    //   $forms->map(['GET'], '', \App\Controllers\Form::class . ':getAll');
    //   $forms->map(['POST'], '', \App\Controllers\Form::class . ':postItem');
    //   $forms->group("/{id:[0-9]+}", function (RouteCollectorProxy $formId)
    //   {
    //     $formId->map(['GET'], '', \App\Controllers\Form::class . ':showItem');
    //     $formId->map(['POST'], '', \App\Controllers\Form::class . ':updateItem');
    //   });
    // });




  }
}
