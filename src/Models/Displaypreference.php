<?php

namespace App\Models;


class Displaypreference extends Common
{
  protected $table = 'glpi_displaypreferences';

  /**
   * Get display preference for a user for an itemtype
   *
   * @param string  $itemtype  itemtype
   * @param integer $user_id   user ID
   *
   * @return array
  **/
  static function getForTypeUser($itemtype, $user_id) {
    $items = \App\Models\Displaypreference::where('itemtype', $itemtype)
      ->where('users_id', 0)->get();

    $default_prefs = [];
    foreach ($items as $myItem)
    {
      $default_prefs[] = $myItem->num;
    }
    return $default_prefs;

    // global $DB;

    // $iterator = $DB->request([
    //    'FROM'   => 'glpi_displaypreferences',
    //    'WHERE'  => [
    //       'itemtype'  => $itemtype,
    //       'OR'        => [
    //          ['users_id' => $user_id],
    //          ['users_id' => 0]
    //       ]
    //    ],
    //    'ORDER'  => ['users_id', 'rank']
    // ]);

    // $default_prefs = [];
    // $user_prefs = [];

    // while ($data = $iterator->next()) {
    //    if ($data["users_id"] != 0) {
    //       $user_prefs[] = $data["num"];    global $DB;

  //   $iterator = $DB->request([
  //     'FROM'   => 'glpi_displaypreferences',
  //     'WHERE'  => [
  //        'itemtype'  => $itemtype,
  //        'OR'        => [
  //           ['users_id' => $user_id],
  //           ['users_id' => 0]
  //        ]
  //     ],
  //     'ORDER'  => ['users_id', 'rank']
  //  ]);

  //  $default_prefs = [];
  //  $user_prefs = [];

  //  while ($data = $iterator->next()) {
  //     if ($data["users_id"] != 0) {
  //        $user_prefs[] = $data["num"];
  //     } else {
  //        $default_prefs[] = $data["num"];
  //     }
  //  }

  //  return count($user_prefs) ? $user_prefs : $default_prefs;

    //    } else {
    //       $default_prefs[] = $data["num"];
    //    }
    // }

    // return count($user_prefs) ? $user_prefs : $default_prefs;
 }
}
