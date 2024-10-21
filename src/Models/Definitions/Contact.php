<?php

namespace App\Models\Definitions;

class Contact
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 1,
        'title' => $translator->translate('Last name'),
        'type'  => 'input',
        'name'  => 'name',
        'fillable' => true,
      ],
      [
        'id'    => 11,
        'title' => $translator->translate('First name'),
        'type'  => 'input',
        'name'  => 'firstname',
        'fillable' => true,
      ],
      [
        'id'    => 3,
        'title' => $translator->translatePlural('Phone', 'Phones', 1),
        'type'  => 'input',
        'name'  => 'phone',
        'fillable' => true,
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Phone 2'),
        'type'  => 'input',
        'name'  => 'phone2',
        'fillable' => true,
      ],
      [
        'id'    => 10,
        'title' => $translator->translate('Mobile phone'),
        'type'  => 'input',
        'name'  => 'mobile',
        'fillable' => true,
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Fax'),
        'type'  => 'input',
        'name'  => 'fax',
        'fillable' => true,
      ],
      [
        'id'    => 6,
        'title' => $translator->translatePlural('Email', 'Emails', 1),
        'type'  => 'email',
        'name'  => 'email',
        'fillable' => true,
      ],
      [
        'id'    => 82,
        'title' => $translator->translate('Address'),
        'type'  => 'textarea',
        'name'  => 'address',
        'fillable' => true,
      ],
      [
        'id'    => 83,
        'title' => $translator->translate('Postal code'),
        'type'  => 'input',
        'name'  => 'postcode',
        'fillable' => true,
      ],
      [
        'id'    => 84,
        'title' => $translator->translate('City'),
        'type'  => 'input',
        'name'  => 'town',
        'fillable' => true,
      ],
      [
        'id'    => 85,
        'title' => $translator->translate('location' . "\004" . 'State'),
        'type'  => 'input',
        'name'  => 'state',
        'fillable' => true,
      ],
      [
        'id'    => 87,
        'title' => $translator->translate('Country'),
        'type'  => 'input',
        'name'  => 'country',
        'fillable' => true,
      ],
      [
        'id'    => 9,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'type',
        'dbname' => 'contacttype_id',
        'itemtype' => '\App\Models\Contacttype',
        'fillable' => true,
      ],
      [
        'id'    => 119,
        'title' => $translator->translate('person' . "\004" . 'Title'),
        'type'  => 'dropdown_remote',
        'name'  => 'title',
        'dbname' => 'usertitle_id',
        'itemtype' => '\App\Models\Usertitle',
        'fillable' => true,
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
        'fillable' => true,
      ],
      // [
      //   'id'    => 80,
      //   'title' => $translator->translatePlural('Entity', 'Entities', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'completename',
      //   'itemtype' => '\App\Models\Entity',
      // ],
      [
        'id'    => 86,
        'title' => $translator->translate('Child entities'),
        'type'  => 'boolean',
        'name'  => 'is_recursive',
        'fillable' => true,
      ],
      [
        'id'    => 19,
        'title' => $translator->translate('Last update'),
        'type'  => 'datetime',
        'name'  => 'updated_at',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 121,
        'title' => $translator->translate('Creation date'),
        'type'  => 'datetime',
        'name'  => 'created_at',
        'readonly'  => 'readonly',
      ],


      /*
      $tab[] = [
        'id'                 => 'common',
        'name'               => __('Characteristics')
      ];

      $tab[] = [
        'id'                 => '8',
        'table'              => 'glpi_suppliers',
        'field'              => 'name',
        'name'               => _n('Associated supplier', 'Associated suppliers', Session::getPluralNumber()),
        'forcegroupby'       => true,
        'datatype'           => 'itemlink',
        'joinparams'         => [
        'beforejoin'         => [
        'table'              => 'glpi_contacts_suppliers',
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
        'title' => $translator->translatePlural('Contact', 'Contacts', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Supplier', 'Suppliers', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Document', 'Documents', 2),
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
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => '',
      ],
    ];
  }
}
