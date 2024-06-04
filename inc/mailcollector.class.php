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

if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access this file directly");
}

use LitEmoji\LitEmoji;
use Laminas\Mail\Address;
use Laminas\Mail\Header\AbstractAddressList;
use Laminas\Mail\Header\ContentDisposition;
use Laminas\Mail\Header\ContentType;
use Laminas\Mail\Storage\Message;
use Laminas\Mail\Storage;


/**
 * MailCollector class
 *
 * Merge with collect GLPI system after big modification in it
 *
 * modif and debug by  INDEPNET Development Team.
 * Original class ReceiveMail 1.0 by Mitul Koradia Created: 01-03-2006
 * Description: Reciving mail With Attechment
 * Email: mitulkoradia@gmail.com
**/
class MailCollector  extends CommonDBTM {

   // Specific one
   /**
    * IMAP / POP connection
    * @var Laminas\Mail\Storage\AbstractStorage
    */
   private $storage;
   /// UID of the current message
   public $uid             = -1;
   /// structure used to store files attached to a mail
   public $files;
   /// structure used to store alt files attached to a mail
   public $altfiles;
   /// Tag used to recognize embedded images of a mail
   public $tags;
   /// Message to add to body to build ticket
   public $addtobody;
   /// Number of fetched emails
   public $fetch_emails    = 0;
   /// Maximum number of emails to fetch : default to 10
   public $maxfetch_emails = 10;
   /// array of indexes -> uid for messages
   public $messages_uid    = [];
   /// Max size for attached files
   public $filesize_max    = 0;

   /**
    * Flag that tells wheter the body is in HTML format or not.
    * @var string
    */
   private $body_is_html   = false;

   public $dohistory       = true;

   static $rightname       = 'config';

   // Destination folder
   const REFUSED_FOLDER  = 'refused';
   const ACCEPTED_FOLDER = 'accepted';

   // Values for requester_field
   const REQUESTER_FIELD_FROM = 0;
   const REQUESTER_FIELD_REPLY_TO = 1;

   static $undisclosedFields = [
      'passwd',
   ];

   static function getTypeName($nb = 0) {
      return _n('Receiver', 'Receivers', $nb);
   }


   static function canCreate() {
      return static::canUpdate();
   }


   static function canPurge() {
      return static::canUpdate();
   }


   static function getAdditionalMenuOptions() {

      if (static::canView()) {
         $options['options']['notimportedemail']['links']['search']
                                          = '/front/notimportedemail.php';
         return $options;
      }
      return false;
   }


   function post_getEmpty() {
      global $CFG_GLPI;

      $this->fields['filesize_max'] = $CFG_GLPI['default_mailcollector_filesize_max'];
      $this->fields['is_active']    = 1;
   }

   public function prepareInput(array $input, $mode = 'add') :array {

      if (isset($input["passwd"])) {
         if (empty($input["passwd"])) {
            unset($input["passwd"]);
         } else {
            $input["passwd"] = Toolbox::sodiumEncrypt($input["passwd"]);
         }
      }

      if (isset($input['mail_server']) && !empty($input['mail_server'])) {
         $input["host"] = Toolbox::constructMailServerConfig($input);
      }

      return $input;
   }

   function prepareInputForUpdate($input) {
      $input = $this->prepareInput($input, 'update');

      if (isset($input["_blank_passwd"]) && $input["_blank_passwd"]) {
         $input['passwd'] = '';
      }

      return $input;
   }


   function prepareInputForAdd($input) {
      $input = $this->prepareInput($input, 'add');
      return $input;
   }


   function defineTabs($options = []) {

      $ong = [];
      $this->addDefaultFormTab($ong);
      $this->addStandardTab(__CLASS__, $ong, $options);
      $this->addImpactTab($ong, $options);
      $this->addStandardTab('Log', $ong, $options);

      return $ong;
   }


   function getTabNameForItem(CommonGLPI $item, $withtemplate = 0) {

      if (!$withtemplate) {
         switch ($item->getType()) {
            case __CLASS__ :
               return _n('Action', 'Actions', Session::getPluralNumber());
         }
      }
      return '';
   }


   /**
    * @param $item         CommonGLPI object
    * @param $tabnum       (default 1
    * @param $withtemplate (default 0)
   **/
   static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0) {
      if ($item->getType() == __CLASS__) {
         $item->showGetMessageForm($item->getID());
      }
      return true;
   }


   /**
    * Print the mailgate form
    *
    * @param $ID        integer  Id of the item to print
    * @param $options   array
    *     - target filename : where to go when done.
    *
    * @return boolean item found
   **/
   function showForm($ID, $options = []) {
      global $CFG_GLPI;

      $this->initForm($ID, $options);
      $options['colspan'] = 1;
      $this->showFormHeader($options);

      echo "<tr class='tab_bg_1'><td>";
      echo __('Name');
      echo '&nbsp;';
      Html::showToolTip(__('If name is a valid email address, it will be automatically added to blacklisted senders.'));
      echo "</td><td>";
      Html::autocompletionTextField($this, "name");
      echo "</td></tr>";

      if ($this->fields['errors']) {
         echo "<tr class='tab_bg_1_2'><td>".__('Connection errors')."</td>";
         echo "<td>".$this->fields['errors']."</td>";
         echo "</tr>";
      }

      echo "<tr class='tab_bg_1'><td>".__('Active')."</td><td>";
      Dropdown::showYesNo("is_active", $this->fields["is_active"]);
      echo "</td></tr>";

      $type = Toolbox::showMailServerConfig($this->fields["host"]);

      echo "<tr class='tab_bg_1'><td>".__('Login')."</td><td>";
      Html::autocompletionTextField($this, "login");
      echo "</td></tr>";

      echo "<tr class='tab_bg_1'><td>".__('Password')."</td>";
      echo "<td><input type='password' name='passwd' value='' size='20' autocomplete='new-password'>";
      if ($ID > 0) {
         echo "<input type='checkbox' name='_blank_passwd'>&nbsp;".__('Clear');
      }
      echo "</td></tr>";

      if ($type != "pop") {
         echo "<tr class='tab_bg_1'><td>" . __('Accepted mail archive folder (optional)') . "</td>";
         echo "<td>";
         echo "<input size='30' type='text' id='accepted_folder' name='accepted' value=\"".$this->fields['accepted']."\">";
         echo "<i class='fa fa-list pointer get-imap-folder'></i>";
         echo "</td></tr>\n";

         echo "<tr class='tab_bg_1'><td>" . __('Refused mail archive folder (optional)') . "</td>";
         echo "<td>";
         echo "<input size='30' type='text' id='refused_folder' name='refused' value=\"".$this->fields['refused']."\">";
         echo "<i class='fa fa-list pointer get-imap-folder'></i>";
         echo "</td></tr>\n";
      }

      echo "<tr class='tab_bg_1'>";
      echo "<td width='200px'> ". __('Maximum size of each file imported by the mails receiver').
           "</td><td>";
      self::showMaxFilesize('filesize_max', $this->fields["filesize_max"]);
      echo "</td></tr>";

      echo "<tr class='tab_bg_1'><td>" . __('Use mail date, instead of collect one') . "</td>";
      echo "<td>";
      Dropdown::showYesNo("use_mail_date", $this->fields["use_mail_date"]);
      echo "</td></tr>\n";

      echo "<tr class='tab_bg_1'><td>" . __('Use Reply-To as requester (when available)') . "</td>";
      echo "<td>";
      Dropdown::showFromArray("requester_field", [
         self::REQUESTER_FIELD_FROM => __('No'),
         self::REQUESTER_FIELD_REPLY_TO => __('Yes')
      ], ["value" => $this->fields['requester_field']]);
      echo "</td></tr>\n";

      echo "<tr class='tab_bg_1'><td>" . __('Add CC users as observer') . "</td>";
      echo "<td>";
      Dropdown::showYesNo("add_cc_to_observer", $this->fields["add_cc_to_observer"]);
      echo "</td></tr>\n";

      echo "<tr class='tab_bg_1'><td>" . __('Collect only unread mail') . "</td>";
      echo "<td>";
      Dropdown::showYesNo("collect_only_unread", $this->fields["collect_only_unread"]);
      echo "</td></tr>\n";

      echo "<tr class='tab_bg_1'><td>".__('Comments')."</td>";
      echo "<td><textarea cols='45' rows='5' name='comment' >".$this->fields["comment"]."</textarea>";

      if ($ID > 0) {
         echo "<br>";
         //TRANS: %s is the datetime of update
         printf(__('Last update on %s'), Html::convDateTime($this->fields["date_mod"]));
      }
      echo "</td></tr>";

      $this->showFormButtons($options);

      if ($type != 'pop') {
         echo "<div id='imap-folder'></div>";
         echo Html::scriptBlock("$(function() {
            $('#imap-folder')
               .dialog(options = {
                  autoOpen: false,
                  autoResize:true,
                  width: 'auto',
                  modal: true,
               });

            $(document).on('click', '.get-imap-folder', function() {
               var input = $(this).prev('input');

               var data = 'action=getFoldersList';
               data += '&input_id=' + input.attr('id');
               // Get form values without server_mailbox value to prevent filtering
               data += '&' + $(this).closest('form').find(':not([name=\"server_mailbox\"])').serialize();
               // Force empty value for server_mailbox
               data += '&server_mailbox=';

               $('#imap-folder')
                  .html('')
                  .load('".$CFG_GLPI['root_doc']."/ajax/mailcollector.php', data)
                  .dialog('open');
            });

            $(document).on('click', '.select_folder li', function(event) {
               event.stopPropagation();

               var li       = $(this);
               var input_id = li.data('input-id');
               var folder   = li.children('.folder-name').html();

               var _label = '';
               var _parents = li.parents('li').children('.folder-name');
               for (i = _parents.length -1 ; i >= 0; i--) {
                  _label += $(_parents[i]).html() + '/';
               }
               _label += folder;

               $('#'+input_id).val(_label);
               $('#imap-folder').dialog('close');
            })
         });");
      }
      return true;
   }

   /**
    * Display the list of folder for current connections
    *
    * @since 9.3.1
    *
    * @param string $input_id dom id where to insert folder name
    *
    * @return void
    */
   public function displayFoldersList($input_id = "") {
      try {
         $this->connect();
      } catch (Throwable $e) {
         Toolbox::logError(
            'An error occured trying to connect to collector.',
            $e->getMessage(),
            "\n",
            $e->getTraceAsString()
         );
         echo __('An error occured trying to connect to collector.');
         return;
      }

      $folders = $this->storage->getFolders();
      $hasFolders = false;
      echo "<ul class='select_folder'>";
      foreach ($folders as $folder) {
         $hasFolders = true;
         $this->displayFolder($folder, $input_id);
      }

      if ($hasFolders === false && !empty($this->fields['server_mailbox'])) {
         echo "<li>";
         echo sprintf(
            __("No child found for folder '%s'."),
            Html::entities_deep($this->fields['server_mailbox'])
         );
         echo "</li>";
      }
      echo "</ul>";
   }


   /**
    * Display recursively a folder and its children
    *
    * @param \Laminas\Mail\Storage\Folder $folder   Current folder
    * @param string                       $input_id Input ID
    *
    * @return void
    */
   private function displayFolder($folder, $input_id) {
      echo "<ul>";
      $fname = mb_convert_encoding($folder->getLocalName(), "UTF-8", "UTF7-IMAP");
      echo "<li class='pointer' data-input-id='$input_id'>
               <i class='fa fa-folder'></i>&nbsp;
               <span class='folder-name'>".$fname."</span>";

      foreach ($folder as $sfolder) {
         $this->displayFolder($sfolder, $input_id);
      }

      echo "</li>";
      echo "</ul>";
   }


   function showGetMessageForm($ID) {

      echo "<br><br><div class='center'>";
      echo "<form name='form' method='post' action='".Toolbox::getItemTypeFormURL(__CLASS__)."'>";
      echo "<table class='tab_cadre'>";
      echo "<tr class='tab_bg_2'><td class='center'>";
      echo "<input type='submit' name='get_mails' value=\""._sx('button', 'Get email tickets now').
             "\" class='submit'>";
      echo "<input type='hidden' name='id' value='$ID'>";
      echo "</td></tr>";
      echo "</table>";
      Html::closeForm();
      echo "</div>";
   }


   function rawSearchOptions() {
      $tab = [];

      $tab[] = [
         'id'                 => 'common',
         'name'               => __('Characteristics')
      ];

      $tab[] = [
         'id'                 => '1',
         'table'              => $this->getTable(),
         'field'              => 'name',
         'name'               => __('Name'),
         'datatype'           => 'itemlink',
         'massiveaction'      => false,
         'autocomplete'       => true,
      ];

      $tab[] = [
         'id'                 => '2',
         'table'              => $this->getTable(),
         'field'              => 'is_active',
         'name'               => __('Active'),
         'datatype'           => 'bool'
      ];

      $tab[] = [
         'id'                 => '3',
         'table'              => $this->getTable(),
         'field'              => 'host',
         'name'               => __('Connection string'),
         'massiveaction'      => false,
         'datatype'           => 'string'
      ];

      $tab[] = [
         'id'                 => '4',
         'table'              => $this->getTable(),
         'field'              => 'login',
         'name'               => __('Login'),
         'massiveaction'      => false,
         'datatype'           => 'string',
         'autocomplete'       => true,
      ];

      $tab[] = [
         'id'                 => '5',
         'table'              => $this->getTable(),
         'field'              => 'filesize_max',
         'name'               => __('Maximum size of each file imported by the mails receiver'),
         'datatype'           => 'integer'
      ];

      $tab[] = [
         'id'                 => '16',
         'table'              => $this->getTable(),
         'field'              => 'comment',
         'name'               => __('Comments'),
         'datatype'           => 'text'
      ];

      $tab[] = [
         'id'                 => '19',
         'table'              => $this->getTable(),
         'field'              => 'date_mod',
         'name'               => __('Last update'),
         'datatype'           => 'datetime',
         'massiveaction'      => false
      ];

      $tab[] = [
         'id'                 => '20',
         'table'              => $this->getTable(),
         'field'              => 'accepted',
         'name'               => __('Accepted mail archive folder (optional)'),
         'datatype'           => 'string'
      ];

      $tab[] = [
         'id'                 => '21',
         'table'              => $this->getTable(),
         'field'              => 'refused',
         'name'               => __('Refused mail archive folder (optional)'),
         'datatype'           => 'string'
      ];

      $tab[] = [
         'id'                 => '22',
         'table'              => $this->getTable(),
         'field'              => 'errors',
         'name'               => __('Connection errors'),
         'datatype'           => 'integer'
      ];

      return $tab;
   }


   /**
    * @param $emails_ids   array
    * @param $action                (default 0)
    * @param $entity                (default 0)
   **/
   function deleteOrImportSeveralEmails($emails_ids = [], $action = 0, $entity = 0) {
      global $DB;

      $query = [
         'FROM'   => NotImportedEmail::getTable(),
         'WHERE'  => [
            'id' => $emails_ids,
         ],
         'ORDER'  => 'mailcollectors_id'
      ];

      $todelete = [];
      foreach ($DB->request($query) as $data) {
         $todelete[$data['mailcollectors_id']][$data['messageid']] = $data;
      }

      foreach ($todelete as $mailcollector_id => $rejected) {
         $collector = new self();
         if ($collector->getFromDB($mailcollector_id)) {
            // Use refused folder in connection string
            $connect_config = Toolbox::parseMailServerConnectString($collector->fields['host']);
            $collector->fields['host'] = Toolbox::constructMailServerConfig(
               [
                  'mail_server'   => $connect_config['address'],
                  'server_port'   => $connect_config['port'],
                  'server_type'   => !empty($connect_config['type']) ? '/' . $connect_config['type'] : '',
                  'server_ssl'    => $connect_config['ssl'] ? '/ssl' : '',
                  'server_cert'   => $connect_config['validate-cert'] ? '/validate-cert' : '/novalidate-cert',
                  'server_tls'    => $connect_config['tls'] ? '/tls' : '',
                  'server_rsh'    => $connect_config['norsh'] ? '/norsh' : '',
                  'server_secure' => $connect_config['secure'] ? '/secure' : '',
                  'server_debug'  => $connect_config['debug'] ? '/debug' : '',
                  'server_mailbox' => $collector->fields[self::REFUSED_FOLDER],
               ]
            );

            $collector->uid          = -1;
            //Connect to the Mail Box
            try {
               $collector->connect();
            } catch (Throwable $e) {
               Toolbox::logError(
                  'An error occured trying to connect to collector.',
                  $e->getMessage(),
                  "\n",
                  $e->getTraceAsString()
               );
               continue;
            }

            foreach ($collector->storage as $uid => $message) {
               $head = $collector->getHeaders($message);
               if (isset($rejected[$head['message_id']])) {
                  if ($action == 1) {
                     $tkt = $collector->buildTicket(
                        $uid,
                        $message,
                        [
                           'mailgates_id' => $mailcollector_id,
                           'play_rules'   => false
                        ]
                     );
                     $tkt['_users_id_requester'] = $rejected[$head['message_id']]['users_id'];
                     $tkt['entities_id']         = $entity;

                     if (!isset($tkt['tickets_id'])) {
                        // New ticket case
                        $ticket = new Ticket();
                        $ticket->add($tkt);
                     } else {
                        // Followup case
                        $fup = new ITILFollowup();

                        $fup_input = $tkt;
                        $fup_input['itemtype'] = Ticket::class;
                        $fup_input['items_id'] = $fup_input['tickets_id'];

                        $fup->add($fup_input);
                     }

                     $folder = self::ACCEPTED_FOLDER;
                  } else {
                     $folder = self::REFUSED_FOLDER;
                  }
                  //Delete email
                  if ($collector->deleteMails($uid, $folder)) {
                     $rejectedmail = new NotImportedEmail();
                     $rejectedmail->delete(['id' => $rejected[$head['message_id']]['id']]);
                  }
                  // Unset managed
                  unset($rejected[$head['message_id']]);
               }
            }

            // Email not present in mailbox
            if (count($rejected)) {
               $clean = [
                  '<' => '',
                  '>' => ''
               ];
               foreach ($rejected as $id => $data) {
                  if ($action == 1) {
                     Session::addMessageAfterRedirect(
                        sprintf(
                           __('Email %s not found. Impossible import.'),
                           strtr($id, $clean)
                        ),
                        false,
                        ERROR
                     );
                  } else { // Delete data in notimportedemail table
                     $rejectedmail = new NotImportedEmail();
                     $rejectedmail->delete(['id' => $data['id']]);
                  }
               }
            }
         }
      }
   }


   /**
    * Do collect
    *
    * @param integer $mailgateID  ID of the mailgate
    * @param boolean $display     display messages in MessageAfterRedirect or just return error (default 0=)
    *
    * @return string|void
   **/
   function collect($mailgateID, $display = 0) {
      global $CFG_GLPI, $GLPI;

      if ($this->getFromDB($mailgateID)) {
         $this->uid          = -1;
         $this->fetch_emails = 0;
         //Connect to the Mail Box
         try {
            $this->connect();
         } catch (Throwable $e) {
            Toolbox::logError(
               'An error occured trying to connect to collector.',
               $e->getMessage(),
               "\n",
               $e->getTraceAsString()
            );
            Session::addMessageAfterRedirect(
               __('An error occured trying to connect to collector.') . "<br/>" . $e->getMessage(),
               false,
               ERROR
            );
            return;
         }

         $rejected = new NotImportedEmail();
         // Clean from previous collect (from GUI, cron already truncate the table)
         $rejected->deleteByCriteria(['mailcollectors_id' => $this->fields['id']]);

         if ($this->storage) {
            $error            = 0;
            $refused          = 0;
            $alreadyseen      = 0;
            $blacklisted      = 0;
            // Get Total Number of Unread Email in mail box
            $count_messages   = $this->getTotalMails();
            $delete           = [];
            $messages         = [];

            do {
               $this->storage->next();
               if (!$this->storage->valid()) {
                  break;
               }

               try {
                  $this->fetch_emails++;
                  $messages[$this->storage->getUniqueId($this->storage->key())] = $this->storage->current();
               } catch (\Exception $e) {
                  $GLPI->getErrorHandler()->handleException($e);
                  Toolbox::logInFile(
                     'mailgate',
                     sprintf(
                        __('Message is invalid (%s). Check in "%s" for more details')."\n",
                        $e->getMessage(),
                        GLPI_LOG_DIR . '/php-errors.log'
                     )
                  );
                  ++$error;
               }
            } while ($this->fetch_emails < $this->maxfetch_emails);

            foreach ($messages as $uid => $message) {

               $rejinput = [
                  'mailcollectors_id' => $mailgateID,
                  'from'              => '',
                  'to'                => '',
                  'messageid'         => '',
                  'date'              => $_SESSION["glpi_currenttime"],
               ];

               //prevent loop when message is read but when it's impossible to move / delete
               //due to mailbox problem (ie: full)
               if ($this->fields['collect_only_unread'] && $message->hasFlag(Storage::FLAG_SEEN)) {
                  ++$alreadyseen;
                  continue;
               }

               try {
                  $tkt = $this->buildTicket(
                     $uid,
                     $message,
                     [
                        'mailgates_id' => $mailgateID,
                        'play_rules'   => true
                     ]
                  );

                  $headers = $this->getHeaders($message);

                  $requester = $this->getRequesterEmail($message);

                  if (!$tkt['_blacklisted']) {
                     global $DB;
                     $rejinput['from']              = $requester;
                     $rejinput['to']                = $headers['to'];
                     $rejinput['users_id']          = $tkt['_users_id_requester'];
                     $rejinput['subject']           = $DB->escape($this->cleanSubject($headers['subject']));
                     $rejinput['messageid']         = $headers['message_id'];
                  }
               } catch (Throwable $e) {
                  $error++;
                  $GLPI->getErrorHandler()->handleException($e);
                  Toolbox::logInFile(
                     'mailgate',
                     sprintf(
                        __('Error during message parsing (%s). Check in "%s" for more details')."\n",
                        $e->getMessage(),
                        GLPI_LOG_DIR . '/php-errors.log'
                     )
                  );
                  $rejinput['reason'] = NotImportedEmail::FAILED_OPERATION;
                  $rejected->add($rejinput);
                  continue;
               }

               $is_user_anonymous = !(isset($tkt['_users_id_requester'])
                                      && ($tkt['_users_id_requester'] > 0));
               $is_supplier_anonymous = !(isset($tkt['_supplier_email'])
                                          && $tkt['_supplier_email']);

               // Keep track of the mail author so we can check his
               // notifications preferences later (glpinotification_to_myself)
               if (isset($tkt['users_id']) && $tkt['users_id']) {
                  $_SESSION['mailcollector_user'] = $tkt['users_id'];
               } else if (isset($tkt['_users_id_requester_notif']['alternative_email'][0])) {
                  // Special case when we have no users_id (anonymous helpdesk)
                  // -> use the user email instead
                  $_SESSION['mailcollector_user'] = $tkt["_users_id_requester_notif"]['alternative_email'][0];
               }

               if (isset($tkt['_blacklisted']) && $tkt['_blacklisted']) {
                  $delete[$uid] =  self::REFUSED_FOLDER;
                  $blacklisted++;
               } else if (isset($tkt['_refuse_email_with_response'])) {
                  $delete[$uid] =  self::REFUSED_FOLDER;
                  $refused++;
                  $this->sendMailRefusedResponse($requester, $tkt['name']);

               } else if (isset($tkt['_refuse_email_no_response'])) {
                  $delete[$uid] =  self::REFUSED_FOLDER;
                  $refused++;

               } else if (isset($tkt['entities_id'])
                          && !isset($tkt['tickets_id'])
                          && ($CFG_GLPI["use_anonymous_helpdesk"]
                              || !$is_user_anonymous
                              || !$is_supplier_anonymous)) {

                  // New ticket case
                  $ticket = new Ticket();

                  if (!$CFG_GLPI["use_anonymous_helpdesk"]
                      && !Profile::haveUserRight($tkt['_users_id_requester'],
                                                 Ticket::$rightname,
                                                 CREATE,
                                                 $tkt['entities_id'])) {
                     $delete[$uid] =  self::REFUSED_FOLDER;
                     $refused++;
                     $rejinput['reason'] = NotImportedEmail::NOT_ENOUGH_RIGHTS;
                     $rejected->add($rejinput);
                  } else if ($ticket->add($tkt)) {
                     $delete[$uid] =  self::ACCEPTED_FOLDER;
                  } else {
                     $error++;
                     $rejinput['reason'] = NotImportedEmail::FAILED_OPERATION;
                     $rejected->add($rejinput);
                  }

               } else if (isset($tkt['tickets_id'])
                          && ($CFG_GLPI['use_anonymous_followups'] || !$is_user_anonymous)) {

                  // Followup case
                  $ticket = new Ticket();
                  $ticketExist = $ticket->getFromDB($tkt['tickets_id']);
                  $fup = new ITILFollowup();

                  $fup_input = $tkt;
                  $fup_input['itemtype'] = Ticket::class;
                  $fup_input['items_id'] = $fup_input['tickets_id'];
                  unset($fup_input['tickets_id']);

                  if ($ticketExist && Entity::getUsedConfig(
                        'suppliers_as_private',
                        $ticket->fields['entities_id']
                     )) {
                     // Get suppliers matching the from email
                     $suppliers = Supplier::getSuppliersByEmail(
                        $rejinput['from']
                     );

                     foreach ($suppliers as $supplier) {
                        // If the supplier is assigned to this ticket then
                        // the followup must be private
                        if ($ticket->isSupplier(
                              CommonITILActor::ASSIGN,
                              $supplier['id'])
                           ) {
                           $fup_input['is_private'] = true;
                           break;
                        }
                     }
                  }

                  if (!$ticketExist) {
                     $error++;
                     $rejinput['reason'] = NotImportedEmail::FAILED_OPERATION;
                     $rejected->add($rejinput);
                  } else if (!$CFG_GLPI['use_anonymous_followups']
                             && !$ticket->canUserAddFollowups($tkt['_users_id_requester'])) {
                     $delete[$uid] =  self::REFUSED_FOLDER;
                     $refused++;
                     $rejinput['reason'] = NotImportedEmail::NOT_ENOUGH_RIGHTS;
                     $rejected->add($rejinput);
                  } else if ($fup->add($fup_input)) {
                     $delete[$uid] =  self::ACCEPTED_FOLDER;
                  } else {
                     $error++;
                     $rejinput['reason'] = NotImportedEmail::FAILED_OPERATION;
                     $rejected->add($rejinput);
                  }

               } else {
                  if ($is_user_anonymous && !$CFG_GLPI["use_anonymous_helpdesk"]) {
                     $rejinput['reason'] = NotImportedEmail::USER_UNKNOWN;

                  } else {
                     $rejinput['reason'] = NotImportedEmail::MATCH_NO_RULE;
                  }
                  $refused++;
                  $rejected->add($rejinput);
                  $delete[$uid] =  self::REFUSED_FOLDER;
               }

               // Clean mail author used for notification settings
               unset($_SESSION['mailcollector_user']);
            }

            krsort($delete);
            foreach ($delete as $uid => $folder) {
               $this->deleteMails($uid, $folder);
            }

            //TRANS: %1$d, %2$d, %3$d, %4$d %5$d and %6$d are number of messages
            $msg = sprintf(
               __('Number of messages: available=%1$d, already imported=%2$d, retrieved=%3$d, refused=%4$d, errors=%5$d, blacklisted=%6$d'),
               $count_messages,
               $alreadyseen,
               $this->fetch_emails - $alreadyseen,
               $refused,
               $error,
               $blacklisted
            );
            if ($display) {
               Session::addMessageAfterRedirect($msg, false, ($error ? ERROR : INFO));
            } else {
               return $msg;
            }

         } else {
            $msg = __('Could not connect to mailgate server');
            if ($display) {
               Session::addMessageAfterRedirect($msg, false, ERROR);
            } else {
               return $msg;
            }
         }

      } else {
         //TRANS: %s is the ID of the mailgate
         $msg = sprintf(__('Could not find mailgate %d'), $mailgateID);
         if ($display) {
            Session::addMessageAfterRedirect($msg, false, ERROR);
         } else {
            return $msg;
         }
      }
   }


   /**
    * Builds and returns the main structure of the ticket to be created
    *
    * @param string                        $uid     UID of the message
    * @param \Laminas\Mail\Storage\Message $message  Messge
    * @param array                         $options  Possible options
    *
    * @return array ticket fields
    */
   function buildTicket($uid, \Laminas\Mail\Storage\Message $message, $options = []) {
      global $CFG_GLPI;

      $play_rules = (isset($options['play_rules']) && $options['play_rules']);
      $headers = $this->getHeaders($message);

      $tkt                 = [];
      $tkt['_blacklisted'] = false;
      // For RuleTickets
      $tkt['_mailgate']    = $options['mailgates_id'];
      $tkt['_uid']         = $uid;

      // Use mail date if it's defined
      if ($this->fields['use_mail_date'] && isset($headers['date'])) {
         $tkt['date'] = $headers['date'];
      }

      if ($this->isMessageSentByGlpi($message)) {
         // Message was sent by GLPI.
         // Message is blacklisted to avoid infinite loop (where GLPI creates a ticket from its own notification).
         $tkt['_blacklisted'] = true;
         return $tkt;
      }

      // manage blacklist
      $blacklisted_emails   = Blacklist::getEmails();
      // Add name of the mailcollector as blacklisted
      $blacklisted_emails[] = $this->fields['name'];
      if (Toolbox::inArrayCaseCompare($headers['from'], $blacklisted_emails)) {
         $tkt['_blacklisted'] = true;
         return $tkt;
      }

      // max size = 0 : no import attachments
      if ($this->fields['filesize_max'] > 0) {
         if (is_writable(GLPI_TMP_DIR)) {
            $tkt['_filename'] = $this->getAttached($message, GLPI_TMP_DIR."/", $this->fields['filesize_max']);
            $tkt['_tag']      = $this->tags;
         } else {
            //TRANS: %s is a directory
            Toolbox::logInFile('mailgate', sprintf(__('%s is not writable'), GLPI_TMP_DIR."/"));
         }
      }

      //  Who is the user ?
      $requester = $this->getRequesterEmail($message);

      $tkt['_users_id_requester']                              = User::getOrImportByEmail($requester);
      $tkt["_users_id_requester_notif"]['use_notification'][0] = 1;
      // Set alternative email if user not found / used if anonymous mail creation is enable
      if (!$tkt['_users_id_requester']) {
         $tkt["_users_id_requester_notif"]['alternative_email'][0] = $requester;
      }

      // Fix author of attachment
      // Move requester to author of followup
      $tkt['users_id'] = $tkt['_users_id_requester'];

      // Add to and cc as additional observer if user found
      $ccs = $headers['ccs'];
      if (is_array($ccs) && count($ccs) && $this->getField("add_cc_to_observer")) {
         foreach ($ccs as $cc) {
            if ($cc != $requester
               && !Toolbox::inArrayCaseCompare($cc, $blacklisted_emails) // not blacklisted emails
            ) {
               // Skip if user is anonymous and anonymous users are not allowed
               $user_id = User::getOrImportByEmail($cc);
               if (!$user_id && !$CFG_GLPI['use_anonymous_helpdesk']) {
                  continue;
               }

               $nb = (isset($tkt['_users_id_observer']) ? count($tkt['_users_id_observer']) : 0);
               $tkt['_users_id_observer'][$nb] = $user_id;
               $tkt['_users_id_observer_notif']['use_notification'][$nb] = 1;
               $tkt['_users_id_observer_notif']['alternative_email'][$nb] = $cc;
            }
         }
      }

      $tos = $headers['tos'];
      if (is_array($tos) && count($tos)) {
         foreach ($tos as $to) {
            if ($to != $requester
               && !Toolbox::inArrayCaseCompare($to, $blacklisted_emails) // not blacklisted emails
            ) {
               // Skip if user is anonymous and anonymous users are not allowed
               $user_id = User::getOrImportByEmail($to);
               if (!$user_id && !$CFG_GLPI['use_anonymous_helpdesk']) {
                  continue;
               }

               $nb = (isset($tkt['_users_id_observer']) ? count($tkt['_users_id_observer']) : 0);
               $tkt['_users_id_observer'][$nb] = $user_id;
               $tkt['_users_id_observer_notif']['use_notification'][$nb] = 1;
               $tkt['_users_id_observer_notif']['alternative_email'][$nb] = $to;
            }
         }
      }

      // Auto_import
      $tkt['_auto_import']           = 1;
      // For followup : do not check users_id = login user
      $tkt['_do_not_check_users_id'] = 1;
      $tkt['_head'] = $headers;
      $body                          = $this->getBody($message);

      try {
         $subject = $message->getHeader('subject')->getFieldValue();
      } catch (Laminas\Mail\Storage\Exception\InvalidArgumentException $e) {
         $subject = null;
      }
      $tkt['_message']  = $message;

      if (!Toolbox::seems_utf8($body)) {
         $tkt['content'] = Toolbox::encodeInUtf8($body);
      } else {
         $tkt['content'] = $body;
      }

      // Search for referenced item in headers
      $found_item = $this->getItemFromHeaders($message);
      if ($found_item instanceof Ticket) {
         $tkt['tickets_id'] = $found_item->fields['id'];
      }

      // See in title
      if (!isset($tkt['tickets_id'])
          && !is_null($subject)
          && preg_match('/\[.+#(\d+)\]/', $subject, $match)) {
         $tkt['tickets_id'] = intval($match[1]);
      }

      $tkt['_supplier_email'] = false;
      // Found ticket link
      if (isset($tkt['tickets_id'])) {
         // it's a reply to a previous ticket
         $job = new Ticket();
         $tu  = new Ticket_User();
         $st  = new Supplier_Ticket();

         // Check if ticket  exists and users_id exists in GLPI
         if ($job->getFromDB($tkt['tickets_id'])
             && ($job->fields['status'] != CommonITILObject::CLOSED)
             && ($CFG_GLPI['use_anonymous_followups']
                 || ($tkt['_users_id_requester'] > 0)
                 || $tu->isAlternateEmailForITILObject($tkt['tickets_id'], $requester)
                 || ($tkt['_supplier_email'] = $st->isSupplierEmail($tkt['tickets_id'],
                                                                    $requester)))) {

            if ($tkt['_supplier_email']) {
               $tkt['content'] = sprintf(__('From %s'), $requester)."\n\n".$tkt['content'];
            }

            $header_tag      = NotificationTargetTicket::HEADERTAG;
            $header_pattern  = $header_tag . '.*' . $header_tag;
            $footer_tag      = NotificationTargetTicket::FOOTERTAG;
            $footer_pattern  = $footer_tag . '.*' . $footer_tag;

            $has_header_line = preg_match('/' . $header_pattern . '/s', $tkt['content']);
            $has_footer_line = preg_match('/' . $footer_pattern . '/s', $tkt['content']);

            if ($has_header_line && $has_footer_line) {
               // Strip all contents between header and footer line
               $tkt['content'] = preg_replace(
                  '/' . $header_pattern . '.*' . $footer_pattern . '/s',
                  '',
                  $tkt['content']
               );
            } else if ($has_header_line) {
               // Strip all contents between header line and end of message
               $tkt['content'] = preg_replace(
                  '/' . $header_pattern . '.*$/s',
                  '',
                  $tkt['content']
               );
            } else if ($has_footer_line) {
               // Strip all contents between begin of message and footer line
               $tkt['content'] = preg_replace(
                  '/^.*' . $footer_pattern . '/s',
                  '',
                  $tkt['content']
               );
            }
         } else {
            // => to handle link in Ticket->post_addItem()
            $tkt['_linkedto'] = $tkt['tickets_id'];
            unset($tkt['tickets_id']);
         }
      }

      // Add message from getAttached
      if ($this->addtobody) {
         $tkt['content'] .= $this->addtobody;
      }

      //If files are present and content is html
      if (isset($this->files) && count($this->files) && $this->body_is_html) {
         $tkt['content'] = Ticket::convertContentForTicket($tkt['content'],
                                                           $this->files + $this->altfiles,
                                                           $this->tags);
      }

      // Clean mail content
      $tkt['content'] = $this->cleanContent($tkt['content']);

      $tkt['name'] = $this->cleanSubject($subject);
      if (!Toolbox::seems_utf8($tkt['name'])) {
         $tkt['name'] = Toolbox::encodeInUtf8($tkt['name']);
      }

      if (!isset($tkt['tickets_id'])) {
         // Which entity ?
         //$tkt['entities_id']=$this->fields['entities_id'];
         //$tkt['Subject']= $message->subject;   // not use for the moment
         // Medium
         $tkt['urgency']  = "3";
         // No hardware associated
         $tkt['itemtype'] = "";
         // Mail request type

      } else {
         // Reopen if needed
         $tkt['add_reopen'] = 1;
      }

      $tkt['requesttypes_id'] = RequestType::getDefault('mail');

      if ($play_rules) {
         $rule_options['ticket']              = $tkt;
         $rule_options['headers']             = $this->getHeaders($message);
         $rule_options['mailcollector']       = $options['mailgates_id'];
         $rule_options['_users_id_requester'] = $tkt['_users_id_requester'];
         $rulecollection                      = new RuleMailCollectorCollection();
         $output                              = $rulecollection->processAllRules([], [],
                                                                                 $rule_options);

         // New ticket : compute all
         if (!isset($tkt['tickets_id'])) {
            foreach ($output as $key => $value) {
               $tkt[$key] = $value;
            }

         } else { // Followup only copy refuse data
            $tkt['requesttypes_id'] = RequestType::getDefault('mailfollowup');
            $tobecopied = ['_refuse_email_no_response', '_refuse_email_with_response'];
            foreach ($tobecopied as $val) {
               if (isset($output[$val])) {
                  $tkt[$val] = $output[$val];
               }
            }
         }
      }
      if (!is_null($tkt['content'])) {
         $tkt['content'] = LitEmoji::encodeShortcode($tkt['content']);
      }
      if (!is_null($tkt['name'])) {
         $tkt['name'] = LitEmoji::encodeShortcode($tkt['name']);
      }

      $tkt = Toolbox::addslashes_deep($tkt);
      return $tkt;
   }


   /**
    * Clean mail content : HTML + XSS + blacklisted content
    *
    * @since 0.85
    *
    * @param string $string text to clean
    *
    * @return string cleaned text
   **/
   function cleanContent($string) {
      global $DB;

      if (is_null($string)) {
         return null;
      }

      // Clean HTML
      $string = Html::clean(Html::entities_deep($string), false, 2);

      $br_marker = '==' . mt_rand() . '==';

      // Replace HTML line breaks to marker
      $string = preg_replace('/<br\s*\/?>/', $br_marker, $string);

      // Replace plain text line breaks to marker if content is not html
      // and rich text mode is enabled (otherwise remove them)
      $string = str_replace(
         ["\r\n", "\n", "\r"],
         $this->body_is_html ? ' ' : $br_marker,
         $string
      );

      // Wrap content for blacklisted items
      $itemstoclean = [];
      foreach ($DB->request('glpi_blacklistedmailcontents') as $data) {
         $toclean = trim($data['content']);
         if (!empty($toclean)) {
            $itemstoclean[] = str_replace(["\r\n", "\n", "\r"], $br_marker, $toclean);
         }
      }
      if (count($itemstoclean)) {
         $string = str_replace($itemstoclean, '', $string);
      }

      $string = str_replace($br_marker, "<br />", $string);

      // Double encoding for > and < char to avoid misinterpretations
      $string = str_replace(['&lt;', '&gt;'], ['&amp;lt;', '&amp;gt;'], $string);

      // Prevent XSS
      $string = Toolbox::clean_cross_side_scripting_deep($string);

      return $string;
   }


   /**
    * Strip out unwanted/unprintable characters from the subject
    *
    * @param string $text text to clean
    *
    * @return string clean text
   **/
   function cleanSubject($text) {
      if (is_null($text)) {
         return null;
      }
      $text = str_replace("=20", "\n", $text);
      $text =  Toolbox::clean_cross_side_scripting_deep($text);
      return $text;
   }


   ///return supported encodings in lowercase.
   function listEncodings() {
      // Encoding not listed
      static $enc = ['gb2312', 'gb18030'];

      if (count($enc) == 2) {
         foreach (mb_list_encodings() as $encoding) {
            $enc[]   = Toolbox::strtolower($encoding);
            $aliases = mb_encoding_aliases($encoding);
            foreach ($aliases as $e) {
               $enc[] = Toolbox::strtolower($e);
            }
         }
      }
      return $enc;
   }


   /**
    * Connect to the mail box
    *
    * @return void
    */
   function connect() {
      $config = Toolbox::parseMailServerConnectString($this->fields['host']);

      $params = [
         'host'      => $config['address'],
         'user'      => $this->fields['login'],
         'password'  => Toolbox::sodiumDecrypt($this->fields['passwd']),
         'port'      => $config['port']
      ];

      if ($config['ssl']) {
         $params['ssl'] = 'SSL';
      }

      if ($config['tls']) {
         $params['ssl'] = 'TLS';
      }

      if (!empty($config['mailbox'])) {
         $params['folder'] = $config['mailbox'];
      }

      if ($config['validate-cert'] === false) {
         $params['novalidatecert'] = true;
      }

      try {
         $storage = Toolbox::getMailServerStorageInstance($config['type'], $params);
         if ($storage === null) {
            throw new \Exception(sprintf(__('Unsupported mail server type:%s.'), $config['type']));
         }
         $this->storage = $storage;
         if ($this->fields['errors'] > 0) {
            $this->update([
               'id'     => $this->getID(),
               'errors' => 0
            ]);
         }
      } catch (\Exception $e) {
         $this->update([
            'id'     => $this->getID(),
            'errors' => ($this->fields['errors']+1)
         ]);
         // Any errors will cause an Exception.
         throw $e;
      }
   }


   /**
    * Get extra headers
    *
    * @param \Laminas\Mail\Storage\Message $message Message
    *
    * @return array
   **/
   function getAdditionnalHeaders(\Laminas\Mail\Storage\Message $message) {
      $head   = [];
      $headers = $message->getHeaders();

      foreach ($headers as $header) {
         // is line with additional header?
         $key = $header->getFieldName();
         $value = $header->getFieldValue();
         if (preg_match("/^X-/i", $key)
               || preg_match("/^Auto-Submitted/i", $key)
               || preg_match("/^Received/i", $key)) {
            $key = Toolbox::strtolower($key);
            if (!isset($head[$key])) {
               $head[$key] = '';
            } else {
               $head[$key] .= "\n";
            }
            $head[$key] .= trim($value);
         }
      }

      return $head;
   }


   /**
    * Get full headers infos from particular mail
    *
    * @param \Laminas\Mail\Storage\Message $message Message
    *
    * @return array Associative array with following keys
    *                subject   => Subject of Mail
    *                to        => To Address of that mail
    *                toOth     => Other To address of mail
    *                toNameOth => To Name of Mail
    *                from      => From address of mail
    *                fromName  => Form Name of Mail
   **/
   function getHeaders(\Laminas\Mail\Storage\Message $message) {

      $sender_email = $this->getEmailFromHeader($message, 'from');

      $to = $this->getEmailFromHeader($message, 'to');

      $reply_to_addr = Toolbox::strtolower($this->getEmailFromHeader($message, 'reply-to'));

      $date         = date("Y-m-d H:i:s", strtotime($message->date));
      $mail_details = [];

      // Construct to and cc arrays
      $tos     = [];
      if (isset($message->to)) {
         $h_tos   = $message->getHeader('to');
         foreach ($h_tos->getAddressList() as $address) {
            $mailto = Toolbox::strtolower($address->getEmail());
            if ($mailto === $this->fields['name']) {
               $to = $mailto;
            }
            $tos[] = $mailto;
         }
      }

      $ccs     = [];
      if (isset($message->cc)) {
         $h_ccs   = $message->getHeader('cc');
         foreach ($h_ccs->getAddressList() as $address) {
            $ccs[] = Toolbox::strtolower($address->getEmail());
         }
      }

      // secu on subject setting
      try {
         $subject = $message->getHeader('subject')->getFieldValue();
      } catch (Laminas\Mail\Storage\Exception\InvalidArgumentException $e) {
         $subject = '';
      }

      $mail_details = [
         'from'       => Toolbox::strtolower($sender_email),
         'subject'    => $subject,
         'reply-to'   => $reply_to_addr,
         'to'         => Toolbox::strtolower($to),
         'message_id' => $message->getHeader('message_id')->getFieldValue(),
         'tos'        => $tos,
         'ccs'        => $ccs,
         'date'       => $date
      ];

      if (isset($message->references)) {
         if ($reference = $message->getHeader('references')) {
            $mail_details['references'] = $reference->getFieldValue();
         }
      }

      if (isset($message->in_reply_to)) {
         if ($inreplyto = $message->getHeader('in_reply_to')) {
            $mail_details['in_reply_to'] = $inreplyto->getFieldValue();
         }
      }

      //Add additional headers in X-
      foreach ($this->getAdditionnalHeaders($message) as $header => $value) {
         $mail_details[$header] = $value;
      }

      return $mail_details;
   }


   /**
    * Number of entries in the mailbox
    *
    * @return integer
   **/
   function getTotalMails() {
      return $this->storage->countMessages();
   }


   /**
    * Recursivly get attached documents
    * Result is stored in $this->files
    *
    * @param \Laminas\Mail\Storage\Part $part     Message part
    * @param string                     $path     Temporary path
    * @param integer                    $maxsize  Maximum size of document to be retrieved
    * @param string                     $subject  Message subject
    * @param string                     $subpart  Subpart index (used in document filenames)
    *
    * @return void
   **/
   private function getRecursiveAttached(\Laminas\Mail\Storage\Part $part, $path, $maxsize, $subject, $subpart = "") {
      if ($part->isMultipart()) {
         $index = 0;
         foreach (new RecursiveIteratorIterator($part) as $mypart) {
            $this->getRecursiveAttached(
               $mypart,
               $path,
               $maxsize,
               $subject,
               ($subpart ? $subpart.".".($index+1) : ($index+1))
            );
         }
      } else {
         if (!$part->getHeaders()->has('content-type')
             || !(($content_type_header = $part->getHeader('content-type')) instanceof ContentType)) {
            return false; // Ignore attachements with no content-type
         }
         $content_type = $content_type_header->getType();

         if (!$part->getHeaders()->has('content-disposition') && preg_match('/^text\/.+/', $content_type)) {
            // Ignore attachements with no content-disposition only if they corresponds to a text part.
            // Indeed, some mail clients (like some Outlook versions) does not set any content-disposition
            // header on inlined images.
            return false;
         }

         // fix monoparted mail
         if ($subpart == "") {
            $subpart = 1;
         }

         $filename = '';

         // Try to get filename from Content-Disposition header
         if (empty($filename)
             && $part->getHeaders()->has('content-disposition')
             && ($content_disp_header = $part->getHeader('content-disposition')) instanceof ContentDisposition) {
            $filename = $content_disp_header->getParameter('filename') ?? '';
         }

         // Try to get filename from Content-Type header
         if (empty($filename)) {
            $filename = $content_type_header->getParameter('name') ?? '';
         }

         $filename_matches = [];
         if (preg_match("/^(?<encoding>.*)''(?<value>.*)$/", $filename, $filename_matches)
             && in_array(strtoupper($filename_matches['encoding']), array_map('strtoupper', mb_list_encodings()))) {
            // Filename is in RFC5987 format: UTF-8''urlencodedfilename.ext
            // First, urldecode it, then convert if into UTF-8 if needed.
            $filename = urldecode($filename_matches['value']);
            $encoding = strtoupper($filename_matches['encoding']);
            if ($encoding !== 'UTF-8') {
               $filename = mb_convert_encoding($filename, 'UTF-8', $encoding);
            }
         }

         // part come without correct filename in headers - generate trivial one
         // (inline images case for example)
         if ((empty($filename) || !Document::isValidDoc($filename))) {
            $tmp_filename = "doc_$subpart.".str_replace('image/', '', $content_type);
            if (Document::isValidDoc($tmp_filename)) {
               $filename = $tmp_filename;
            }
         }

         // Embeded email comes without filename - try to get "Subject:" or generate trivial one
         if (empty($filename)) {
            if ($subject !== null) {
               $filename = "msg_{$subpart}_" . Toolbox::slugify($subject) . ".EML";
            } else {
               $filename = "msg_$subpart.EML"; // default trivial one :)!
            }
         }

         // if no filename found, ignore this part
         if (empty($filename)) {
            return false;
         }

         $filename = Toolbox::filename($filename);

         //try to avoid conflict between inline image and attachment
         while (in_array($filename, $this->files)) {
            $info = new SplFileInfo($filename);
            $extension  = $info->getExtension();
            $basename = $info->getBaseName($extension == '' ? '' : '.' . $extension);

            //replace basename with basename_(num) by basename_(num+1)
            $matches = [];
            if (preg_match("/(.*)_([0-9]+)$/", $basename, $matches)) {
               //replace basename with basename_(num) by basename_(num+1)
               $filename = $matches[1] . '_' . ((int)$matches[2] + 1);
            } else {
               $filename .= '_2';
            }

            if ($extension != '') {
               $filename .= ".$extension";
            }
         }

         if ($part->getSize() > $maxsize) {
            $this->addtobody .= "\n\n".sprintf(__('%1$s: %2$s'), __('Too large attached file'),
                                               sprintf(__('%1$s (%2$s)'), $filename,
                                                       Toolbox::getSize($part->getSize())));
            return false;
         }

         if (!Document::isValidDoc($filename)) {
            //TRANS: %1$s is the filename and %2$s its mime type
            $this->addtobody .= "\n\n".sprintf(__('%1$s: %2$s'), __('Invalid attached file'),
                                               sprintf(__('%1$s (%2$s)'), $filename,
                                                       $content_type));
            return false;
         }

         $contents = $this->getDecodedContent($part);
         if (file_put_contents($path.$filename, $contents)) {
            $this->files[$filename] = $filename;
            // If embeded image, we add a tag
            if (preg_match('@image/.+@', $content_type)) {
               end($this->files);
               $tag = Rule::getUuid();
               $this->tags[$filename]  = $tag;

               // Link file based on Content-ID header
               if (isset($part->contentId)) {
                  $clean = ['<' => '',
                                 '>' => ''];
                  $this->altfiles[strtr($part->contentId, $clean)] = $filename;
               }
            }
         }
      } // Single part
   }


   /**
    * Get attached documents in a mail
    *
    * @param \Laminas\Mail\Storage\Message $message  Message
    * @param string                        $path     Temporary path
    * @param integer                       $maxsize  Maximaum size of document to be retrieved
    *
    * @return array containing extracted filenames in file/_tmp
   **/
   public function getAttached(\Laminas\Mail\Storage\Message $message, $path, $maxsize) {
      $this->files     = [];
      $this->altfiles  = [];
      $this->addtobody = "";

      try {
         $subject = $message->getHeader('subject')->getFieldValue();
      } catch (Laminas\Mail\Storage\Exception\InvalidArgumentException $e) {
         $subject = null;
      }

      $this->getRecursiveAttached($message, $path, $maxsize, $subject);

      return $this->files;
   }


   /**
    * Get The actual mail content from this mail
    *
    * @param \Laminas\Mail\Storage\Message $message Message
   **/
   function getBody(\Laminas\Mail\Storage\Message $message) {
      $content = null;

      $parts = !$message->isMultipart()
         ? new ArrayIterator([$message])
         : new RecursiveIteratorIterator($message);

      foreach ($parts as $part) {
         if (!$part->getHeaders()->has('content-type')
            || !(($content_type = $part->getHeader('content-type')) instanceof ContentType)) {
            continue;
         }
         if ($content_type->getType() == 'text/html') {
            $this->body_is_html = true;
            $content = $this->getDecodedContent($part);
            //do not check for text part if we found html one.
            break;
         }
         if ($content_type->getType() == 'text/plain' && $content === null) {
            $this->body_is_html = false;
            $content = $this->getDecodedContent($part);
         }
      }

      return $content;
   }


   /**
    * Delete mail from that mail box
    *
    * @param string $uid    mail UID
    * @param string $folder Folder to move (delete if empty) (default '')
    *
    * @return boolean
   **/
   function deleteMails($uid, $folder = '') {

      // Disable move support, POP protocol only has the INBOX folder
      if (strstr($this->fields['host'], "/pop")) {
         $folder = '';
      }

      if (!empty($folder) && isset($this->fields[$folder]) && !empty($this->fields[$folder])) {
         $name = mb_convert_encoding($this->fields[$folder], "UTF7-IMAP", "UTF-8");
         try {
            $this->storage->moveMessage($this->storage->getNumberByUniqueId($uid), $name);
            return true;
         } catch (\Exception $e) {
            // raise an error and fallback to delete
            trigger_error(
               sprintf(
                  //TRANS: %1$s is the name of the folder, %2$s is the name of the receiver
                  __('Invalid configuration for %1$s folder in receiver %2$s'),
                  $folder,
                  $this->getName()
               )
            );
         }
      }
      $this->storage->removeMessage($this->storage->getNumberByUniqueId($uid));
      return true;
   }


   /**
    * Cron action on mailgate : retrieve mail and create tickets
    *
    * @param $task
    *
    * @return -1 : done but not finish 1 : done with success
   **/
   public static function cronMailgate($task) {
      global $DB;

      NotImportedEmail::deleteLog();
      $iterator = $DB->request([
         'FROM'   => 'glpi_mailcollectors',
         'WHERE'  => ['is_active' => 1]
      ]);

      $max = $task->fields['param'];

      if (count($iterator) > 0) {
         $mc = new self();

         while (($max > 0)
                  && ($data = $iterator->next())) {
            $mc->maxfetch_emails = $max;

            $task->log("Collect mails from ".$data["name"]." (".$data["host"].")\n");
            $message = $mc->collect($data["id"]);

            $task->addVolume($mc->fetch_emails);
            $task->log("$message\n");

            $max -= $mc->fetch_emails;
         }
      }

      if ($max == $task->fields['param']) {
         return 0; // Nothin to do
      } else if ($max > 0) {
         return 1; // done
      }

      return -1; // still messages to retrieve
   }


   public static function cronInfo($name) {

      switch ($name) {
         case 'mailgate' :
            return [
               'description' => __('Retrieve email (Mails receivers)'),
               'parameter'   => __('Number of emails to retrieve')
            ];

         case 'mailgateerror' :
            return ['description' => __('Send alarms on receiver errors')];
      }
   }


   /**
    * Send Alarms on mailgate errors
    *
    * @since 0.85
    *
    * @param CronTask $task for log
   **/
   public static function cronMailgateError($task) {
      global $DB, $CFG_GLPI;

      if (!$CFG_GLPI["use_notifications"]) {
         return 0;
      }
      $cron_status   = 0;

      $iterator = $DB->request([
         'FROM'   => 'glpi_mailcollectors',
         'WHERE'  => [
            'errors'    => ['>', 0],
            'is_active' => 1
         ]
      ]);

      $items = [];
      while ($data = $iterator->next()) {
         $items[$data['id']]  = $data;
      }

      if (count($items)) {
         if (NotificationEvent::raiseEvent('error', new self(), ['items' => $items])) {
            $cron_status = 1;
            if ($task) {
               $task->setVolume(count($items));
            }
         }
      }
      return $cron_status;
   }


   function showSystemInformations($width) {
      global $CFG_GLPI, $DB;

      // No need to translate, this part always display in english (for copy/paste to forum)

      echo "<tr class='tab_bg_2'><th>Notifications</th></tr>\n";
      echo "<tr class='tab_bg_1'><td><pre>\n&nbsp;\n";

      $msg = 'Way of sending emails: ';
      switch ($CFG_GLPI['smtp_mode']) {
         case MAIL_MAIL :
            $msg .= 'PHP';
            break;

         case MAIL_SMTP :
            $msg .= 'SMTP';
            break;

         case MAIL_SMTPSSL :
            $msg .= 'SMTP+SSL';
            break;

         case MAIL_SMTPTLS :
            $msg .= 'SMTP+TLS';
            break;
      }
      if ($CFG_GLPI['smtp_mode'] != MAIL_MAIL) {
         $msg .= " (".(empty($CFG_GLPI['smtp_username']) ? 'anonymous' : $CFG_GLPI['smtp_username']).
                    "@".$CFG_GLPI['smtp_host'].")";
      }
      echo wordwrap($msg."\n", $width, "\n\t\t");
      echo "\n</pre></td></tr>";

      echo "<tr class='tab_bg_2'><th>Mails receivers</th></tr>\n";
      echo "<tr class='tab_bg_1'><td><pre>\n&nbsp;\n";

      foreach ($DB->request('glpi_mailcollectors') as $mc) {
         $msg  = "Name: '".$mc['name']."'";
         $msg .= " Active: " .($mc['is_active'] ? "Yes" : "No");
         echo wordwrap($msg."\n", $width, "\n\t\t");

         $msg  = "\tServer: '". $mc['host']."'";
         $msg .= " Login: '".$mc['login']."'";
         $msg .= " Password: ".(empty($mc['passwd']) ? "No" : "Yes");
         echo wordwrap($msg."\n", $width, "\n\t\t");
      }
      echo "\n</pre></td></tr>";
   }


   /**
    * @param $to        (default '')
    * @param $subject   (default '')
   **/
   function sendMailRefusedResponse($to = '', $subject = '') {
      global $CFG_GLPI;

      $mmail = new GLPIMailer();
      $mmail->AddCustomHeader("Auto-Submitted: auto-replied");
      $mmail->SetFrom($CFG_GLPI["admin_email"], $CFG_GLPI["admin_email_name"]);
      $mmail->AddAddress($to);
      // Normalized header, no translation
      $mmail->Subject  = 'Re: ' . $subject;
      $mmail->Body     = __("Your email could not be processed.\nIf the problem persists, contact the administrator").
                         "\n-- \n".$CFG_GLPI["mailing_signature"];
      $mmail->Send();
   }


   function title() {
      global $CFG_GLPI;

      $buttons = [];
      if (countElementsInTable($this->getTable())) {
         $buttons["notimportedemail.php"] = __('List of not imported emails');
      }

      $errors  = getAllDataFromTable($this->getTable(), ['errors' => ['>', 0]]);
      $message = '';
      if (count($errors)) {
         $servers = [];
         foreach ($errors as $data) {
            $this->getFromDB($data['id']);
            $servers[] = $this->getLink();
         }

         $message = sprintf(__('Receivers in error: %s'), implode(" ", $servers));
      }

      if (count($buttons)) {
         Html::displayTitle($CFG_GLPI["root_doc"] . "/pics/users.png",
                            _n('Receiver', 'Receivers', Session::getPluralNumber()), $message, $buttons);
      }

   }


   /**
    * Count collectors
    *
    * @param boolean $active Count active only, defaults to false
    *
    * @return integer
    */
   public static function countCollectors($active = false) {
      global $DB;

      $criteria = [
         'COUNT'  => 'cpt',
         'FROM'   => 'glpi_mailcollectors'
      ];

      if (true === $active) {
         $criteria['WHERE'] = ['is_active' => 1];
      }

      $result = $DB->request($criteria)->next();

      return (int)$result['cpt'];
   }

   /**
    * Count active collectors
    *
    * @return integer
    */
   public static function countActiveCollectors() {
      return self::countCollectors(true);
   }

   /**
    * Try to retrieve an existing item from references in message headers.
    * References corresponds to original MessageId sent by GLPI.
    *
    * @param Message $message
    *
    * @since 9.5.4
    *
    * @return CommonDBTM|null
    */
   public function getItemFromHeaders(Message $message): ?CommonDBTM {
      $pattern = $this->getMessageIdExtractPattern();

      foreach (['in_reply_to', 'references'] as $header_name) {
         $matches = [];
         if ($message->getHeaders()->has($header_name)
             && preg_match($pattern, $message->getHeader($header_name)->getFieldValue(), $matches)) {
            $itemtype = $matches['itemtype'];
            $items_id = $matches['items_id'];

            // Handle old format MessageId where itemtype was not in header
            if (empty($itemtype) && !empty($items_id)) {
               $itemtype = Ticket::getType();
            }

            if (empty($itemtype) || !class_exists($itemtype) || !is_a($itemtype, CommonDBTM::class, true)) {
               // itemtype not found or invalid
               continue;
            }
            $item = new $itemtype();
            if (!empty($items_id) && $item->getFromDB($items_id)) {
               return $item;
            }
         }
      }

      return null;
   }

   /**
    * Check if message was sent by current instance of GLPI.
    * This can be verified by checking the MessageId header.
    *
    * @param Message $message
    *
    * @since 9.5.4
    *
    * @return bool
    */
   public function isMessageSentByGlpi(Message $message): bool {
      $pattern = $this->getMessageIdExtractPattern();

      if (!$message->getHeaders()->has('message-id')) {
         // Messages sent by GLPI now have always a message-id header.
         return false;
      }

      $message_id = $message->getHeader('message_id')->getFieldValue();
      $matches = [];
      if (!preg_match($pattern, $message_id, $matches)) {
         // message-id header does not match GLPI format.
         return false;
      }

      return true;
   }

   /**
    * Get pattern that can be used to extract information from a GLPI MessageId (itemtype and items_id).
    *
    * @see NotificationTarget::getMessageID()
    *
    * @return string
    */
   private function getMessageIdExtractPattern(): string {
      // old format:           GLPI-{$items_id}.{$time}.{$rand}@{$uname}
      // without related item: GLPI.{$time}.{$rand}@{$uname}
      // with related item:    GLPI-{$itemtype}-{$items_id}.{$time}.{$rand}@{$uname}

      return '/GLPI'
         . '(-(?<itemtype>[a-z]+))?' // itemtype is not present if notification is not related to any object and was not present in old format
         . '(-(?<items_id>[0-9]+))?' // items_id is not present if notification is not related to any object
         . '\.[0-9]+' // time()
         . '\.[0-9]+' // rand()
         . '@\w*' // uname
         . '/i'; // insensitive
   }

   /**
    * @param $name
    * @param $value  (default 0)
    * @param $rand
   **/
   public static function showMaxFilesize($name, $value = 0, $rand = null) {

      $sizes[0] = __('No import');
      for ($index=1; $index<100; $index++) {
         $sizes[$index*1048576] = sprintf(__('%s Mio'), $index);
      }

      if ($rand === null) {
         $rand = mt_rand();
      }

      Dropdown::showFromArray($name, $sizes, ['value' => $value, 'rand' => $rand]);
   }


   function cleanDBonPurge() {
      // mailcollector for RuleMailCollector, _mailgate for RuleTicket
      Rule::cleanForItemCriteria($this, 'mailcollector');
      Rule::cleanForItemCriteria($this, '_mailgate');
   }

   /**
    * Get the requester email address.
    *
    * @param Message $message
    *
    * @return string|null
    */
   private function getRequesterEmail(Message $message): ?string {
      $email = null;

      if ($this->fields['requester_field'] === self::REQUESTER_FIELD_REPLY_TO) {
         // Try to find requester in "reply-to"
         $email = $this->getEmailFromHeader($message, 'reply-to');
      }

      if ($email === null) {
         // Fallback on default "from"
         $email = $this->getEmailFromHeader($message, 'from');
      }

      return $email;
   }

   /**
    * Get the email address from given header.
    *
    * @param Message $message
    * @param string  $header_name
    *
    * @return string|null
    */
   private function getEmailFromHeader(Message $message, string $header_name): ?string {
      if (!$message->getHeaders()->has($header_name)) {
         return null;
      }

      $header = $message->getHeader($header_name);
      $address = $header instanceof AbstractAddressList ? $header->getAddressList()->rewind() : null;

      return $address instanceof Address ? $address->getEmail() : null;
   }


   /**
    * Retrieve properly decoded content
    *
    * @param \Laminas\Mail\Storage\Message $part Message Part
    *
    * @return string
    */
   public function getDecodedContent(\Laminas\Mail\Storage\Part $part) {
      $contents = $part->getContent();

      $encoding = null;
      if (isset($part->contentTransferEncoding)) {
         $encoding = $part->contentTransferEncoding;
      }

      switch ($encoding) {
         case 'base64':
            $contents = base64_decode($contents);
            break;
         case 'quoted-printable':
            $contents = quoted_printable_decode($contents);
            break;
         case '7bit':
         case '8bit':
         case 'binary':
         default:
            // returned verbatim
            break;
      }

      if (!$part->getHeaders()->has('content-type')
         || !(($content_type = $part->getHeader('content-type')) instanceof ContentType)
         || preg_match('/^text\//', $content_type->getType()) !== 1) {
         return $contents; // No charset conversion content type header is not set or content is not text/*
      }

      $charset = $content_type->getParameter('charset');
      if ($charset !== null && strtoupper($charset) != 'UTF-8') {
         if (in_array(strtoupper($charset), array_map('strtoupper', mb_list_encodings()))) {
            $contents = mb_convert_encoding($contents, 'UTF-8', $charset);
         } else {
            // Convert Windows charsets names
            if (preg_match('/^WINDOWS-\d{4}$/i', $charset)) {
               $charset = preg_replace('/^WINDOWS-(\d{4})$/i', 'CP$1', $charset);
            }

            // Try to convert using iconv with TRANSLIT, then with IGNORE.
            // TRANSLIT may result in failure depending on system iconv implementation.
            if ($converted = @iconv($charset, 'UTF-8//TRANSLIT', $contents)) {
               $contents = $converted;
            } else if ($converted = iconv($charset, 'UTF-8//IGNORE', $contents)) {
               $contents = $converted;
            }
         }
      }

      return $contents;
   }


   static function getIcon() {
      return "fas fa-inbox";
   }
}
