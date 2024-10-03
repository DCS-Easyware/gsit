<?php

namespace App\Models\Definitions;

class FormcreatorCategory
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
        'title' => $translator->translate('Knowbase category'),
        'type'  => 'dropdown_remote',
        'name'  => 'knowbaseitemcategory',
        'dbname' => 'knowbaseitemcategory_id',
        'itemtype' => '\App\Models\Knowbaseitemcategory',
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('As child of'),
        'type'  => 'dropdown_remote',
        'name'  => 'category',
        'dbname' => 'plugin_formcreator_categories_id',
        'itemtype' => '\App\Models\FormcreatorCategory',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
    ];
  }

  public static function getRelatedPages()
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Form category', 'Form categories', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Form category', 'Form categories', 2),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Icon'),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
    ];
  }
}
