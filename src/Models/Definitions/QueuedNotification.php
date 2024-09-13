<?php

namespace App\Models\Definitions;

class QueuedNotification
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'    => 1,
        'title' => $translator->translate('Subject'),
        'type'  => 'input',
        'name'  => 'name',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 20,
        'title' => $translator->translatePlural('Type', 'Types', 1),
        'type'  => 'input',
        'name'  => 'itemtype',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 22,
        'title' => $translator->translatePlural('Notification template', 'Notification templates', 1),
        'type'  => 'dropdown_remote',
        'name'  => 'notificationtemplate',
        'dbname' => 'notificationtemplates_id',
        'itemtype' => '\App\Models\NotificationTemplate',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 16,
        'title' => $translator->translate('Creation date'),
        'type'  => 'datetime',
        'name'  => 'create_time',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('Expected send date'),
        'type'  => 'datetime',
        'name'  => 'send_time',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Send date'),
        'type'  => 'datetime',
        'name'  => 'sent_time',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 15,
        'title' => $translator->translate('Number of tries of sent'),
        'type'  => 'input',
        'name'  => 'sent_try',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Sender email'),
        'type'  => 'input',
        'name'  => 'sender',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Sender name'),
        'type'  => 'input',
        'name'  => 'sendername',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Recipient email'),
        'type'  => 'input',
        'name'  => 'recipient',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 8,
        'title' => $translator->translate('Recipient name'),
        'type'  => 'input',
        'name'  => 'recipientname',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 9,
        'title' => $translator->translate('Reply-to email'),
        'type'  => 'input',
        'name'  => 'replyto',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 10,
        'title' => $translator->translate('Reply-to name'),
        'type'  => 'input',
        'name'  => 'replytoname',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 11,
        'title' => $translator->translate('Additional headers'),
        'type'  => 'input',
        'name'  => 'headers',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 14,
        'title' => $translator->translate('Message ID'),
        'type'  => 'input',
        'name'  => 'messageid',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 12,
        'title' => $translator->translate('Email HTML body'),
        'type'  => 'textarea',
        'name'  => 'body_html',
        'readonly'  => 'readonly',
      ],
      [
        'id'    => 13,
        'title' => $translator->translate('Email text body'),
        'type'  => 'textarea',
        'name'  => 'body_text',
        'readonly'  => 'readonly',
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
         'massiveaction'      => false,
         'datatype'           => 'number'
      ];


      $tab[] = [
         'id'                 => '21',
         'table'              => $this->getTable(),
         'field'              => 'items_id',
         'name'               => __('Associated item ID'),
         'massiveaction'      => false,
         'datatype'           => 'integer'
      ];

      $tab[] = [
         'id'                 => '23',
         'table'              => 'glpi_queuednotifications',
         'field'              => 'mode',
         'name'               => __('Mode'),
         'massiveaction'      => false,
         'datatype'           => 'specific',
         'searchtype'         => [
            0 => 'equals',
            1 => 'notequals'
         ]
      ];

      $tab[] = [
         'id'                 => '80',
         'table'              => 'glpi_entities',
         'field'              => 'completename',
         'name'               => Entity::getTypeName(1),
         'massiveaction'      => false,
         'datatype'           => 'dropdown'
      ];

      */
    ];
  }

  public static function getRelatedPages()
  {
    global $translator;
    return [
      // [
      //   'title' => $translator->translate('Historical'),
      //   'icon' => 'history',
      //   'link' => '',
      // ],
    ];
  }
}
