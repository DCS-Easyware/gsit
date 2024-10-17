<?php

namespace App\Models\Definitions;

class Authsso
{
  public static function getDefinition()
  {
    global $translator;
    return [
      [
        'id'            => 1,
        'title'         => $translator->translate('Name'),
        'type'          => 'input',
        'name'          => 'name',
        'fillable' => true,
      ],
      [
        'id'    => 3,
        'title' => $translator->translate('Comments'),
        'type'  => 'textarea',
        'name'  => 'comment',
        'fillable' => true,
      ],
      [
        'id'    => 4,
        'title' => $translator->translate('Active'),
        'type'  => 'boolean',
        'name'  => 'is_active',
        'fillable' => true,
      ],
      [
        'id'            => 5,
        'title'         => $translator->translate('Provider'),
        'type'          => 'dropdown',
        'name'          => 'provider',
        'values'        => self::getProviderArray(),
        'fillable' => true,
      ],
      [
        'id'            => 6,
        'title'         => $translator->translate('callback id'),
        'type'          => 'input',
        'name'          => 'callbackid',
      ],
      [
        'id'            => 7,
        'title'         => $translator->translate('application id'),
        'type'          => 'input',
        'name'          => 'applicationid',
        'fillable' => true,
      ],
      [
        'id'            => 8,
        'title'         => $translator->translate('application secret'),
        'type'          => 'inputpassword',
        'name'          => 'applicationsecret',
        'fillable' => true,
      ],
      [
        'id'            => 9,
        'title'         => $translator->translate('application public'),
        'type'          => 'input',
        'name'          => 'applicationpublic',
        'fillable' => true,
      ],
      [
        'id'            => 10,
        'title'         => $translator->translate('directory id'),
        'type'          => 'input',
        'name'          => 'directoryid',
        'fillable' => true,
      ],
      [
        'id'            => 11,
        'title'         => $translator->translate('baseurl'),
        'type'          => 'input',
        'name'          => 'baseurl',
        'fillable' => true,
      ],
      [
        'id'            => 12,
        'title'         => $translator->translate('realm'),
        'type'          => 'input',
        'name'          => 'realm',
        'fillable' => true,
      ],
    ];
  }

  public static function getProviderArray()
  {
    global $translator;

    return [
      'facebook' => [
        'title' => 'Facebook',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
          'options',
        ],
        'default_scope' => [
          'email',
        ],
        'default_options' => [
          'email',
          'name',
          'picture.width(99999)',
        ],
        'suboption' => 'identity.fields',
      ],
      'twitter' => [
        'title' => 'Twitter',
        'fields' => [
          'applicationId',
          'applicationSecret',
        ],
      ],
      'google' => [
        'title' => 'Google',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
          'options',
        ],
        'default_scope' => [
          'https://www.googleapis.com/auth/userinfo.email',
          'https://www.googleapis.com/auth/userinfo.profile'
        ],
        'default_options' => [
          'hd' => 'domain.tld',
        ],
        'suboption' => 'auth.parameters',
      ],
      'paypal' => [
        'title' => 'Paypal',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
          'profile',
          'email',
          'address',
          'phone',
          'https://uri.paypal.com/services/paypalattributes'
        ],
      ],
      'vk' => [
        'title' => 'VK',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'options',
        ],
        'default_options' => [
          'sex',
          'screen_name',
          'photo_max_orig',
        ],
        'suboption' => 'identity.fields',
      ],
      'github' => [
        'title' => 'Github',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
          'options',
        ],
        'default_scope' => [
          'user',
          'email',
        ],
        'default_options' => [
          'fetch_emails' => true
        ],
      ],
      'instagram' => [
        'title' => 'Instagram',
        'fields' => [
          'applicationId',
          'applicationSecret',
        ],
      ],
      'slack' => [
        'title' => 'Slack',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
          'identity.basic',
          'identity.email',
          'identity.team',
          'identity.avatar',
        ],
      ],
      'twitch' => [
        'title' => 'Twitch',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
          'user_read',
        ],
      ],
      'px500' => [
        'title' => 'px500',
        'fields' => [
          'applicationId',
          'applicationSecret',
        ],
      ],
      'bitbucket' => [
        'title' => 'Bitbucket',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
          'account',
        ],
      ],
      'amazon' => [
        'title' => 'Amazon',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
          'profile',
        ],
      ],
      'gitlab' => [
        'title' => 'Gitlab',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
          'read_user',
        ],
      ],
      'vimeo' => [
        'title' => 'Vimeo',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
        ],
      ],
      'digital-ocean' => [
        'title' => 'Digital Ocean',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
        ],
      ],
      'yandex' => [
        'title' => 'Yandex',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
        ],
      ],
      'mail-ru' => [
        'title' => 'Mail RU',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
        ],
      ],
      'odnoklassniki' => [
        'title' => 'odnoklassniki',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'applicationPublic',
          'scope',
        ],
        'default_scope' => [
          'GET_EMAIL'
        ],
      ],
      'steam' => [
        'title' => 'Steam',
        'fields' => [
          'applicationId',
        ],
      ],
      'tumblr' => [
        'title' => 'Tumblr',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
        ],
      ],
      'pixelpin' => [
        'title' => 'Pixelpin',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
          'email'
        ],
      ],
      'discord' => [
        'title' => 'Discord',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
          'identify',
          'email'
        ],
      ],
      'microsoft' => [
        'title' => 'Microsoft',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
          'wl.basic',
          'wl.birthday',
          'wl.emails'
        ],
      ],
      'azure-ad' => [
        'title' => 'Azure AD',
        'fields' => [
          'applicationId',
          'directoryId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
          'openid',
          'profile',
          'email'
        ],
      ],
      'smashcast' => [
        'title' => 'Smashcast',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
        ],
      ],
      'steein' => [
        'title' => 'Steein',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
          'users',
          'email'
        ],
      ],
      'reddit' => [
        'title' => 'Reddit',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
          'identity'
        ],
      ],
      'linkedin' => [
        'title' => 'Linkedin',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
          'options',
        ],
        'default_scope' => [
          'r_liteprofile',
          'r_emailaddress',
        ],
        'default_options' => [
          'fetch_emails' => true,
        ],
      ],
      'yahoo' => [
        'title' => 'Yahoo',
        'fields' => [
          'applicationId',
          'applicationSecret',
        ],
      ],
      'wordpress' => [
        'title' => 'Wordpress',
        'fields' => [
          'applicationId',
          'applicationSecret',
        ],
      ],
      'trello' => [
        'title' => 'Trello',
        'fields' => [
          'applicationId',
          'applicationSecret',
          'scope',
          'options',
        ],
        'default_scope' => [
          'read',
        ],
        'default_options' => [
          'name' => 'My Awesome App',
          'expiration' => '1day',
        ],
      ],
      'keycloak' => [
        'title' => 'Keycloak',
        'fields' => [
          'baseUrl',
          'realm',
          'applicationId',
          'applicationSecret',
          'scope',
        ],
        'default_scope' => [
          'email',
          'profile',
        ],
      ],
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;
    return [
      [
        'title' => $translator->translatePlural('Auth SSO', 'Auth SSO', 1),
        'icon' => 'home',
        'link' => $rootUrl,
      ],
      [
        'title' => $translator->translate('Scopes'),
        'icon' => 'list',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Options'),
        'icon' => 'filter',
        'link' => '',
      ],
      [
        'title' => $translator->translate('Historical'),
        'icon' => 'history',
        'link' => $rootUrl . '/history',
      ],
    ];
  }
}
