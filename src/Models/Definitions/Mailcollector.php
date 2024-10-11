<?php

namespace App\Models\Definitions;

class Mailcollector
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
        'id'    => 22,
        'title' => $translator->translate('Connection errors'),
        'type'  => 'input',
        'name'  => 'errors',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 2,
        'title' => $translator->translate('Active'),
        'type'  => 'boolean',
        'name'  => 'is_active',
      ],
      [
        'id'    => 20,
        'title' => $translator->translate('Accepted mail archive folder (optional)'),
        'type'  => 'input',
        'name'  => 'accepted',
      ],
      [
        'id'    => 21,
        'title' => $translator->translate('Refused mail archive folder (optional)'),
        'type'  => 'input',
        'name'  => 'refused',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Maximum size of each file imported by the mails receiver'),
        'type'  => 'dropdown',
        'name'  => 'filesize_max',
        'dbname'  => 'filesize_max',
        'values' => self::showMaxFilesize(),
      ],
      [
        'id'    => 201,
        'title' => $translator->translate('Use mail date, instead of collect one'),
        'type'  => 'boolean',
        'name'  => 'use_mail_date',
      ],
      [
        'id'    => 202,
        'title' => $translator->translate('Use Reply-To as requester (when available)'),
        'type'  => 'dropdown',
        'name'  => 'requester_field',
        'dbname'  => 'requester_field',
        'values' => self::getRequesterField(),
      ],
      [
        'id'    => 203,
        'title' => $translator->translate('Add CC users as observer'),
        'type'  => 'boolean',
        'name'  => 'add_cc_to_observer',
      ],
      [
        'id'    => 204,
        'title' => $translator->translate('Collect only unread mail'),
        'type'  => 'boolean',
        'name'  => 'collect_only_unread',
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
/*
      $tab[] = [
         'id'                 => '3',
         'table'              => $this->getTable(),
         'field'              => 'host',
         'name'               => __('Connection string'),
         'massiveaction'      => false,
         'datatype'           => 'string'
      ];

      $tab[] = [
         'id'                 => '4',
         'table'              => $this->getTable(),
         'field'              => 'login',
         'name'               => __('Login'),
         'massiveaction'      => false,
         'datatype'           => 'string',
         'autocomplete'       => true,
      ];

*/
    ];
  }

  public static function showMaxFilesize()
  {
    global $translator;


    $tab[0]['title'] = $translator->translate('No import');
    for ($index=1; $index<100; $index++) {
      $tab[$index*1048576]['title'] = sprintf($translator->translate('%s Mio'), $index);
    }

    return $tab;
 }

 public static function getRequesterField()
 {
   global $translator;
   return [
    0 => [
      'title' => $translator->translate('No'),
    ],
    1 => [
      'title' => $translator->translate('Yes'),
    ],
  ];
}

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Wifi network', 'Wifi networks', 1),
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
