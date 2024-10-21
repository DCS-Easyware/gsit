<?php

namespace App\Models\Definitions\Forms;

class Question
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
        'title' => $translator->translate('Description'),
        'type'  => 'textarea',
        'name'  => 'comment',
      ],
      [
        'id'    => 3,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'dropdown',
        'name'  => 'fieldtype',
        'dbname'  => 'fieldtype',
        'values' => self::getFieldtype(),
      ],
      [
        'id'    => 4,
        'title' => $translator->translatePlural('Mandatory field', 'Mandatory fields', 1),
        'type'  => 'dropdown',
        'name'  => 'is_required',
        'dbname'  => 'is_required',
        'values' => self::getIsRequired(),
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Show empty'),
        'type'  => 'dropdown',
        'name'  => 'show_empty',
        'dbname'  => 'show_empty',
        'values' => self::getIsRequired(),
      ],
      [
        'id'    => 6,
        'title' => sprintf(
          '%1$s <small>(%2$s)</small>',
          $translator->translate('Default values'),
          $translator->translate('One per line')
        ),
        'type'  => 'textarea',
        'name'  => 'default_values',
      ],
      [
        'id'    => 7,
        'title' => sprintf(
          '%1$s <small>(%2$s)</small>',
          $translator->translatePlural('Value', 'Values', 2),
          $translator->translate('One per line')
        ),
        'type'  => 'textarea',
        'name'  => 'values',
      ],
      [
        'id'    => 8,
        'title' => sprintf(
          '%1$s (%2$s)',
          $translator->translate('Size'),
          $translator->translate('Min')
        ),
        'type'  => 'input',
        'name'  => 'range_min',
      ],
      [
        'id'    => 9,
        'title' => sprintf(
          '%1$s (%2$s)',
          $translator->translate('Size'),
          $translator->translate('Max')
        ),
        'type'  => 'input',
        'name'  => 'range_max',
      ],
      [
        'id'    => 10,
        'title' => sprintf(
          '%1$s <small><a href="http://php.net/manual/reference.pcre.pattern.syntax.php" target="_blank">(%2$s)</a></small>',
          $translator->translate('Additional validation'),
          $translator->translate('Regular expression')
        ),
        'type'  => 'input',
        'name'  => 'regex',
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

  public static function getFieldtype()
  {
    global $translator;
    return [
      'checkbox' => [
        'title' => $translator->translate('Checkboxes'),
      ],
      'radio' => [
        'title' => $translator->translate('Radios'),
      ],
      'hidden' => [
        'title' => $translator->translatePlural('Hidden field', 'Hidden fields', 1),
      ],
      'email' => [
        'title' => $translator->translatePlural('Email', 'Emails', 1),
      ],
      'date' => [
        'title' => $translator->translatePlural('Date', 'Dates', 1),
      ],
      'description' => [
        'title' => $translator->translate('Description'),
      ],
      'integer' => [
        'title' => $translator->translate('Integer'),
      ],
      'file' => [
        'title' => $translator->translate('File'),
      ],
      'float' => [
        'title' => $translator->translate('Float'),       // regexp
      ],
      'time' => [
        'title' => $translator->translate('hour' . "\004" . 'Time'),
      ],
      'dropdown' => [
        'title' => $translator->translatePlural('Dropdown', 'Dropdowns', 1),   // intitules (dropdown)
      ],
      'glpiselect' => [
        'title' => $translator->translatePlural('GLPI object', 'GLPI objects', 1),
      ],
      'select' => [
        'title' => $translator->translate('Select'),
      ],
      'multiselect' => [
        'title' => $translator->translate('Multiselect'),
      ],
      'text' => [
        'title' => $translator->translate('Text'),
      ],
      'urgency' => [
        'title' => $translator->translate('Urgency'),
      ],
      'textarea' => [
        'title' => $translator->translate('Textarea'),
      ],
    ];
  }

  public static function getIsRequired()
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
        'title' => $translator->translatePlural('Question', 'Questions', 2),
        'icon' => 'caret square down outline',
        'link' => $rootUrl,
      ],
      [
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => '',
      ],
    ];
  }
}
