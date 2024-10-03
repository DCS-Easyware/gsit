<?php

namespace App\v1\Controllers\Rules\Criteria;

class Ticket
{
  public static function get()
  {
    global $translator;

    return [
      'name' => [
        'table'     => 'glpi_tickets',
        'field'     => 'name',
        'name'      => $translator->translate('Title'),
        'linkfield' => 'name',
      ],
      'content' => [
        'table'     => 'glpi_tickets',
        'field'     => 'content',
        'name'      => $translator->translate('Description'),
        'linkfield' => 'content',
      ],
      'date_mod' => [
        'table'     => 'glpi_tickets',
        'field'     => 'date_mod',
        'name'      => $translator->translate('Last update'),
        'linkfield' => 'date_mod',
      ],
      'categories_id' => [
        'table'     => 'categories',
        'field'     => 'name',
        'name'      => $translator->translate('Category') . ' - ' . $translator->translate('Name'),
        'linkfield' => 'category_id',
        'type'      => 'dropdown',
      ],
      'itilcategories_id_cn' => [
        'table'     => 'categories',
        'field'     => 'completename',
        'name'      => $translator->translate('Category') . ' - ' . $translator->translate('Complete name'),
        'linkfield' => 'category_id',
        'type'      => 'dropdown',
      ],
      'itilcategories_id_code' => [
        'table'     => 'categories',
        'field'     => 'code',
        'name'      => $translator->translate('Code representing the ticket category'),
      ],
      'type' => [
        'table'     => 'glpi_tickets',
        'field'     => 'type',
        'name'      => $translator->translatePlural('Type', 'Types', 1),
        'linkfield' => 'type',
        'type'      => 'dropdown_tickettype',
      ],
      '_users_id_requester' => [
        'table'     => 'glpi_users',
        'field'     => 'name',
        'name'      => $translator->translatePlural('Requester', 'Requesters', 1),
        'linkfield' => '_users_id_requester',
        'type'      => 'dropdown_users',
        'linked_criteria' => '_groups_id_of_requester',
      ],
      '_groups_id_of_requester' => [
        'table'     => 'glpi_groups',
        'field'     => 'completename',
        'name'      => $translator->translate('Requester in group'),
        'linkfield' => '_groups_id_of_requester',
        'type'      => 'dropdown',
      ],
      '_locations_id_of_requester' => [
        'table'     => 'glpi_locations',
        'field'     => 'completename',
        'name'      => $translator->translate('Requester location'),
        'linkfield' => '_locations_id_of_requester',
        'type'      => 'dropdown',
      ],
      '_locations_id_of_item' => [
        'table'     => 'glpi_locations',
        'field'     => 'completename',
        'name'      => $translator->translate('Item location'),
        'linkfield' => '_locations_id_of_item',
        'type'      => 'dropdown',
      ],
      '_groups_id_of_item' => [
        'table'     => 'glpi_groups',
        'field'     => 'completename',
        'name'      => $translator->translate('Item group'),
        'linkfield' => '_groups_id_of_item',
        'type'      => 'dropdown',
      ],
      '_states_id_of_item' => [
        'table'     => 'glpi_states',
        'field'     => 'completename',
        'name'      => $translator->translate('Item state'),
        'linkfield' => '_states_id_of_item',
        'type'      => 'dropdown',
      ],
      'locations_id' => [
        'table'     => 'glpi_locations',
        'field'     => 'completename',
        'name'      => $translator->translate('Ticket location'),
        'linkfield' => 'locations_id',
        'type'      => 'dropdown',
      ],
      '_groups_id_requester' => [
        'table'     => 'glpi_groups',
        'field'     => 'completename',
        'name'      => $translator->translatePlural('Requester group', 'Requester groups', 1),
        'linkfield' => '_groups_id_requester',
        'type'      => 'dropdown',
      ],
      '_users_id_assign' => [
        'table'     => 'glpi_users',
        'field'     => 'name',
        'name'      => $translator->translate('Technician'),
        'linkfield' => '_users_id_assign',
        'type'      => 'dropdown_users',
      ],
      '_groups_id_assign' => [
        'table'     => 'glpi_groups',
        'field'     => 'completename',
        'name'      => $translator->translate('Technician group'),
        'linkfield' => '_groups_id_assign',
        'type'      => 'dropdown',
        'condition' => ['is_assign' => 1],
      ],
      '_suppliers_id_assign' => [
        'table'     => 'glpi_suppliers',
        'field'     => 'name',
        'name'      => $translator->translate('Assigned to a supplier'),
        'linkfield' => '_suppliers_id_assign',
        'type'      => 'dropdown',
      ],
      '_users_id_observer' => [
        'table'     => 'glpi_users',
        'field'     => 'name',
        'name'      => $translator->translatePlural('Watcher', 'Watchers', 1),
        'linkfield' => '_users_id_observer',
        'type'      => 'dropdown_users',
      ],
      '_groups_id_observer' => [
        'table'     => 'glpi_groups',
        'field'     => 'completename',
        'name'      => $translator->translatePlural('Watcher group', 'Watcher groups', 1),
        'linkfield' => '_groups_id_observer',
        'type'      => 'dropdown',
      ],
      'requesttypes_id' => [
        'table'     => 'glpi_requesttypes',
        'field'     => 'name',
        'name'      => $translator->translatePlural('Request source', 'Request sources', 1),
        'linkfield' => 'requesttypes_id',
        'type'      => 'dropdown',
      ],
      'itemtype' => [
        'table'     => 'glpi_tickets',
        'field'     => 'itemtype',
        'name'      => $translator->translate('Item type'),
        'linkfield' => 'itemtype',
        'type'      => 'dropdown_tracking_itemtype',
      ],
      'entities_id' => [
        'table'     => 'glpi_entities',
        'field'     => 'name',
        'name'      => $translator->translatePlural('Entity', 'Entities', 1),
        'linkfield' => 'entities_id',
        'type'      => 'dropdown',
      ],
      'profiles_id' => [
        'table'     => 'glpi_profiles',
        'field'     => 'name',
        'name'      => $translator->translate('Default profile'),
        'linkfield' => 'profiles_id',
        'type'      => 'dropdown',
      ],
      'urgency' => [
        'name'      => $translator->translate('Urgency'),
        'type'      => 'dropdown_urgency',
      ],
      'impact' => [
        'name'      => $translator->translate('Impact'),
        'type'      => 'dropdown_impact',
      ],
      'priority' => [
        'name'      => $translator->translate('Priority'),
        'type'      => 'dropdown_priority',
      ],
      'status' => [
        'table'     => '',
        'field'     => '',
        'name'      => $translator->translate('Status'),
        'type'      => 'dropdown_status',
      ],
      '_mailgate' => [
        'table'     => 'glpi_mailcollectors',
        'field'     => 'name',
        'name'      => $translator->translate('Mails receiver'),
        'linkfield' => '_mailgate',
        'type'      => 'dropdown',
      ],
      '_x-priority' => [
        'table'     => '',
        'name'      => $translator->translate('X-Priority email header'),
        'type'      => 'text',
      ],
      'slas_id_ttr' => [
        'table'     => 'glpi_slas',
        'field'     => 'name',
        'name'      => $translator->translate('SLA') . ' ' . $translator->translate('Time to resolve'),
        'linkfield' => 'slas_id_ttr',
        'type'      => 'dropdown',
        // 'condition' => ['glpi_slas.type' => SLM::TTR],
      ],
      'slas_id_tto' => [
        'table'     => 'glpi_slas',
        'field'     => 'name',
        'name'      => $translator->translate('SLA') . ' ' . $translator->translate('Time to own'),
        'linkfield' => 'slas_id_tto',
        'type'      => 'dropdown',
        // 'condition' => ['glpi_slas.type' => SLM::TTO],
      ],
      'olas_id_ttr' => [
        'table'     => 'glpi_olas',
        'field'     => 'name',
        'name'      => $translator->translate('OLA') . ' ' . $translator->translate('Time to resolve'),
        'linkfield' => 'olas_id_ttr',
        'type'      => 'dropdown',
        // 'condition' => ['glpi_olas.type' => SLM::TTR],
      ],
      'olas_id_tto' => [
        'table'     => 'glpi_olas',
        'field'     => 'name',
        'name'      => $translator->translate('OLA') . ' ' . $translator->translate('Time to own'),
        'linkfield' => 'olas_id_tto',
        'type'      => 'dropdown',
        // 'condition' => ['glpi_olas.type' => SLM::TTO],
      ],
      '_date_creation_calendars_id' => [
        'table'     => 'calendars',
        'field'     => 'name',
        'name'      => $translator->translate('Creation date is a working hour in calendar'),
        'linkfield' => '_date_creation_calendars_id',
        'type'      => 'dropdown',
      ],
    ];
  }
}
