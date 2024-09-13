<?php

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}


/**
 *  Database class for Mysql
**/
class DBConnection extends CommonDBTM {

   static protected $notable = true;


   static function getTypeName($nb = 0) {
      return _n('SQL replica', 'SQL replicas', $nb);
   }


   /**
    * Create GLPI main configuration file
    *
    * @since 9.1
    *
    * @param string $host      The DB host
    * @param string $user      The DB user
    * @param string $password  The DB password
    * @param string $DBname    The name of the DB
    *
    * @return boolean
    *
   **/
   static function createMainConfig($host, $user, $password, $DBname) {

      $DB_str = "<?php\nclass DB extends DBmysql {\n" .
                "   public \$dbhost     = '$host';\n" .
                "   public \$dbuser     = '$user';\n" .
                "   public \$dbpassword = '". rawurlencode($password) . "';\n" .
                "   public \$dbdefault  = '$DBname';\n" .
                "}\n";

      return Toolbox::writeConfig('config_db.php', $DB_str);
   }


   /**
    * Create slave DB configuration file
    *
    * @param string $host      The slave DB host(s)
    * @param string $user      The slave DB user
    * @param string $password  The slave DB password
    * @param string $DBname    The name of the slave DB
    *
    * @return boolean for success
   **/
   static function createSlaveConnectionFile($host, $user, $password, $DBname) {

      $DB_str = "<?php \n class DBSlave extends DBmysql { \n public \$slave = true; \n public \$dbhost = ";
      $host   = trim($host);
      if (strpos($host, ' ')) {
         $hosts = explode(' ', $host);
         $first = true;
         foreach ($hosts as $host) {
            if (!empty($host)) {
               $DB_str .= ($first ? "array('" : ",'").$host."'";
               $first   = false;
            }
         }
         if ($first) {
            // no host configured
            return false;
         }
         $DB_str .= ");\n";

      } else {
         $DB_str .= "'$host';\n";
      }
      $DB_str .= " public \$dbuser = '" . $user . "'; \n public \$dbpassword= '" .
                  rawurlencode($password) . "'; \n public \$dbdefault = '" . $DBname . "'; \n }\n";

      return Toolbox::writeConfig('config_db_slave.php', $DB_str);
   }


   /**
    * Indicates is the DB replicate is active or not
    *
    * @return true if active / false if not active
   **/
   static function isDBSlaveActive() {
      return file_exists(GLPI_CONFIG_DIR . "/config_db_slave.php");
   }


   /**
    * Read slave DB configuration file
    *
    * @param integer $choice  Host number (default NULL)
    *
    * @return DBmysql object
   **/
   static function getDBSlaveConf($choice = null) {

      if (self::isDBSlaveActive()) {
         include_once (GLPI_CONFIG_DIR . "/config_db_slave.php");
         return new DBSlave($choice);
      }
   }


   /**
    * Create a default slave DB configuration file
   **/
   static function createDBSlaveConfig() {
      self::createSlaveConnectionFile("localhost", "glpi", "glpi", "glpi");
   }


   /**
    * Save changes to the slave DB configuration file
    *
    * @param $host
    * @param $user
    * @param $password
    * @param $DBname
   **/
   static function saveDBSlaveConf($host, $user, $password, $DBname) {
      self::createSlaveConnectionFile($host, $user, $password, $DBname);
   }


   /**
    * Delete slave DB configuration file
    */
   static function deleteDBSlaveConfig() {
      unlink(GLPI_CONFIG_DIR . "/config_db_slave.php");
   }


   /**
    * Switch database connection to slave
   **/
   static function switchToSlave() {
      global $DB;

      if (self::isDBSlaveActive()) {
         include_once (GLPI_CONFIG_DIR . "/config_db_slave.php");
         $DB = new DBSlave();
         return $DB->connected;
      }
      return false;
   }


   /**
    * Switch database connection to master
   **/
   static function switchToMaster() {
      global $DB;

      $DB = new DB();
      return $DB->connected;
   }


   /**
    * Get Connection to slave, if exists,
    * and if configured to be used for read only request
    *
    * @return DBmysql object
   **/
   static function getReadConnection() {
      global $DB, $CFG_GLPI;

      if ($CFG_GLPI['use_slave_for_search']
          && !$DB->isSlave()
          && self::isDBSlaveActive()) {

         include_once (GLPI_CONFIG_DIR . "/config_db_slave.php");
         $DBread = new DBSlave();

         if ($DBread->connected) {
            $sql = "SELECT MAX(`id`) AS maxid
                    FROM `glpi_logs`";

            switch ($CFG_GLPI['use_slave_for_search']) {
               case 3 : // If synced or read-only account
                  if (Session::isReadOnlyAccount()) {
                     return $DBread;
                  }
                  // nobreak;

               case 1 : // If synced (all changes)
                  $slave  = $DBread->request($sql)->next();
                  $master = $DB->request($sql)->next();
                  if (isset($slave['maxid']) && isset($master['maxid'])
                      && ($slave['maxid'] == $master['maxid'])) {
                     // Latest Master change available on Slave
                     return $DBread;
                  }
                  break;

               case 2 : // If synced (current user changes or profile in read only)
                  if (!isset($_SESSION['glpi_maxhistory'])) {
                     // No change yet
                     return $DBread;
                  }
                  $slave  = $DBread->request($sql)->next();
                  if (isset($slave['maxid'])
                      && ($slave['maxid'] >= $_SESSION['glpi_maxhistory'])) {
                     // Latest current user change avaiable on Slave
                     return $DBread;
                  }
                  break;

               default: // Always
                  return $DBread;
            }
         }
      }
      return $DB;
   }


   /**
    *  Establish a connection to a mysql server (main or replicate)
    *
    * @param boolean $use_slave try to connect to slave server first not to main server
    * @param boolean $required  connection to the specified server is required
    *                           (if connection failed, do not try to connect to the other server)
    * @param boolean $display   display error message (true by default)
    *
    * @return boolean True if successfull, false otherwise
   **/
   static function establishDBConnection($use_slave, $required, $display = true) {
      global $DB;

      $DB  = null;
      $res = false;

      // First standard config : no use slave : try to connect to master
      if (!$use_slave) {
         $res = self::switchToMaster();
      }

      // If not already connected to master due to config or error
      if (!$res) {

         // No DB slave : first connection to master give error
         if (!self::isDBSlaveActive()) {
            // Slave wanted but not defined -> use master
            // Ignore $required when no slave configured
            if ($use_slave) {
               $res = self::switchToMaster();
            }

         } else { // Slave DB configured
            // Try to connect to slave if wanted
            if ($use_slave) {
               $res = self::switchToSlave();
            }

            // No connection to 'mandatory' server
            if (!$res && !$required) {
               //Try to establish the connection to the other mysql server
               if ($use_slave) {
                  $res = self::switchToMaster();
               } else {
                  $res = self::switchToSlave();
               }
               if ($res) {
                  $DB->first_connection = false;
               }
            }
         }
      }

      // Display error if needed
      if (!$res && $display) {
         self::displayMySQLError();
      }
      return $res;
   }


   /**
    * Get delay between slave and master
    *
    * @param integer $choice  Host number (default NULL)
    *
    * @return integer
   **/
   static function getReplicateDelay($choice = null) {

      include_once (GLPI_CONFIG_DIR . "/config_db_slave.php");
      return (int) (self::getHistoryMaxDate(new DB())
                    - self::getHistoryMaxDate(new DBSlave($choice)));
   }


   /**
    *  Get history max date of a GLPI DB
    *
    * @param DBMysql $DBconnection DB connection used
    *
    * @return int|mixed|null
    */
   static function getHistoryMaxDate($DBconnection) {

      if ($DBconnection->connected) {
         $result = $DBconnection->query("SELECT UNIX_TIMESTAMP(MAX(`date_mod`)) AS max_date
                                         FROM `glpi_logs`");
         if ($DBconnection->numrows($result) > 0) {
            return $DBconnection->result($result, 0, "max_date");
         }
      }
      return 0;
   }


   /**
    *  Display a common mysql connection error
   **/
   static function displayMySQLError() {
      global $DB;

      $error = $DB instanceof DBmysql ? $DB->error : 1;
      switch ($error) {
         case 2:
            $en_msg = "Use of mysqlnd driver is required for exchanges with the MySQL server.";
            $fr_msg = "L'utilisation du driver mysqlnd est requise pour les échanges avec le serveur MySQL.";
            break;
         case 1:
         default:
            $fr_msg = "Le serveur Mysql est inaccessible. Vérifiez votre configuration.";
            $en_msg = "A link to the SQL server could not be established. Please check your configuration.";
            break;
      }

      if (!isCommandLine()) {
         Html::nullHeader("Mysql Error", '');
         echo "<div class='center'><p class ='b'>$en_msg</p><p class='b'>$fr_msg</p></div>";
         Html::nullFooter();
      } else {
         echo "$en_msg\n$fr_msg\n";
      }

      die(1);
   }


   /**
    * @param $name
   **/
   static function cronInfo($name) {

      return ['description' => __('Check the SQL replica'),
                   'parameter'   => __('Max delay between master and slave (minutes)')];
   }


   /**
    * Cron process to check DB replicate state
    *
    * @param CronTask $task to log and get param
    *
    * @return integer
   **/
   static function cronCheckDBreplicate(CronTask $task) {
      global $DB;

      //Lauch cron only is :
      // 1 the master database is avalaible
      // 2 the slave database is configurated
      if (!$DB->isSlave() && self::isDBSlaveActive()) {

         $DBslave = self::getDBSlaveConf();
         if (is_array($DBslave->dbhost)) {
            $hosts = $DBslave->dbhost;
         } else {
            $hosts = [$DBslave->dbhost];
         }

         foreach ($hosts as $num => $name) {
            $diff = self::getReplicateDelay($num);

            // Quite strange, but allow simple stat
            $task->addVolume($diff);
            if ($diff > 1000000000) { // very large means slave is disconnect
               $task->log(sprintf(__s("SQL server: %s can't connect to the database"), $name));
            } else {
                                  //TRANS: %1$s is the server name, %2$s is the time
               $task->log(sprintf(__('SQL server: %1$s, difference between master and slave: %2$s'),
                                  $name, Html::timestampToString($diff, true)));
            }

            if ($diff > ($task->fields['param']*60)) {
               //Raise event if replicate is not synchronized
               $options = ['diff'        => $diff,
                                'name'        => $name,
                                'entities_id' => 0]; // entity to avoid warning in getReplyTo
               NotificationEvent::raiseEvent('desynchronization', new self(), $options);
            }
         }
         return 1;
      }
      return 0;
   }


   /**
    * Display in HTML, delay between master and slave
    * 1 line per slave is multiple
   **/
   static function showAllReplicateDelay() {

      $DBslave = self::getDBSlaveConf();

      if (is_array($DBslave->dbhost)) {
         $hosts = $DBslave->dbhost;
      } else {
         $hosts = [$DBslave->dbhost];
      }

      foreach ($hosts as $num => $name) {
         $diff = self::getReplicateDelay($num);
         //TRANS: %s is namez of server Mysql
         printf(__('%1$s: %2$s'), __('SQL server'), $name);
         echo " - ";
         if ($diff > 1000000000) {
            echo __("can't connect to the database") . "<br>";
         } else if ($diff) {
            printf(__('%1$s: %2$s')."<br>", __('Difference between master and slave'),
                   Html::timestampToString($diff, 1));
         } else {
            printf(__('%1$s: %2$s')."<br>", __('Difference between master and slave'), __('None'));
         }
      }
   }


   /**
    * @param $width
   **/
   function showSystemInformations($width) {

      // No need to translate, this part always display in english (for copy/paste to forum)

      echo "<tr class='tab_bg_2'><th>".self::getTypeName(Session::getPluralNumber())."</th></tr>";

      echo "<tr class='tab_bg_1'><td><pre>\n&nbsp;\n";
      if (self::isDBSlaveActive()) {
         echo "Active\n";
         self::showAllReplicateDelay();
      } else {
         echo "Not active\n";
      }
      echo "\n</pre></td></tr>";
   }


   /**
    * Enable or disable db replication check cron task
    *
    * @param boolean $enable Enable or disable cron task (true by default)
   **/
   static function changeCronTaskStatus($enable = true) {

      $cron           = new CronTask();
      $cron->getFromDBbyName('DBConnection', 'CheckDBreplicate');
      $input = [
         'id'    => $cron->fields['id'],
         'state' => ($enable ? 1 : 0)
      ];
      $cron->update($input);
   }

}
