<?php

namespace App\Models\Definitions;

class Documenttype
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
        'fillable' => true,
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('Extension'),
        'type'  => 'input',
        'name'  => 'ext',
        'fillable' => true,
      ],
      // [
      //   'id'    => 6,
      //   'title' => $translator->translate('Icon'),
      //   'type'  => 'input',
      //   'name'  => 'icon',
      // ],
      [
        'id'    => 4,
        'title' => $translator->translate('MIME type'),
        'type'  => 'input',
        'name'  => 'mime',
        'fillable' => true,
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Authorized upload'),
        'type'  => 'boolean',
        'name'  => 'is_uploadable',
        'fillable' => true,
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
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
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Document type', 'Document types', 1),
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
