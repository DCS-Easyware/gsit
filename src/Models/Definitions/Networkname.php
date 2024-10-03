<?php

namespace App\Models\Definitions;

class Networkname
{
  public static function getDefinition()
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
        'id'    => 12,
        'title' => $translator->translatePlural('Internet domain', 'Internet domains', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'fqdn',
        'dbname' => 'fqdn_id',
        'itemtype' => '\App\Models\Fqdn',
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
        'name'  => 'date_mod',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 121,
        'title' => $translator->translate('Creation date'),
        'type'  => 'datetime',
        'name'  => 'date_creation',
        'readonly'  => 'readonly',
      ],

      /*
       $tab[] = [
          'id'                 => '13',
          'table'              => 'glpi_ipaddresses',
          'field'              => 'name',
          'name'               => IPAddress::getTypeName(1),
          'joinparams'         => [
             'jointype'           => 'itemtype_item'
          ],
          'forcegroupby'       => true,
          'massiveaction'      => false,
          'datatype'           => 'dropdown'
       ];

       $tab[] = [
          'id'                 => '20',
          'table'              => $this->getTable(),
          'field'              => 'itemtype',
          'name'               => _n('Type', 'Types', 1),
          'datatype'           => 'itemtype',
          'massiveaction'      => false
       ];

       $tab[] = [
          'id'                 => '21',
          'table'              => $this->getTable(),
          'field'              => 'items_id',
          'name'               => __('ID'),
          'datatype'           => 'integer',
          'massiveaction'      => false
       ];
      */
    ];
  }

  public static function getRelatedPages()
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Network name', 'Network names', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Network alias', 'Network aliases', 1),
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
