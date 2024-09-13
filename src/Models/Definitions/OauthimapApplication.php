<?php

namespace App\Models\Definitions;

class OauthimapApplication
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
        'id'    => 205,
        'title' => $translator->translate('Active'),
        'type'  => 'boolean',
        'name'  => 'is_active',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Oauth provider'),
        'type'  => 'input',
        'name'  => 'provider',
      ],
      [
        'id'    => 6,
        'title' => $translator->translate('Client ID'),
        'type'  => 'input',
        'name'  => 'client_id',
      ],
      [
        'id'    => 7,
        'title' => $translator->translate('Tenant ID'),
        'type'  => 'input',
        'name'  => 'tenant_id',
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
        'title' => $translator->translatePlural('Oauth IMAP application', 'Oauth IMAP applications', 1),
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
