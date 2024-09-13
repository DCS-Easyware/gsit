<?php

namespace App\Models\Definitions;

class DocumentType
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
        'title' => $translator->translate('Extension'),
        'type'  => 'input',
        'name'  => 'ext',
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
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Authorized upload'),
        'type'  => 'boolean',
      'name'  => 'is_uploadable',
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
    ];
  }

  public static function getRelatedPages()
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
