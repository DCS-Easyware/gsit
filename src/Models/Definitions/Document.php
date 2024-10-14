<?php

namespace App\Models\Definitions;

class Document
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
        'id'    => 7,
        'title' => $translator->translate('Heading'),
        'type'  => 'dropdown_remote',
        'name'  => 'categorie',
        'dbname' => 'documentcategory_id',
        'itemtype' => '\App\Models\Documentcategory',
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('File'),
        'type'  => 'input',
        'name'  => 'filename',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Web link'),
        'type'  => 'input',
        'name'  => 'link',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('MIME type'),
        'type'  => 'input',
        'name'  => 'mime',
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Tag'),
        'type'  => 'input',
        'name'  => 'tag',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 20,
        'title' => sprintf(
          $translator->translate('%1$s (%2$s)'),
          $translator->translate('Checksum'),
          $translator->translate('SHA1')
        ),
        'type'  => 'input',
        'name'  => 'sha1sum',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
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
        'id'                 => '2',
        'table'              => $this->getTable(),
        'field'              => 'id',
        'name'               => __('ID'),
        'massiveaction'      => false,
        'datatype'           => 'number'
      ];

      $tab[] = [
        'id'                 => '72',
        'table'              => 'glpi_documents_items',
        'field'              => 'id',
        'name'               => _x('quantity', 'Number of associated items'),
        'forcegroupby'       => true,
        'usehaving'          => true,
        'datatype'           => 'count',
        'massiveaction'      => false,
        'joinparams'         => [
        'jointype'           => 'child'
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
        'title' => $translator->translatePlural('Document', 'Documents', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Associated item', 'Associated items', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Document', 'Documents', 2),
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
