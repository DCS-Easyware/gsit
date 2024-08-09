<?php

namespace App\Models\Definitions;


class Software
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
        'id'    => 16,
        'title' => $translator->translate('Comments'),
        'type'  => 'input',
        'name'  => 'comment',
      ],
      [
        'id'    => 62,
        'title' => $translator->translate('Category'),
        'type'  => 'dropdown_remote',
        'name'  => 'category',
        'dbname' => 'softwarecategories_id',
        'itemtype' => '\App\Models\Softwarecategory',
      ],
      [
        'id'    => 23,
        'title' => $translator->translate('Publisher'),
        'type'  => 'dropdown_remote',
        'name'  => 'manufacturer',
        'dbname' => 'manufacturers_id',
        'itemtype' => '\App\Models\Manufacturer',
      ],
      // [
      //   'id'    => 24,
      //   'title' => $translator->translate('Technician in charge of the software'),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'users_id_tech',
      //   'itemtype' => '\App\Models\User',
      // ],
      // [
      //   'id'    => 49,
      //   'title' => $translator->translate('Group in charge of the software'),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'groups_id_tech',
      //   'itemtype' => '\App\Models\Group',
      // ],
      // [
      //   'id'    => 70,
      //   'title' => $translator->translatePlural('User', 'Users', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'users_id',
      //   'itemtype' => '\App\Models\User',
      // ],
      // [
      //   'id'    => 71,
      //   'title' => $translator->translatePlural('Group', 'Groups', 1),
      //   'type'  => 'dropdown_remote',
      //   'name'  => 'groups_id',
      //   'itemtype' => '\App\Models\Group',
      // ],
      [
        'id'    => 72,
        'title' => $translator->translate('Number of installations'),
        'type'  => 'dropdown_remote',
        'name'  => 'nbinstallation',
        // 'dbname' => 'id',
        'itemtype' => '\App\Models\Softwareversion',
        'count' => 'devices_count',
      ],
      [
        'id'    => 5,
        'title' => $translator->translate('Versions'),
        'type'  => 'dropdown_remote',
        'name'  => 'versions',
        // 'dbname' => 'id',
        'itemtype' => '\App\Models\Softwareversion',
        'multiple' => true,
      ],
    ];
  }

  public static function getRelatedPages($rootUrl)
  {
    global $translator;

    return [
      // [
      //   'title' => $translator->translatePlural('Operating system', 'Operating systems', 1),
      //   'icon' => 'laptop house',
      //   'link' => $rootUrl.'/operatingsystem',
      // ],

    ];
  }
}
