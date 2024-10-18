<?php

namespace App\Models\Definitions\Forms;

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
        'id'    => 2,
        'title' => $translator->translatePlural('Header', 'Headers', 1),
        'type'  => 'textarea',
        'name'  => 'content',
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('Description'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Category'),
        'type'  => 'dropdown_remote',
        'name'  => 'category',
        'dbname' => 'category_id',
        'itemtype' => '\App\Models\Category',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Active'),
        'type'  => 'dropdown',
        'name'  => 'is_active',
        'dbname'  => 'is_active',
        'values' => self::getIsActive(),
      ],
      // [
      //   'id'    => 6,
      //   'title' => $translator->translatePlural('Entity', 'Entities', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'completename',
      //   'itemtype' => '\App\Models\Entity',
      // ],
      [
        'id'    => 7,
        'title' => $translator->translate('Child entities'),
        'type'  => 'dropdown',
        'name'  => 'is_recursive',
        'dbname'  => 'is_recursive',
        'values' => self::getIsRecursive(),
      ],
      [
        'id'    => 9,
        'title' => $translator->translate('Default form in service catalog'),
        'type'  => 'dropdown',
        'name'  => 'is_homepage',
        'dbname'  => 'is_homepage',
        'values' => self::getIsHomepage(),
      ],
      [
        'id'    => 10,
        'title' => $translator->translate('Icon'),
        'type'  => 'input',
        'name'  => 'icon',
      ],
      [
        'id'    => 11,
        'title' => $translator->translate('Icon color'),
        'type'  => 'input',
        'name'  => 'icon_color',
      ],
      [
        'id'    => 15,
        'title' => $translator->translate('Creation date'),
        'type'  => 'datetime',
        'name'  => 'date_creation',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Last update'),
        'type'  => 'datetime',
        'name'  => 'date_mod',
        'readonly'  => 'readonly',
      ],
    ];
  }

  public static function getIsActive()
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

  public static function getIsRecursive()
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

  public static function getIsHomepage()
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
        'title' => $translator->translatePlural('Form', 'Forms', 1),
        'icon' => 'caret square down outline',
        'link' => $rootUrl,
      ],
      [
        'title' => $translator->translatePlural('Section', 'Sections', 2),
        'icon' => 'caret square down outline',
        'link' => $rootUrl . '/sections',
      ],
      [
        'title' => $translator->translatePlural('Question', 'Questions', 2),
        'icon' => 'caret square down outline',
        'link' => $rootUrl . '/questions',
      ],
      // [
      //   'title' => $translator->translatePlural('Access type', 'Access types', 2),
      //   'icon' => 'caret square down outline',
      //   'link' => '',
      // ],
      // [
      //   'title' => $translator->translatePlural('Target', 'Targets', 2),
      //   'icon' => 'caret square down outline',
      //   'link' => '',
      // ],
      // [
      //   'title' => $translator->translate('Preview'),
      //   'icon' => 'caret square down outline',
      //   'link' => '',
      // ],
      // [
      //   'title' => $translator->translatePlural('Form answer', 'Form answers', 1),
      //   'icon' => 'caret square down outline',
      //   'link' => '',
      // ],
      [
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => '',
      ],
      // [
      //   'title' => $translator->translate('Boutique'),
      //   'icon' => 'caret square down outline',
      //   'link' => '',
      // ],
    ];
  }
}
