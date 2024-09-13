<?php

namespace App\Models\Definitions;

class Form
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
        'id'    => 30,
        'title' => $translator->translate('Active'),
        'type'  => 'boolean',
        'name'  => 'is_active',
      ],
      [
        'id'    => 13,
        'title' => $translator->translate('Category'),
        'type'  => 'dropdown_remote',
        'name'  => 'category',
        'dbname' => 'plugin_formcreator_categories_id',
        'itemtype' => '\App\Models\FormCategory',
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Description'),
        'type'  => 'input',
        'name'  => 'description',
      ],
      // [
      //   'id'    => 5,
      //   'title' => $translator->translate('Entity'),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'completename',
      //   'itemtype' => '\App\Models\Entity',
      // ],
      [
        'id'    => 6,
        'title' => $translator->translate('Recursive'),
        'type'  => 'boolean',
        'name'  => 'is_recursive',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Direct access on homepage'),
        'type'  => 'boolean',
        'name'  => 'helpdesk_home',
      ],
      [
        'id'    => 204,
        'title' => $translator->translatePlural('Header', 'Headers', 1),
        'type'  => 'textarea',
        'name'  => 'content',
      ],
      [
        'id'    => 205,
        'title' => $translator->translate('Need to be validate?'),
        'type'  => 'dropdown',
        'name'  => 'validation_required',
        'dbname'  => 'validation_required',
        'values' => self::getTypeValidationArray(),
      ],
      [
        'id'    => 206,
        'title' => $translator->translate('Default form in service catalog'),
        'type'  => 'boolean',
        'name'  => 'is_default',
      ],

      /*
      $tab[] = [
        'id'                 => 'common',
        'name'               => __('Characteristics')
      ];

      $tab[] = [
        'id'                 => '2',
        'table'              => $this->getTable(),
        'field'              => 'id',
        'name'               => __('ID'),
        'searchtype'         => 'contains',
        'massiveaction'      => false
      ];

      $tab[] = [
        'id'                 => '7',
        'table'              => $this->getTable(),
        'field'              => 'language',
        'name'               => __('Language'),
        'datatype'           => 'specific',
        'searchtype'         => [
        '0'                  => 'equals'
        ],
        'massiveaction'      => true
      ];

      $tab[] = [
        'id'                 => '9',
        'table'              => $this->getTable(),
        'field'              => 'access_rights',
        'name'               => __('Access', 'formcreator'),
        'datatype'           => 'specific',
        'searchtype'         => [
        '0'                  => 'equals',
        '1'                  => 'notequals'
        ],
        'massiveaction'      => true
      ];

      $tab[] = [
        'id'                 => '10',
        'table'              => 'glpi_plugin_formcreator_categories',
        'field'              => 'name',
        'name'               => __('Form category', 'formcreator'),
        'datatype'           => 'dropdown',
        'massiveaction'      => true
      ];

      $tab[] = [
        'id'                 => '31',
        'table'              => $this->getTable(),
        'field'              => 'icon',
        'name'               => __('Icon', 'formcreator'),
        'massiveaction'      => false
      ];

      $tab[] = [
        'id'                 => '32',
        'table'              => $this->getTable(),
        'field'              => 'icon_color',
        'name'               => __('Icon color', 'formcreator'),
        'massiveaction'      => false
      ];

      $tab[] = [
        'id'                 => '33',
        'table'              => $this->getTable(),
        'field'              => 'background_color',
        'name'               => __('Background color', 'formcreator'),
        'massiveaction'      => false
      ];
      */
    ];
  }

  public static function getTypeValidationArray()
  {
    global $translator;
    return [
      0 => [
        'title' => '-----',
      ],
      1 => [
        'title' => $translator->translatePlural('User', 'Users', 1),
      ],
      2 => [
        'title' => $translator->translatePlural('Group', 'Groups', 1),
      ],
    ];
  }

  public static function getRelatedPages($rootUrl)
    {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Form', 'Forms', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Questions', 'Questions', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Access type', 'Access types', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Target', 'Targets', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Preview'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Form answer', 'Form answers', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Boutique'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
    ];
  }
}
