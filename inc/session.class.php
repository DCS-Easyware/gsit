<?php
/**
 * ---------------------------------------------------------------------
 * GLPI - Gestionnaire Libre de Parc Informatique
 * Copyright (C) 2015-2021 Teclib' and contributors.
 *
 * http://glpi-project.org
 *
 * based on GLPI - Gestionnaire Libre de Parc Informatique
 * Copyright (C) 2003-2014 by the INDEPNET Development Team.
 *
 * ---------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of GLPI.
 *
 * GLPI is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * GLPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 * ---------------------------------------------------------------------
 */

use Glpi\Event;

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

/**
 * Session Class
**/
class Session {

   // GLPI MODE
   const NORMAL_MODE       = 0;
   const TRANSLATION_MODE  = 1; // no more used
   const DEBUG_MODE        = 2;


   /**
    * Destroy the current session
    *
    * @return void
   **/
   static function destroy() {

      self::start();
      // Unset all of the session variables.
      session_unset();
      // destroy may cause problems (no login / back to login page)
      $_SESSION = [];
      // write_close may cause troubles (no login / back to login page)
   }



   /**
    * Init session for the user is defined
    *
    * @param Auth $auth Auth object to init session
    *
    * @return void
   **/
   static function init(Auth $auth) {
      global $CFG_GLPI;

      if ($auth->auth_succeded) {
         // Restart GLPI session : complete destroy to prevent lost datas
         $tosave = ['glpi_plugins', 'glpicookietest', 'glpicsrftokens',
                         'glpiskipMaintenance'];
         $save   = [];
         foreach ($tosave as $t) {
            if (isset($_SESSION[$t])) {
               $save[$t] = $_SESSION[$t];
            }
         }
         self::destroy();
         session_regenerate_id();
         self::start();
         $_SESSION = $save;
         $_SESSION['valid_id'] = session_id();
         // Define default time :
         $_SESSION["glpi_currenttime"] = date("Y-m-d H:i:s");

         // Normal mode for this request
         $_SESSION["glpi_use_mode"] = self::NORMAL_MODE;
         // Check ID exists and load complete user from DB (plugins...)
         if (isset($auth->user->fields['id'])
             && $auth->user->getFromDB($auth->user->fields['id'])) {

            if (!$auth->user->fields['is_deleted']
                && ($auth->user->fields['is_active']
                    && (($auth->user->fields['begin_date'] < $_SESSION["glpi_currenttime"])
                        || is_null($auth->user->fields['begin_date']))
                    && (($auth->user->fields['end_date'] > $_SESSION["glpi_currenttime"])
                        || is_null($auth->user->fields['end_date'])))) {
               $_SESSION["glpiID"]              = $auth->user->fields['id'];
               $_SESSION["glpifriendlyname"]    = $auth->user->getFriendlyName();
               $_SESSION["glpiname"]            = $auth->user->fields['name'];
               $_SESSION["glpirealname"]        = $auth->user->fields['realname'];
               $_SESSION["glpifirstname"]       = $auth->user->fields['firstname'];
               $_SESSION["glpidefault_entity"]  = $auth->user->fields['entities_id'];
               $_SESSION["glpiextauth"]         = $auth->extauth;
               $_SESSION["glpiauthtype"]        = $auth->user->fields['authtype'];
               $_SESSION["glpiroot"]            = $CFG_GLPI["root_doc"];
               $_SESSION["glpi_use_mode"]       = $auth->user->fields['use_mode'];
               $_SESSION["glpi_plannings"]      = importArrayFromDB($auth->user->fields['plannings']);
               $_SESSION["glpicrontimer"]       = time();
               // Default tab
               // $_SESSION['glpi_tab']=1;
               $_SESSION['glpi_tabs']           = [];
               $auth->user->computePreferences();
               foreach ($CFG_GLPI['user_pref_field'] as $field) {
                  if ($field == 'language' && isset($_POST['language']) && $_POST['language'] != '') {
                     $_SESSION["glpi$field"] = $_POST[$field];
                  } else if (isset($auth->user->fields[$field])) {
                     $_SESSION["glpi$field"] = $auth->user->fields[$field];
                  }
               }
               // Do it here : do not reset on each page, cause export issue
               if ($_SESSION["glpilist_limit"] > $CFG_GLPI['list_limit_max']) {
                  $_SESSION["glpilist_limit"] = $CFG_GLPI['list_limit_max'];
               }
               // Init not set value for language
               if (empty($_SESSION["glpilanguage"])) {
                  $_SESSION["glpilanguage"] = self::getPreferredLanguage();
               }
               $_SESSION['glpi_dropdowntranslations'] = DropdownTranslation::getAvailableTranslations($_SESSION["glpilanguage"]);

               self::loadLanguage();

               if ($auth->password_expired) {
                  $_SESSION['glpi_password_expired'] = 1;
                  // Do not init profiles, as user has to update its password to be able to use GLPI
                  return;
               }

               // glpiprofiles -> other available profile with link to the associated entities
               Plugin::doHook("init_session");

               self::initEntityProfiles(self::getLoginUserID());

               // Use default profile if exist
               if (isset($_SESSION['glpiprofiles'][$auth->user->fields['profiles_id']])) {
                  self::changeProfile($auth->user->fields['profiles_id']);

               } else { // Else use first
                  self::changeProfile(key($_SESSION['glpiprofiles']));
               }

               if (!Session::getCurrentInterface()) {
                  $auth->auth_succeded = false;
                  $auth->addToError(__("You don't have right to connect"));
               }

            } else {
               $auth->auth_succeded = false;
               $auth->addToError(__("You don't have access to this application because your account was deactivated or removed"));
            }

         } else {
            $auth->auth_succeded = false;
            $auth->addToError(__("You don't have right to connect"));
         }
      }
   }


   /**
    * Set the directory where are store the session file
    *
    * @return void
   **/
   static function setPath() {

      if (ini_get("session.save_handler") == "files"
          && session_status() !== PHP_SESSION_ACTIVE) {
         session_save_path(GLPI_SESSION_DIR);
      }
   }


   /**
    * Start the GLPI php session
    *
    * @return void
   **/
   static function start() {

      if (session_status() === PHP_SESSION_NONE) {
         // Force session to use cookies and prevent JS scripts to access to them
         ini_set('session.cookie_httponly', '1');
         ini_set('session.use_only_cookies', '1');

         session_name("glpi_".md5(realpath(GLPI_ROOT)));

         @session_start();
      }
      // Define current time for sync of action timing
      $_SESSION["glpi_currenttime"] = date("Y-m-d H:i:s");
   }


   /**
    * Get root entity name
    *
    * @since 0.84
    *
    * @return string
   **/
   function getRootEntityName() {

      if (isset($_SESSION['glpirootentityname'])) {
         return $_SESSION['glpirootentityname'];
      }

      $entity = new Entity();
      if ($entity->getFromDB(0)) {
         $_SESSION['glpirootentityname'] = $entity->fields['name'];
      } else {
         $_SESSION['glpirootentityname'] = 'No root entity / DB troubles';
      }
      return $_SESSION['glpirootentityname'];
   }


   /**
    * Is GLPI used in multi-entities mode?
    *
    * @return boolean
   **/
   static function isMultiEntitiesMode() {

      if (!isset($_SESSION['glpi_multientitiesmode'])) {
         if (countElementsInTable("glpi_entities") > 1) {
            $_SESSION['glpi_multientitiesmode'] = 1;
         } else {
            $_SESSION['glpi_multientitiesmode'] = 0;
         }
      }

      return $_SESSION['glpi_multientitiesmode'];
   }


   /**
    * Does user have right to see all entities?
    *
    * @since 9.3.2
    *
    * @return boolean
   **/
   static function canViewAllEntities() {
      // Command line can see all entities
      return (isCommandLine()
              || ((countElementsInTable("glpi_entities")) == count($_SESSION["glpiactiveentities"])));

   }


   /** Add an item to the navigate through search results list
    *
    * @param string  $itemtype Device type
    * @param integer $ID       ID of the item
   **/
   static function addToNavigateListItems($itemtype, $ID) {
      $_SESSION['glpilistitems'][$itemtype][] = $ID;
   }


   /** Initialise a list of items to use navigate through search results
    *
    * @param string $itemtype Device type
    * @param string $title    List title (default '')
   **/
   static function initNavigateListItems($itemtype, $title = "") {

      if (empty($title)) {
         $title = __('List');
      }
      $url = '';

      if (!isset($_SERVER['REQUEST_URI']) || (strpos($_SERVER['REQUEST_URI'], "tabs") > 0)) {
         if (isset($_SERVER['HTTP_REFERER'])) {
            $url = $_SERVER['HTTP_REFERER'];
         }

      } else {
         $url = $_SERVER['REQUEST_URI'];
      }

      $_SESSION['glpilisttitle'][$itemtype] = $title;
      $_SESSION['glpilistitems'][$itemtype] = [];
      $_SESSION['glpilisturl'][$itemtype]   = $url;
   }


   /**
    * Change active entity to the $ID one. Update glpiactiveentities session variable.
    * Reload groups related to this entity.
    *
    * @param integer|'All' $ID           ID of the new active entity ("all"=>load all possible entities)
    *                                    (default 'all')
    * @param boolean       $is_recursive Also display sub entities of the active entity? (false by default)
    *
    * @return boolean true on success, false on failure
   **/
   static function changeActiveEntities($ID = "all", $is_recursive = false) {

      $newentities = [];
      if (isset($_SESSION['glpiactiveprofile'])) {
         if ($ID === "all") {
            $ancestors = [];
            foreach ($_SESSION['glpiactiveprofile']['entities'] as $val) {
               $ancestors               = array_unique(array_merge(getAncestorsOf("glpi_entities",
                                                                                  $val['id']),
                                                                   $ancestors));
               $newentities[$val['id']] = $val['id'];

               if ($val['is_recursive']) {
                  $entities = getSonsOf("glpi_entities", $val['id']);
                  if (count($entities)) {
                     foreach ($entities as $key2 => $val2) {
                        $newentities[$key2] = $key2;
                     }
                  }
               }
            }

         } else {
            /// Check entity validity
            $ancestors = getAncestorsOf("glpi_entities", $ID);
            $ok        = false;
            foreach ($_SESSION['glpiactiveprofile']['entities'] as $val) {
               if (($val['id'] == $ID) || in_array($val['id'], $ancestors)) {
                  // Not recursive or recursive and root entity is recursive
                  if (!$is_recursive || $val['is_recursive']) {
                     $ok = true;
                  }
               }
            }
            if (!$ok) {
               return false;
            }

            $newentities[$ID] = $ID;
            if ($is_recursive) {
               $entities = getSonsOf("glpi_entities", $ID);
               if (count($entities)) {
                  foreach ($entities as $key2 => $val2) {
                     $newentities[$key2] = $key2;
                  }
               }
            }
         }
      }

      if (count($newentities) > 0) {
         $_SESSION['glpiactiveentities']           = $newentities;
         $_SESSION['glpiactiveentities_string']    = "'".implode("', '", $newentities)."'";
         $active                                   = reset($newentities);
         $_SESSION['glpiparententities']           = $ancestors;
         $_SESSION['glpiparententities_string']    = implode("', '", $ancestors);
         if (!empty($_SESSION['glpiparententities_string'])) {
            $_SESSION['glpiparententities_string'] = "'".$_SESSION['glpiparententities_string']."'";
         }
         // Active entity loading
         $_SESSION["glpiactive_entity"]           = $active;
         $_SESSION["glpiactive_entity_recursive"] = $is_recursive;
         $_SESSION["glpiactive_entity_name"]      = Dropdown::getDropdownName("glpi_entities",
                                                                              $active);
         $_SESSION["glpiactive_entity_shortname"] = getTreeLeafValueName("glpi_entities", $active);
         if ($is_recursive || $ID=="all") {
            //TRANS: %s is the entity name
            $_SESSION["glpiactive_entity_name"]      = sprintf(__('%1$s (%2$s)'),
                                                               $_SESSION["glpiactive_entity_name"],
                                                               __('tree structure'));
            $_SESSION["glpiactive_entity_shortname"] = sprintf(__('%1$s (%2$s)'),
                                                               $_SESSION["glpiactive_entity_shortname"],
                                                               __('tree structure'));
         }

         if (countElementsInTable('glpi_entities') <= count($_SESSION['glpiactiveentities'])) {
            $_SESSION['glpishowallentities'] = 1;
         } else {
            $_SESSION['glpishowallentities'] = 0;
         }
         // Clean session variable to search system
         if (isset($_SESSION['glpisearch']) && count($_SESSION['glpisearch'])) {
            foreach ($_SESSION['glpisearch'] as $itemtype => $tab) {
               if (isset($tab['start']) && ($tab['start'] > 0)) {
                  $_SESSION['glpisearch'][$itemtype]['start'] = 0;
               }
            }
         }
         self::loadGroups();
         Plugin::doHook("change_entity");
         return true;
      }
      return false;
   }


   /**
    * Change active profile to the $ID one. Update glpiactiveprofile session variable.
    *
    * @param integer $ID ID of the new profile
    *
    * @return void
   **/
   static function changeProfile($ID) {

      if (isset($_SESSION['glpiprofiles'][$ID])
          && count($_SESSION['glpiprofiles'][$ID]['entities'])) {

         $profile = new Profile();
         if ($profile->getFromDB($ID)) {
            $profile->cleanProfile();
            $data             = $profile->fields;
            $data['entities'] = $_SESSION['glpiprofiles'][$ID]['entities'];

            $_SESSION['glpiactiveprofile']  = $data;
            $_SESSION['glpiactiveentities'] = [];

            Search::resetSaveSearch();
            $active_entity_done = false;

            // Try to load default entity if it is a root entity
            foreach ($data['entities'] as $val) {
               if ($val['id'] == $_SESSION["glpidefault_entity"]) {
                  if (self::changeActiveEntities($val['id'], $val['is_recursive'])) {
                     $active_entity_done = true;
                  }
               }
            }
            if (!$active_entity_done) {
               // Try to load default entity
               if (!self::changeActiveEntities($_SESSION["glpidefault_entity"], true)) {
                  // Load all entities
                  self::changeActiveEntities("all");
               }
            }
            Plugin::doHook("change_profile");
         }
      }
      // Clean specific datas
      if (isset($_SESSION['glpimenu'])) {
         unset($_SESSION['glpimenu']);
      }
   }


   /**
    * Set the entities session variable. Load all entities from DB
    *
    * @param integer $userID ID of the user
    *
    * @return void
   **/
   static function initEntityProfiles($userID) {
      global $DB;

      $_SESSION['glpiprofiles'] = [];

      if (!$DB->tableExists('glpi_profiles_users')) {
         //table does not exists in old GLPI versions
         return;
      }

      $iterator = $DB->request([
         'SELECT'          => [
            'glpi_profiles.id',
            'glpi_profiles.name'
         ],
         'DISTINCT'        => true,
         'FROM'            => 'glpi_profiles_users',
         'INNER JOIN'      => [
            'glpi_profiles'   => [
               'ON' => [
                  'glpi_profiles_users'   => 'profiles_id',
                  'glpi_profiles'         => 'id'
               ]
            ]
         ],
         'WHERE'           => [
            'glpi_profiles_users.users_id'   => $userID
         ],
         'ORDERBY'         => 'glpi_profiles.name'
      ]);

      if (count($iterator)) {
         while ($data = $iterator->next()) {
            $key = $data['id'];
            $_SESSION['glpiprofiles'][$key]['name'] = $data['name'];
            $entities_iterator = $DB->request([
               'SELECT'    => [
                  'glpi_profiles_users.entities_id AS eID',
                  'glpi_profiles_users.id AS kID',
                  'glpi_profiles_users.is_recursive',
                  'glpi_entities.*'
               ],
               'FROM'      => 'glpi_profiles_users',
               'LEFT JOIN' => [
                  'glpi_entities'   => [
                     'ON' => [
                        'glpi_profiles_users'   => 'entities_id',
                        'glpi_entities'         => 'id'
                     ]
                  ]
               ],
               'WHERE'     => [
                  'glpi_profiles_users.profiles_id'   => $key,
                  'glpi_profiles_users.users_id'      => $userID
               ],
               'ORDERBY'   => 'glpi_entities.completename'
            ]);

            while ($data = $entities_iterator->next()) {
               // Do not override existing entity if define as recursive
               if (!isset($_SESSION['glpiprofiles'][$key]['entities'][$data['eID']])
                  || $data['is_recursive']
               ) {
                  $_SESSION['glpiprofiles'][$key]['entities'][$data['eID']] = [
                     'id'           => $data['eID'],
                     'name'         => $data['name'],
                     'is_recursive' => $data['is_recursive']
                  ];
               }
            }
         }
      }
   }


   /**
    * Load current user's group on active entity
    *
    * @return void
   **/
   static function loadGroups() {
      global $DB;

      $_SESSION["glpigroups"] = [];

      $iterator = $DB->request([
         'SELECT'    => Group_User::getTable() . '.groups_id',
         'FROM'      => Group_User::getTable(),
         'LEFT JOIN' => [
            Group::getTable() => [
               'ON' => [
                  Group::getTable()       => 'id',
                  Group_User::getTable()  => 'groups_id'
               ]
            ]
         ],
         'WHERE'     => [
            Group_User::getTable(). '.users_id' => self::getLoginUserID()
         ] + getEntitiesRestrictCriteria(
            Group::getTable(),
            'entities_id',
            $_SESSION['glpiactiveentities'],
            true
         )
      ]);

      while ($data = $iterator->next()) {
         $_SESSION["glpigroups"][] = $data["groups_id"];
      }
   }


   /**
    * Include the good language dict.
    *
    * Get the default language from current user in $_SESSION["glpilanguage"].
    * And load the dict that correspond.
    *
    * @param string  $forcelang     Force to load a specific lang
    * @param boolean $with_plugins  Whether to load plugin languages or not
    *
    * @return void
   **/
   static function loadLanguage($forcelang = '', $with_plugins = true) {
      global $CFG_GLPI, $TRANSLATE;

      if (!isset($_SESSION["glpilanguage"])) {
         $_SESSION["glpilanguage"] = self::getPreferredLanguage();
      }

      $trytoload = $_SESSION["glpilanguage"];
      // Force to load a specific lang
      if (!empty($forcelang)) {
         $trytoload = $forcelang;
      }

      // If not set try default lang file
      if (empty($trytoload)) {
         $trytoload = $CFG_GLPI["language"];
      }

      if (isset($CFG_GLPI["languages"][$trytoload])) {
         $newfile = "/" . $CFG_GLPI["languages"][$trytoload][1];
      }

      if (empty($newfile) || !is_file(GLPI_I18N_DIR . $newfile)) {
         $newfile = "/en_GB.mo";
      }

      if (isset($CFG_GLPI["languages"][$trytoload][5])) {
         $_SESSION['glpipluralnumber'] = $CFG_GLPI["languages"][$trytoload][5];
      }
      $TRANSLATE = new Laminas\I18n\Translator\Translator;
      $TRANSLATE->setLocale($trytoload);

      if (class_exists('Locale')) {
         // Locale class may be missing if intl extension is not installed.
         // In this case, we may still want to be able to load translations (for instance for requirements checks).
         \Locale::setDefault($trytoload);
      } else {
         Toolbox::logWarning('Missing required intl PHP extension');
      }

      $cache = Config::getCache('cache_trans', 'core', false);
      if ($cache !== false && !defined('TU_USER')) {
         $TRANSLATE->setCache($cache);
      }

      $TRANSLATE->addTranslationFile('gettext', GLPI_I18N_DIR.$newfile, 'glpi', $trytoload);

      $core_folders = is_dir(GLPI_LOCAL_I18N_DIR) ? scandir(GLPI_LOCAL_I18N_DIR) : [];
      $core_folders = array_filter($core_folders, function($dir) {
         if (!is_dir(GLPI_LOCAL_I18N_DIR . "/$dir")) {
            return false;
         }

         if ($dir == 'core') {
            return true;
         }

         return Toolbox::startsWith($dir, 'core_');
      });

      foreach ($core_folders as $core_folder) {
         $mofile = GLPI_LOCAL_I18N_DIR . "/$core_folder/" . $newfile;
         $phpfile = str_replace('.mo', '.php', $mofile);

         // Load local PHP file if it exists
         if (file_exists($phpfile)) {
            $TRANSLATE->addTranslationFile('phparray', $phpfile, 'glpi', $trytoload);
         }

         // Load local MO file if it exists -- keep last so it gets precedence
         if (file_exists($mofile)) {
            $TRANSLATE->addTranslationFile('gettext', $mofile, 'glpi', $trytoload);
         }
      }

      // Load plugin dicts
      if ($with_plugins) {
         foreach (Plugin::getPlugins() as $plug) {
            Plugin::loadLang($plug, $forcelang, $trytoload);
         }
      }

      return $trytoload;
   }



   /**
    * Get plural form number
    *
    * @return integer
    */
   static function getPluralNumber() {
      global $DEFAULT_PLURAL_NUMBER;

      if (isset($_SESSION['glpipluralnumber'])) {
         return $_SESSION['glpipluralnumber'];
      } else {
         return $DEFAULT_PLURAL_NUMBER;
      }
   }

   /**
    * Detect cron mode or interactive
    *
    * @since 0.84
    *
    * @return boolean
   **/
   static function isCron() {

      return (isset($_SESSION["glpicronuserrunning"])
              && (isCommandLine()
                  || strpos($_SERVER['PHP_SELF'], '/cron.php')));
   }


   /**
    * Get the Login User ID or return cron user ID for cron jobs
    *
    * @param boolean $force_human Force human / do not return cron user (true by default)
    *
    * @return false|int|string false if user is not logged in
    *                          int for user id, string for cron jobs
   **/
   static function getLoginUserID($force_human = true) {

      if (!$force_human
          && self::isCron()) { // Check cron jobs
         return $_SESSION["glpicronuserrunning"];
      }

      if (isset($_SESSION["glpiID"])) {
         return $_SESSION["glpiID"];
      }
      return false;
   }


   /**
    * Redirect User to login if not logged in
    *
    * @since 0.85
    *
    * @return void
   **/
   static function redirectIfNotLoggedIn() {

      if (!self::getLoginUserID()) {
         Html::redirectToLogin();
      }
   }


   /**
    * Global check of session to prevent PHP vulnerability
    *
    * @since 0.85
    *
    * @see https://wiki.php.net/rfc/strict_sessions
    *
    * @return void|true
   **/
   static function checkValidSessionId() {
      global $DB;

      if (!isset($_SESSION['valid_id'])
          || ($_SESSION['valid_id'] !== session_id())) {
         Html::redirectToLogin('error=3');
      }

      $user_id    = self::getLoginUserID();
      $profile_id = $_SESSION['glpiactiveprofile']['id'] ?? null;
      $entity_id  = $_SESSION['glpiactive_entity'] ?? null;

      $valid_user = true;

      if (!is_numeric($user_id) || $profile_id === null || $entity_id === null) {
         $valid_user = false;
      } else {
         $user_table = User::getTable();
         $pu_table   = Profile_User::getTable();
         $result = $DB->request(
            [
               'COUNT'     => 'count',
               'FROM'      => $user_table,
               'LEFT JOIN' => [
                  $pu_table => [
                     'FKEY'  => [
                        Profile_User::getTable() => 'users_id',
                        $user_table         => 'id'
                     ]
                  ]
               ],
               'WHERE'     => [
                  $user_table . '.id'         => $user_id,
                  $user_table . '.is_active'  => 1,
                  $user_table . '.is_deleted' => 0,
                  $pu_table . '.profiles_id'  => $profile_id,
               ] + getEntitiesRestrictCriteria($pu_table, 'entities_id', $entity_id, true),
            ]
         );
         if ($result->next()['count'] === 0) {
            $valid_user = false;
         }
      }

      if (!$valid_user) {
         Session::destroy();
         Auth::setRememberMeCookie('');
         Html::redirectToLogin();
      }

      return true;
   }


   /**
    * Check if I have access to the central interface
    *
    * @return void
   **/
   static function checkCentralAccess() {
      self::checkValidSessionId();
      if (Session::getCurrentInterface() != "central") {
         // Gestion timeout session
         self::redirectIfNotLoggedIn();
         Html::displayRightError();
      }
   }


   /**
    * Check if I have the right to access to the FAQ (profile or anonymous FAQ)
    *
    * @return void
   **/
   static function checkFaqAccess() {
      global $CFG_GLPI;

      if (!$CFG_GLPI["use_public_faq"]) {
         self::checkValidSessionId();
         if (!self::haveRight('knowbase', KnowbaseItem::READFAQ)) {
            Html::displayRightError();
         }
      }
   }


   /**
    * Check if I have access to the helpdesk interface
    *
    * @return void
   **/
   static function checkHelpdeskAccess() {
      self::checkValidSessionId();
      if (Session::getCurrentInterface() != "helpdesk") {
         // Gestion timeout session
         self::redirectIfNotLoggedIn();
         Html::displayRightError();
      }
   }

   /**
    * Check if I am logged in
    *
    * @return void
   **/
   static function checkLoginUser() {
      self::checkValidSessionId();
      if (!isset($_SESSION["glpiname"])) {
         // Gestion timeout session
         self::redirectIfNotLoggedIn();
         Html::displayRightError();
      }
   }


   /**
    * Check if I have the right $right to module $module (conpare to session variable)
    *
    * @param string  $module Module to check
    * @param integer $right  Right to check
    *
    * @return void
   **/
   static function checkRight($module, $right) {
      self::checkValidSessionId();
      if (!self::haveRight($module, $right)) {
         // Gestion timeout session
         self::redirectIfNotLoggedIn();
         Html::displayRightError();
      }
   }

   /**
    * Check if I one right of array $rights to module $module (conpare to session variable)
    *
    * @param string $module Module to check
    * @param array  $rights Rights to check
    *
    * @return void
    **/
   static function checkRightsOr($module, $rights = []) {
      self::checkValidSessionId();
      if (!self::haveRightsOr($module, $rights)) {
         self::redirectIfNotLoggedIn();
         Html::displayRightError();
      }
   }


   /**
    * Check if I have one of the right specified
    *
    * You can't use this function if several rights for same module name
    *
    * @param array $modules Array of modules where keys are modules and value are right
    *
    * @return void
   **/
   static function checkSeveralRightsOr($modules) {
      self::checkValidSessionId();

      $valid = false;
      if (count($modules)) {
         foreach ($modules as $mod => $right) {
            // Itemtype
            if (preg_match('/[A-Z]/', $mod[0])) {
               if ($item = getItemForItemtype($mod)) {
                  if ($item->canGlobal($right)) {
                     $valid = true;
                  }
               }
            } else if (self::haveRight($mod, $right)) {
               $valid = true;
            }
         }
      }

      if (!$valid) {
         // Gestion timeout session
         self::redirectIfNotLoggedIn();
         Html::displayRightError();
      }
   }


   /**
    * Check if you could access to ALL the entities of an list
    *
    * @param array $tab List ID of entities
    *
    * @return boolean
   **/
   static function haveAccessToAllOfEntities($tab) {

      if (is_array($tab) && count($tab)) {
         foreach ($tab as $val) {
            if (!self::haveAccessToEntity($val)) {
               return false;
            }
         }
      }
      return true;
   }


   /**
    * Check if you could access (read) to the entity of id = $ID
    *
    * @param integer $ID           ID of the entity
    * @param boolean $is_recursive if recursive item (default 0)
    *
    * @return boolean
   **/
   static function haveAccessToEntity($ID, $is_recursive = 0) {

      // Quick response when passing wrong ID : default value of getEntityID is -1
      if ($ID < 0) {
         return false;
      }

      if (!isset($_SESSION['glpiactiveentities'])) {
         return false;
      }

      if (in_array($ID, $_SESSION['glpiactiveentities'])) {
         return true;
      }

      if (!$is_recursive) {
         return false;
      }

      /// Recursive object
      return in_array($ID, getAncestorsOf("glpi_entities", $_SESSION['glpiactiveentities']));
   }


   /**
    * Check if you could access to one entity of an list
    *
    * @param array   $tab          list ID of entities
    * @param boolean $is_recursive if recursive item (default 0)
    *
    * @return boolean
   **/
   static function haveAccessToOneOfEntities($tab, $is_recursive = 0) {

      if (is_array($tab) && count($tab)) {
         foreach ($tab as $val) {
            if (self::haveAccessToEntity($val, $is_recursive)) {
               return true;
            }
         }
      }
      return false;
   }


   /**
    * Check if you could create recursive object in the entity of id = $ID
    *
    * @param integer $ID ID of the entity
    *
    * @return boolean
   **/
   static function haveRecursiveAccessToEntity($ID) {

      // Right by profile
      foreach ($_SESSION['glpiactiveprofile']['entities'] as $val) {
         if ($val['id'] == $ID) {
            return $val['is_recursive'];
         }
      }
      // Right is from a recursive profile
      if (isset($_SESSION['glpiactiveentities'])) {
         return in_array($ID, $_SESSION['glpiactiveentities']);
      }
      return false;
   }


   /**
    * Have I the right $right to module $module (conpare to session variable)
    *
    * @param string  $module Module to check
    * @param integer $right  Right to check
    *
    * @return integer|false
   **/
   static function haveRight($module, $right) {
      global $DB;

      //If GLPI is using the slave DB -> read only mode
      if ($DB->isSlave()
          && ($right & (CREATE | UPDATE | DELETE | PURGE))) {
         return false;
      }

      if (isset($_SESSION["glpiactiveprofile"][$module])) {
         return intval($_SESSION["glpiactiveprofile"][$module]) & $right;
      }

      return false;
   }


   /**
    * Have I all rights of array $rights to module $module (conpare to session variable)
    *
    * @param string    $module Module to check
    * @param integer[] $rights Rights to check
    *
    * @return boolean
    **/
   static function haveRightsAnd($module, $rights = []) {

      foreach ($rights as $right) {
         if (!Session::haveRight($module, $right)) {
            return false;
         }
      }
      return true;
   }


   /**
    * Have I one right of array $rights to module $module (conpare to session variable)
    *
    * @param string    $module Module to check
    * @param integer[] $rights Rights to check
    *
    * @return boolean
    **/
   static function haveRightsOr($module, $rights = []) {

      foreach ($rights as $right) {
         if (Session::haveRight($module, $right)) {
            return true;
         }
      }
      return false;
   }


   /**
    *  Get active Tab for an itemtype
    *
    * @param string $itemtype item type
    *
    * @return string
   **/
   static function getActiveTab($itemtype) {

      if (isset($_SESSION['glpi_tabs'][strtolower($itemtype)])) {
         return $_SESSION['glpi_tabs'][strtolower($itemtype)];
      }
      return "";
   }


   /**
    * Add a message to be displayed after redirect
    *
    * @param string  $msg          Message to add
    * @param boolean $check_once   Check if the message is not already added (false by default)
    * @param integer $message_type Message type (INFO, WARNING, ERROR) (default INFO)
    * @param boolean $reset        Clear previous added message (false by default)
    *
    * @return void
   **/
   static function addMessageAfterRedirect($msg, $check_once = false, $message_type = INFO,
                                           $reset = false) {

      if (!empty($msg)) {
         if (self::isCron()) {
            // We are in cron mode
            // Do not display message in user interface, but record error
            if ($message_type == ERROR) {
               Toolbox::logInFile('cron', $msg."\n");
            }

         } else {
            $array = &$_SESSION['MESSAGE_AFTER_REDIRECT'];

            if ($reset) {
               $array = [];
            }

            if (!isset($array[$message_type])) {
               $array[$message_type] = [];
            }

            if (!$check_once
                || !isset($array[$message_type])
                || in_array($msg, $array[$message_type]) === false) {
               $array[$message_type][] = $msg;
            }
         }
      }
   }


   /**
    *  Force active Tab for an itemtype
    *
    * @param string  $itemtype item type
    * @param integer $tab      ID of the tab
    *
    * @return void
   **/
   static function setActiveTab($itemtype, $tab) {
      $_SESSION['glpi_tabs'][strtolower($itemtype)] = $tab;
   }


   /**
    * Get a saved option from request or session
    * if get from request, save it
    *
    * @since 0.83
    *
    * @param string $itemtype  name of itemtype
    * @param string $name      name of the option
    * @param mixed  $defvalue  mixed default value for option
    *
    * @return mixed
   **/
   static function getSavedOption($itemtype, $name, $defvalue) {

      if (isset($_REQUEST[$name])) {
         return $_SESSION['glpi_saved'][$itemtype][$name] = $_REQUEST[$name];
      }

      if (isset($_SESSION['glpi_saved'][$itemtype][$name])) {
         return $_SESSION['glpi_saved'][$itemtype][$name];
      }
      return $defvalue;
   }


   /**
    * Is the current account read-only
    *
    * @since 0.83
    *
    * @return boolean
   **/
   static function isReadOnlyAccount() {

      foreach ($_SESSION['glpiactiveprofile'] as $name => $val) {
         if (is_numeric($val)
             && ($name != 'search_config')
             && ($val & ~READ)) {
            return false;
         }
      }
      return true;
   }



   /**
    * Get new CSRF token
    *
    * @param bool $standalone
    *    Generates a standalone token that will not be shared with other component of current request.
    *
    * @since 0.83.3
    *
    * @return string
   **/
   static public function getNewCSRFToken(bool $standalone = false) {
      global $CURRENTCSRFTOKEN;

      $token = $standalone ? '' : $CURRENTCSRFTOKEN;

      if (empty($token)) {
         do {
            $token = bin2hex(random_bytes(32));
         } while ($token == '');
      }

      if (!isset($_SESSION['glpicsrftokens'])) {
         $_SESSION['glpicsrftokens'] = [];
      }
      $_SESSION['glpicsrftokens'][$token] = time() + GLPI_CSRF_EXPIRES;

      if (!$standalone) {
         $CURRENTCSRFTOKEN = $token;
      }

      return $token;
   }


   /**
    * Clean expired CSRF tokens
    *
    * @since 0.83.3
    *
    * @return void
   **/
   static public function cleanCSRFTokens() {

      $now = time();
      if (isset($_SESSION['glpicsrftokens']) && is_array($_SESSION['glpicsrftokens'])) {
         if (count($_SESSION['glpicsrftokens'])) {
            foreach ($_SESSION['glpicsrftokens'] as $token => $expires) {
               if ($expires < $now) {
                  unset($_SESSION['glpicsrftokens'][$token]);
               }
            }
            $overflow = count($_SESSION['glpicsrftokens']) - GLPI_CSRF_MAX_TOKENS;
            if ($overflow > 0) {
               $_SESSION['glpicsrftokens'] = array_slice($_SESSION['glpicsrftokens'], $overflow + 1,
                                                         null, true);
            }
         }
      }
   }


   /**
    * Validate that the page has a CSRF token in the POST data
    * and that the token is legit/not expired.  If the token is valid
    * it will be removed from the list of valid tokens.
    *
    * @since 0.83.3
    *
    * @param array $data $_POST data
    *
    * @return boolean
   **/
   static public function validateCSRF($data) {

      if (!isset($data['_glpi_csrf_token'])) {
         Session::cleanCSRFTokens();
         return false;
      }
      $requestToken = $data['_glpi_csrf_token'];
      if (isset($_SESSION['glpicsrftokens'][$requestToken])
          && ($_SESSION['glpicsrftokens'][$requestToken] >= time())) {
         if (!defined('GLPI_KEEP_CSRF_TOKEN')) { /* When post open a new windows */
            unset($_SESSION['glpicsrftokens'][$requestToken]);
         }
         Session::cleanCSRFTokens();
         return true;
      }
      Session::cleanCSRFTokens();
      return false;
   }


   /**
    * Check CSRF data
    *
    * @since 0.84.2
    *
    * @param array $data $_POST data
    *
    * @return void
   **/
   static public function checkCSRF($data) {

      if (GLPI_USE_CSRF_CHECK
          && (!Session::validateCSRF($data))) {
         // Output JSON if requested by client
         if (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false) {
            http_response_code(403);
            die(json_encode(["message" => __("The action you have requested is not allowed.")]));
         }

         Html::displayErrorAndDie(__("The action you have requested is not allowed."), true);
      }
   }


   /**
    * Get new IDOR token
    * This token validates the itemtype used by an ajax request is the one asked by a dropdown.
    * So, we avoid IDOR request where an attacker asks for an another itemtype
    * than the originaly indtended
    *
    * @since 9.5.3
    *
    * @param string $itemtype
    * @param array  $add_params more criteria to check validy of idor tokens
    *
    * @return string
   **/
   static public function getNewIDORToken(string $itemtype = "", array $add_params = []): string {
      $token = "";
      do {
         $token = bin2hex(random_bytes(32));
      } while ($token == '');

      if (!isset($_SESSION['glpiidortokens'])) {
         $_SESSION['glpiidortokens'] = [];
      }

      $_SESSION['glpiidortokens'][$token] = [
         'expires'  => time() + GLPI_IDOR_EXPIRES
      ] + ($itemtype !== "" ? ['itemtype' => $itemtype] : [])
        + $add_params;

      return $token;
   }


   /**
    * Validate that the page has a IDOR token in the POST data
    * and that the token is legit/not expired.
    * Tokens are kept in session until their time is expired (by default 2h)
    * to permits multiple ajax calls for a dropdown
    *
    * @since 9.5.3
    *
    * @param array $data $_POST data
    *
    * @return boolean
   **/
   static public function validateIDOR(array $data = []): bool {
      self::cleanIDORTokens();

      if (!isset($data['_idor_token'])) {
         return false;
      }

      $token = $data['_idor_token'];

      if (isset($_SESSION['glpiidortokens'][$token])
          && $_SESSION['glpiidortokens'][$token]['expires'] >= time()) {
         $idor_data =  $_SESSION['glpiidortokens'][$token];
         unset($idor_data['expires']);

         // check all stored data for the idor token are present (and identifical) in the posted data
         $match_expected = function ($expected, $given) use (&$match_expected) {
            if (is_array($expected)) {
               if (!is_array($given)) {
                  return false;
               }
               foreach ($expected as $key => $value) {
                  if (!array_key_exists($key, $given) || !$match_expected($value, $given[$key])) {
                     return false;
                  }
               }
               return true;
            } else {
               return $expected == $given;
            }
         };

         // Check also unsanitized data, as sanitizing process may alter expected data.
         $unsanitized_data = Toolbox::stripslashes_deep($data);

         return $match_expected($idor_data, $data) || $match_expected($idor_data, $unsanitized_data);
      }

      return false;
   }

   /**
    * Clean expired IDOR tokens
    *
    * @since 9.5.3
    *
    * @return void
   **/
   static public function cleanIDORTokens() {
      $now = time();
      if (isset($_SESSION['glpiidortokens']) && is_array($_SESSION['glpiidortokens'])) {
         foreach ($_SESSION['glpiidortokens'] as $footprint => $token) {
            if ($token['expires'] < $now) {
               unset($_SESSION['glpiidortokens'][$footprint]);
            }
         }
      }
   }


   /**
    * Is field having translations ?
    *
    * @since 0.85
    *
    * @param string $itemtype itemtype
    * @param string $field    field
    *
    * @return boolean
   **/
   static function haveTranslations($itemtype, $field) {

      return (isset($_SESSION['glpi_dropdowntranslations'][$itemtype])
              && isset($_SESSION['glpi_dropdowntranslations'][$itemtype][$field]));
   }

   /**
    * Get current interface name extracted from session var (if exists)
    *
    * @since  9.2.2
    *
    * @return false or [helpdesk|central]
    */
   static function getCurrentInterface() {
      if (isset($_SESSION['glpiactiveprofile']['interface'])) {
         return $_SESSION['glpiactiveprofile']['interface'];
      }

      return false;
   }

   /**
    * Check if current user can impersonate another user having given id.
    *
    * @param integer $user_id
    *
    * @return boolean
    */
   static function canImpersonate($user_id) {

      if ($user_id <= 0 || self::getLoginUserID() == $user_id
          || (self::isImpersonateActive() && self::getImpersonatorId() == $user_id)) {
         return false; // Cannot impersonate invalid user, self, or already impersonated user
      }

      // For now we do not check more than config update right, but we may
      // implement more fine checks in the future.
      $config = new Config();
      return self::haveRight($config->getRightname(), UPDATE);
   }

   /**
    * Impersonate user having given id.
    *
    * @param integer $user_id
    *
    * @return boolean
    */
   static function startImpersonating($user_id) {

      if (!self::canImpersonate($user_id)) {
         return false;
      }

      $user = new User();
      if (!$user->getFromDB($user_id)) {
         return false;
      }

      //store user who impersonated another user
      $impersonator = $_SESSION['glpiname'];

      // Store current user values
      $impersonator_id  = self::isImpersonateActive()
         ? $_SESSION['impersonator_id']
         : self::getLoginUserID();
      $lang             = $_SESSION['glpilanguage'];
      $session_use_mode = $_SESSION['glpi_use_mode'];

      $auth = new Auth();
      $auth->auth_succeded = true;
      $auth->user = $user;
      Session::init($auth);

      // Force usage of current user lang and session mode
      $_SESSION['glpilanguage'] = $lang;
      $_SESSION['glpi_use_mode'] = $session_use_mode;
      Session::loadLanguage();

      $_SESSION['impersonator_id'] = $impersonator_id;

      Event::log(-1, "system", 3, "Impersonate", sprintf(__('%1$s starts impersonating user %2$s'),
                                                            $impersonator, $user->fields['name']));

      return true;
   }

   /**
    * Stop impersonating any user.
    *
    * @return boolean
    */
   static function stopImpersonating() {

      if (!self::isImpersonateActive()) {
         return true; // Nothing to do
      }

      $user = new User();
      if (!$user->getFromDB($_SESSION['impersonator_id'])) {
         return false;
      }

      //store user which was impersonated by another user
      $impersonate_user = $_SESSION['glpiname'];

      $auth = new Auth();
      $auth->auth_succeded = true;
      $auth->user = $user;
      Session::init($auth);

      Event::log(-1, "system", 3, "Impersonate", sprintf(__('%1$s stops impersonating user %2$s'),
      $user->fields['name'], $impersonate_user));

      return true;
   }

   /**
    * Check if impersonate feature is currently used.
    *
    * @return boolean
    */
   static function isImpersonateActive() {

      return array_key_exists('impersonator_id', $_SESSION);
   }

   /**
    * Return impersonator user id.
    *
    * @return string|null
    */
   static function getImpersonatorId() {

      return self::isImpersonateActive() ? $_SESSION['impersonator_id'] : null;
   }

   /**
    * Check if current connected user password has expired.
    *
    * @return boolean
    */
   static function mustChangePassword() {
      return array_key_exists('glpi_password_expired', $_SESSION);
   }

   /**
    * Get active entity id.
    *
    * @since 9.5
    *
    * @return int
    */
   public static function getActiveEntity() {
      return $_SESSION['glpiactive_entity'] ?? 0;
   }

   /**
    * Get recursive state of active entity selection.
    *
    * @since 9.5.5
    *
    * @return bool
    */
   public static function getIsActiveEntityRecursive(): bool {
      return $_SESSION['glpiactive_entity_recursive'] ?? false;
   }

   /**
    * Start session for a given user
    *
    * @param int $users_id ID of the user
    *
    * @return User|bool
    */
   public static function authWithToken(
      string $token,
      string $token_type,
      ?int $entities_id,
      ?bool $is_recursive
   ) {
      $user = new User();

      // Try to load from token
      if (!$user->getFromDBByToken($token, $token_type)) {
         return false;
      }

      $auth = new Auth();
      $auth->auth_succeded = true;
      $auth->user = $user;
      Session::init($auth);

      if (!is_null($entities_id) && !is_null($is_recursive)) {
         self::loadEntity($entities_id, $is_recursive);
      }

      return $user;
   }

   /**
    * Load given entity.
    *
    * @param integer $entities_id  Entity to use
    * @param boolean $is_recursive Whether to load entities recursivly or not
    *
    * @return void
    */
   public static function loadEntity($entities_id, $is_recursive): void {
      $_SESSION["glpiactive_entity"]           = $entities_id;
      $_SESSION["glpiactive_entity_recursive"] = $is_recursive;
      if ($is_recursive) {
         $entities = getSonsOf("glpi_entities", $entities_id);
      } else {
         $entities = [$entities_id];
      }
      $_SESSION['glpiactiveentities']        = $entities;
      $_SESSION['glpiactiveentities_string'] = "'".implode("', '", $entities)."'";
   }
}
