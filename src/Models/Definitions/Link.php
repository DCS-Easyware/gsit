<?php

namespace App\Models\Definitions;

class Link
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 101,
        'title' => $translator->translate('Valid tags'),
        'type'  => 'description',
        'name'  => 'description',
        'values' => self::getValidTags(),
      ],
      [
        'id'    => 1,
        'title' => $translator->translate('Name'),
        'type'  => 'input',
        'name'  => 'name',
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('Link or filename'),
        'type'  => 'input',
        'name'  => 'link',
      ],
      [
        'id'    => 103,
        'title' => $translator->translate('Open in a new window'),
        'type'  => 'boolean',
        'name'  => 'open_window',
      ],
      [
        'id'    => 104,
        'title' => $translator->translate('File content'),
        'type'  => 'textarea',
        'name'  => 'data',
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
    ];
  }

  public static function getValidTags()
    {
    global $translator;

    $tags = ['[LOGIN]', '[ID]', '[NAME]', '[LOCATION]', '[LOCATIONID]', '[IP]',
    '[MAC]', '[NETWORK]', '[DOMAIN]', '[SERIAL]', '[OTHERSERIAL]',
    '[USER]', '[GROUP]', '[REALNAME]', '[FIRSTNAME]'];

    $ret = '';

    $count = count($tags);
    $i = 0;

    foreach ($tags as $tag) {
      $ret = $ret . $tag;
      $ret = $ret . "&nbsp;";
      $i++;
      if (($i%8 == 0) && ($count > 1)) {
        $ret = $ret . "<br>";
      }
    }

    $ret = $ret . "<br>" . $translator->translate('or') . "<br>[FIELD:<i>" . $translator->translate('field name in DB') . "</i>] (" . $translator->translate('Example:') . " [FIELD:name], [FIELD:content], ...)";

    return $ret;
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('External link', 'External links', 1),
        'icon' => 'caret square down outline',
        'link' => '',
      ],
      [
        'title' => $translator->translatePlural('Associated item type', 'Associated item types', 2),
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
