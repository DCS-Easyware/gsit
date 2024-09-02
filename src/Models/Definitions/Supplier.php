<?php

namespace App\Models\Definitions;

class Supplier
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
        'id'    => 3,
        'title' => $translator->translate('Address'),
        'type'  => 'textarea',
        'name'  => 'address',
      ],
      [
        'id'    => 10,
        'title' => $translator->translate('Fax'),
        'type'  => 'input',
        'name'  => 'fax',
      ],
      [
        'id'    => 11,
        'title' => $translator->translate('City'),
        'type'  => 'input',
        'name'  => 'town',
      ],
      [
        'id'    => 14,
        'title' => $translator->translate('Postal code'),
        'type'  => 'input',
        'name'  => 'postcode',
      ],
      [
        'id'    => 12,
        'title' => $translator->translate('location'."\004".'State'),
        'type'  => 'input',
        'name'  => 'state',
      ],
      [
        'id'    => 13,
        'title' => $translator->translate('Country'),
        'type'  => 'input',
        'name'  => 'country',
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Website'),
        'type'  => 'input',
        'name'  => 'website',
      ],
      [
        'id'    => 5,
        'title' => $translator->translatePlural('Phone', 'Phones', 1),
        'type'  => 'input',
        'name'  => 'phonenumber',
      ],
      [
        'id'    => 6,
        'title' => $translator->translatePlural('Email', 'Emails', 1),
        'type'  => 'email',
        'name'  => 'email',
      ],
      [
        'id'    => 9,
        'title' => $translator->translatePlural('Third party type', 'Third party types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'type',
        'dbname' => 'suppliertypes_id',
        'itemtype' => '\App\Models\Suppliertype',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
      // [
      //   'id'    => 80,
      //   'title' => $translator->translate('Entity'),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'completename',
      //   'itemtype' => '\App\Models\Entity',
      // ],
      [
          'id'    => 86,
          'title' => $translator->translate('Child entities'),
          'type'  => 'boolean',
          'name'  => 'is_recursive',
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
         'id'                 => 'common',
         'name'               => __('Characteristics')
      ];

      if ($_SESSION["glpinames_format"] == User::FIRSTNAME_BEFORE) {
         $name1 = 'firstname';
         $name2 = 'name';
      } else {
         $name1 = 'name';
         $name2 = 'firstname';
      }

      $tab[] = [
         'id'                 => '8',
         'table'              => 'glpi_contacts',
         'field'              => 'completename',
         'name'               => _n('Associated contact', 'Associated contacts', Session::getPluralNumber()),
         'forcegroupby'       => true,
         'datatype'           => 'itemlink',
         'massiveaction'      => false,
         'computation'        => "CONCAT(".$DB->quoteName("TABLE.$name1").", ' ', ".$DB->quoteName("TABLE.$name2").")",
         'computationgroupby' => true,
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => 'glpi_contacts_suppliers',
               'joinparams'         => [
                  'jointype'           => 'child'
               ]
            ]
         ]
      ];



      $tab[] = [
         'id'                 => '29',
         'table'              => 'glpi_contracts',
         'field'              => 'name',
         'name'               => _n('Associated contract', 'Associated contracts', Session::getPluralNumber()),
         'forcegroupby'       => true,
         'datatype'           => 'itemlink',
         'massiveaction'      => false,
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => 'glpi_contracts_suppliers',
               'joinparams'         => [
                  'jointype'           => 'child'
               ]
            ]
         ]
      ];

      // add objectlock search options
      $tab = array_merge($tab, ObjectLock::rawSearchOptionsToAdd(get_class($this)));

      $tab = array_merge($tab, Notepad::rawSearchOptionsToAdd());

      */
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;

    return [
      [
        'title' => $translator->translatePlural('Supplier', 'Suppliers', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Contact', 'Contacts', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Contract', 'Contract', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Item', 'Items', 2),
        'icon' => 'desktop',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Document', 'Documents', 2),
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
        'title' => $translator->translatePlural('Note', 'Notes', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Knowledge base'),
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
