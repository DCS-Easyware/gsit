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

/**
 * CommonITILObject Class
**/
abstract class CommonITILObject extends CommonDBTM {

   /// Users by type
   protected $users       = [];
   public $userlinkclass  = '';
   /// Groups by type
   protected $groups      = [];
   public $grouplinkclass = '';

   /// Suppliers by type
   protected $suppliers      = [];
   public $supplierlinkclass = '';

   /// Use user entity to select entity of the object
   protected $userentity_oncreate = false;


   /// From CommonDBTM
   public $notificationqueueonaction = true;

   const MATRIX_FIELD         = '';
   const URGENCY_MASK_FIELD   = '';
   const IMPACT_MASK_FIELD    = '';
   const STATUS_MATRIX_FIELD  = '';


   // STATUS
   const INCOMING      = 1; // new
   const ASSIGNED      = 2; // assign
   const PLANNED       = 3; // plan
   const WAITING       = 4; // waiting
   const SOLVED        = 5; // solved
   const CLOSED        = 6; // closed
   const ACCEPTED      = 7; // accepted
   const OBSERVED      = 8; // observe
   const EVALUATION    = 9; // evaluation
   const APPROVAL      = 10; // approbation
   const TEST          = 11; // test
   const QUALIFICATION = 12; // qualification

   const NO_TIMELINE       = -1;
   const TIMELINE_NOTSET   = 0;
   const TIMELINE_LEFT     = 1;
   const TIMELINE_MIDLEFT  = 2;
   const TIMELINE_MIDRIGHT = 3;
   const TIMELINE_RIGHT    = 4;



   function post_getFromDB() {
      $this->loadActors();
   }


   /**
    * @since 0.84
   **/
   function loadActors() {

      if (!empty($this->grouplinkclass)) {
         $class        = new $this->grouplinkclass();
         $this->groups = $class->getActors($this->fields['id']);
      }

      if (!empty($this->userlinkclass)) {
         $class        = new $this->userlinkclass();
         $this->users  = $class->getActors($this->fields['id']);
      }

      if (!empty($this->supplierlinkclass)) {
         $class            = new $this->supplierlinkclass();
         $this->suppliers  = $class->getActors($this->fields['id']);
      }
   }


   /**
    * Retrieve an item from the database with datas associated (hardwares)
    *
    * @param integer $ID          ID of the item to get
    * @param boolean $purecontent true : nothing change / false : convert to HTML display
    *
    * @return boolean true if succeed else false
   **/
   function getFromDBwithData($ID, $purecontent) {

      if ($this->getFromDB($ID)) {
         if (!$purecontent) {
            $this->fields["content"] = nl2br(preg_replace("/\r\n\r\n/", "\r\n",
                                             $this->fields["content"]));
         }
         $this->getAdditionalDatas();
         return true;
      }
      return false;
   }


   function getAdditionalDatas() {
   }


   /**
    * Can manage actors
    *
    * @return boolean
    */
   function canAdminActors() {
      if (isset($this->fields['is_deleted']) && $this->fields['is_deleted'] == 1) {
         return false;
      }
      return Session::haveRight(static::$rightname, UPDATE);
   }


   /**
    * Can assign object
    *
    * @return boolean
    */
   function canAssign() {
      if (isset($this->fields['is_deleted']) && ($this->fields['is_deleted'] == 1)
          || isset($this->fields['status']) && in_array($this->fields['status'], $this->getClosedStatusArray())
      ) {
         return false;
      }
      return Session::haveRight(static::$rightname, UPDATE);
   }


   /**
    * Can be assigned to me
    *
    * @return boolean
    */
   function canAssignToMe() {
      if (isset($this->fields['is_deleted']) && $this->fields['is_deleted'] == 1
         || isset($this->fields['status']) && in_array($this->fields['status'], $this->getClosedStatusArray())
      ) {
         return false;
      }
      return Session::haveRight(static::$rightname, UPDATE);
   }


   /**
    * Is the current user have right to approve solution of the current ITIL object.
    *
    * @since 9.4.0
    *
    * @return boolean
    */
   function canApprove() {

      return (($this->fields["users_id_recipient"] === Session::getLoginUserID())
              || $this->isUser(CommonITILActor::REQUESTER, Session::getLoginUserID())
              || (isset($_SESSION["glpigroups"])
                  && $this->haveAGroup(CommonITILActor::REQUESTER, $_SESSION["glpigroups"])));
   }

   /**
    * Is the current user have right to add followups to the current ITIL Object ?
    *
    * @since 9.4.0
    *
    * @return boolean
    */
   function canAddFollowups() {
      return (
         (
            Session::haveRight("followup", ITILFollowup::ADDMYTICKET)
            && (
               $this->isUser(CommonITILActor::REQUESTER, Session::getLoginUserID())
               || (
                  isset($this->fields["users_id_recipient"])
                  && ($this->fields["users_id_recipient"] == Session::getLoginUserID())
               )
            )
         )
         || Session::haveRight('followup', ITILFollowup::ADDALLTICKET)
         || (
            Session::haveRight('followup', ITILFollowup::ADDGROUPTICKET)
            && isset($_SESSION["glpigroups"])
            && $this->haveAGroup(CommonITILActor::REQUESTER, $_SESSION['glpigroups'])
         )
         || $this->isUser(CommonITILActor::ASSIGN, Session::getLoginUserID())
         || (
            isset($_SESSION["glpigroups"])
            && $this->haveAGroup(CommonITILActor::ASSIGN, $_SESSION['glpigroups'])
         )
         || $this->isValidator(Session::getLoginUserID())
      );
   }

   /**
    * Check if the given users is a validator
    * @param int $users_id
    * @return bool
    */
   public function isValidator($users_id): bool {
      if (!$users_id) {
         // Invalid parameter
         return false;
      }

      if (!$this instanceof Ticket && !$this instanceof Change) {
         // Not a valid validation target
         return false;
      }

      $validation_class = static::class . "Validation";
      $valitation_obj = new $validation_class;
      $validation_requests = $valitation_obj->find([
         getForeignKeyFieldForItemType(static::class) => $this->getID(),
         'users_id_validate' => $users_id,
      ]);

      return count($validation_requests) > 0;
   }


   /**
    * Does current user have right to solve the current item?
    *
    * @return boolean
   **/
   function canSolve() {

      return ((Session::haveRight(static::$rightname, UPDATE)
               || $this->isUser(CommonITILActor::ASSIGN, Session::getLoginUserID())
               || (isset($_SESSION["glpigroups"])
                   && $this->haveAGroup(CommonITILActor::ASSIGN, $_SESSION["glpigroups"])))
              && static::isAllowedStatus($this->fields['status'], self::SOLVED)
              // No edition on closed status
              && !in_array($this->fields['status'], $this->getClosedStatusArray()));
   }

   /**
    * Does current user have right to solve the current item; if it was not closed?
    *
    * @return boolean
   **/
   function maySolve() {

      return ((Session::haveRight(static::$rightname, UPDATE)
               || $this->isUser(CommonITILActor::ASSIGN, Session::getLoginUserID())
               || (isset($_SESSION["glpigroups"])
                   && $this->haveAGroup(CommonITILActor::ASSIGN, $_SESSION["glpigroups"])))
              && static::isAllowedStatus($this->fields['status'], self::SOLVED));
   }


   /**
    * Get the ITIL object closed, solved or waiting status list
    *
    * @since 9.4.0
    *
    * @return array
    */
   static function getReopenableStatusArray() {
      return [self::CLOSED, self::SOLVED, self::WAITING];
   }


   /**
    * Is a user linked to the object ?
    *
    * @param integer $type     type to search (see constants)
    * @param integer $users_id user ID
    *
    * @return boolean
   **/
   function isUser($type, $users_id) {

      if (isset($this->users[$type])) {
         foreach ($this->users[$type] as $data) {
            if ($data['users_id'] == $users_id) {
               return true;
            }
         }
      }

      return false;
   }


   /**
    * Is a group linked to the object ?
    *
    * @param integer $type      type to search (see constants)
    * @param integer $groups_id group ID
    *
    * @return boolean
   **/
   function isGroup($type, $groups_id) {

      if (isset($this->groups[$type])) {
         foreach ($this->groups[$type] as $data) {
            if ($data['groups_id'] == $groups_id) {
               return true;
            }
         }
      }
      return false;
   }


   /**
    * Is a supplier linked to the object ?
    *
    * @since 0.84
    *
    * @param integer $type         type to search (see constants)
    * @param integer $suppliers_id supplier ID
    *
    * @return boolean
   **/
   function isSupplier($type, $suppliers_id) {

      if (isset($this->suppliers[$type])) {
         foreach ($this->suppliers[$type] as $data) {
            if ($data['suppliers_id'] == $suppliers_id) {
               return true;
            }
         }
      }
      return false;
   }


   /**
    * get users linked to a object
    *
    * @param integer $type type to search (see constants)
    *
    * @return array
   **/
   function getUsers($type) {

      if (isset($this->users[$type])) {
         return $this->users[$type];
      }

      return [];
   }


   /**
    * get groups linked to a object
    *
    * @param integer $type type to search (see constants)
    *
    * @return array
   **/
   function getGroups($type) {

      if (isset($this->groups[$type])) {
         return $this->groups[$type];
      }

      return [];
   }


   /**
    * get users linked to an object including groups ones
    *
    * @since 0.85
    *
    * @param integer $type type to search (see constants)
    *
    * @return array
   **/
   function getAllUsers ($type) {

      $users = [];
      foreach ($this->getUsers($type) as $link) {
         $users[$link['users_id']] = $link['users_id'];
      }

      foreach ($this->getGroups($type) as $link) {
         $gusers = Group_User::getGroupUsers($link['groups_id']);
         foreach ($gusers as $user) {
            $users[$user['id']] = $user['id'];
         }
      }

      return $users;
   }


   /**
    * get suppliers linked to a object
    *
    * @since 0.84
    *
    * @param integer $type type to search (see constants)
    *
    * @return array
   **/
   function getSuppliers($type) {

      if (isset($this->suppliers[$type])) {
         return $this->suppliers[$type];
      }

      return [];
   }


   /**
    * count users linked to object by type or global
    *
    * @param integer $type type to search (see constants) / 0 for all (default 0)
    *
    * @return integer
   **/
   function countUsers($type = 0) {

      if ($type > 0) {
         if (isset($this->users[$type])) {
            return count($this->users[$type]);
         }

      } else {
         if (count($this->users)) {
            $count = 0;
            foreach ($this->users as $u) {
               $count += count($u);
            }
            return $count;
         }
      }
      return 0;
   }


   /**
    * count groups linked to object by type or global
    *
    * @param integer $type type to search (see constants) / 0 for all (default 0)
    *
    * @return integer
   **/
   function countGroups($type = 0) {

      if ($type > 0) {
         if (isset($this->groups[$type])) {
            return count($this->groups[$type]);
         }

      } else {
         if (count($this->groups)) {
            $count = 0;
            foreach ($this->groups as $u) {
               $count += count($u);
            }
            return $count;
         }
      }
      return 0;
   }


   /**
    * count suppliers linked to object by type or global
    *
    * @since 0.84
    *
    * @param integer $type type to search (see constants) / 0 for all (default 0)
    *
    * @return integer
   **/
   function countSuppliers($type = 0) {

      if ($type > 0) {
         if (isset($this->suppliers[$type])) {
            return count($this->suppliers[$type]);
         }

      } else {
         if (count($this->suppliers)) {
            $count = 0;
            foreach ($this->suppliers as $u) {
               $count += count($u);
            }
            return $count;
         }
      }
      return 0;
   }


   /**
    * Is one of groups linked to the object ?
    *
    * @param integer $type   type to search (see constants)
    * @param array   $groups groups IDs
    *
    * @return boolean
   **/
   function haveAGroup($type, array $groups) {

      if (is_array($groups) && count($groups)
          && isset($this->groups[$type])) {

         foreach ($groups as $groups_id) {
            foreach ($this->groups[$type] as $data) {
               if ($data['groups_id'] == $groups_id) {
                  return true;
               }
            }
         }
      }
      return false;
   }


   /**
    * Get Default actor when creating the object
    *
    * @param integer $type type to search (see constants)
    *
    * @return boolean
   **/
   function getDefaultActor($type) {

      /// TODO own_ticket -> own_itilobject
      if ($type == CommonITILActor::ASSIGN) {
         if (Session::haveRight("ticket", Ticket::OWN)) {
            return Session::getLoginUserID();
         }
      }
      return 0;
   }


   /**
    * Get Default actor when creating the object
    *
    * @param integer $type type to search (see constants)
    *
    * @return boolean
   **/
   function getDefaultActorRightSearch($type) {

      if ($type == CommonITILActor::ASSIGN) {
         return "own_ticket";
      }
      return "all";
   }


   /**
    * Count active ITIL Objects
    *
    * @since 9.3.1
    *
    * @param CommonITILActor $linkclass Link class instance
    * @param integer         $id        Item ID
    * @param integer         $role      ITIL role
    *
    * @return integer
   **/
   private function countActiveObjectsFor(CommonITILActor $linkclass, $id, $role) {

      $itemtable = $this->getTable();
      $itemfk    = $this->getForeignKeyField();
      $linktable = $linkclass->getTable();
      $field     = $linkclass::$items_id_2;

      return countElementsInTable(
         [$itemtable, $linktable], [
            "$linktable.$itemfk"    => new \QueryExpression(DBmysql::quoteName("$itemtable.id")),
            "$linktable.$field"     => $id,
            "$linktable.type"       => $role,
            "$itemtable.is_deleted" => 0,
            "NOT"                   => [
               "$itemtable.status" => array_merge(
                  $this->getSolvedStatusArray(),
                  $this->getClosedStatusArray()
               )
            ]
         ] + getEntitiesRestrictCriteria($itemtable)
      );
   }




   /**
    * Count active ITIL Objects requested by a user
    *
    * @since 0.83
    *
    * @param integer $users_id ID of the User
    *
    * @return integer
   **/
   function countActiveObjectsForUser($users_id) {
      $linkclass = new $this->userlinkclass();
      return $this->countActiveObjectsFor(
         $linkclass,
         $users_id,
         CommonITILActor::REQUESTER
      );
   }


   /**
    * Count active ITIL Objects assigned to a user
    *
    * @since 0.83
    *
    * @param integer $users_id ID of the User
    *
    * @return integer
   **/
   function countActiveObjectsForTech($users_id) {
      $linkclass = new $this->userlinkclass();
      return $this->countActiveObjectsFor(
         $linkclass,
         $users_id,
         CommonITILActor::ASSIGN
      );
   }


   /**
    * Count active ITIL Objects assigned to a group
    *
    * @since 0.84
    *
    * @param integer $groups_id ID of the User
    *
    * @return integer
   **/
   function countActiveObjectsForTechGroup($groups_id) {
      $linkclass = new $this->grouplinkclass();
      return $this->countActiveObjectsFor(
         $linkclass,
         $groups_id,
         CommonITILActor::ASSIGN
      );
   }


   /**
    * Count active ITIL Objects assigned to a supplier
    *
    * @since 0.85
    *
    * @param integer $suppliers_id ID of the Supplier
    *
    * @return integer
    **/
   function countActiveObjectsForSupplier($suppliers_id) {
      $linkclass = new $this->supplierlinkclass();
      return $this->countActiveObjectsFor(
         $linkclass,
         $suppliers_id,
         CommonITILActor::ASSIGN
      );
   }


   function cleanDBonPurge() {

      $link_classes = [
         Itil_Project::class,
         ITILFollowup::class,
         ITILSolution::class
      ];

      if (is_a($this->grouplinkclass, CommonDBConnexity::class, true)) {
         $link_classes[] = $this->grouplinkclass;
      }

      if (is_a($this->userlinkclass, CommonDBConnexity::class, true)) {
         $link_classes[] = $this->userlinkclass;
      }

      if (is_a($this->supplierlinkclass, CommonDBConnexity::class, true)) {
         $link_classes[] = $this->supplierlinkclass;
      }

      $this->deleteChildrenAndRelationsFromDb($link_classes);
   }

   /**
    * Handle template mandatory fields on update
    *
    * @param array $input Input
    *
    * @return array
    */
   protected function handleTemplateFields(array $input) {
      //// check mandatory fields
      // First get ticket template associated : entity and type/category
      if (isset($input['entities_id'])) {
         $entid = $input['entities_id'];
      } else {
         $entid = $this->fields['entities_id'];
      }

      $type = null;
      if (isset($input['type'])) {
         $type = $input['type'];
      } else if (isset($this->fields['type'])) {
         $type = $this->fields['type'];
      }

      if (isset($input['itilcategories_id'])) {
         $categid = $input['itilcategories_id'];
      } else {
         $categid = $this->fields['itilcategories_id'];
      }

      $check_allowed_fields_for_template = false;
      $allowed_fields                    = [];
      if (!Session::isCron()
          && (!Session::haveRight(static::$rightname, UPDATE)
            // Closed tickets
            || in_array($this->fields['status'], $this->getClosedStatusArray()))
         ) {

         $allowed_fields                    = ['id'];
         $check_allowed_fields_for_template = true;

         if (in_array($this->fields['status'], $this->getClosedStatusArray())) {
            $allowed_fields[] = 'status';

            // probably transfer
            $allowed_fields[] = 'entities_id';
            $allowed_fields[] = 'itilcategories_id';
         } else {
            if ($this->canApprove()
                || $this->canAssign()
                || $this->canAssignToMe()
                || isset($input['_from_assignment'])) {
                $allowed_fields[] = 'status';
                $allowed_fields[] = '_accepted';
            }
            // for post-only with validate right or validation created by rules
            $validation_class = static::getType() . 'Validation';
            if (class_exists($validation_class)) {
               if ($validation_class::canValidate($this->fields['id'])
                  || $validation_class::canCreate()
                  || isset($input["_rule_process"])) {
                  $allowed_fields[] = 'global_validation';
               }
            }
            // Manage assign and steal right
            if (static::getType() === Ticket::getType() && Session::haveRightsOr(static::$rightname, [Ticket::ASSIGN, Ticket::STEAL])) {
                $allowed_fields[] = '_itil_assign';
            }

            // Can only update initial fields if no followup or task already added
            if ($this->canUpdateItem()) {
                $allowed_fields[] = 'content';
                $allowed_fields[] = 'urgency';
                $allowed_fields[] = 'priority'; // automatic recalculate if user changes urgence
                $allowed_fields[] = 'itilcategories_id';
                $allowed_fields[] = 'name';
                $allowed_fields[] = 'items_id';
                $allowed_fields[] = '_filename';
                $allowed_fields[] = '_tag_filename';
                $allowed_fields[] = '_prefix_filename';
                $allowed_fields[] = '_content';
                $allowed_fields[] = '_tag_content';
                $allowed_fields[] = '_prefix_content';
                $allowed_fields[] = 'takeintoaccount_delay_stat';
            }
         }

         $ret = [];

         foreach ($allowed_fields as $field) {
            if (isset($input[$field])) {
               $ret[$field] = $input[$field];
            }
         }

         $input = $ret;

         // Only ID return false
         if (count($input) == 1) {
            return false;
         }
      }

      $tt = $this->getITILTemplateToUse(0, $type, $categid, $entid);

      if (count($tt->mandatory)) {
         $mandatory_missing = [];
         $fieldsname        = $tt->getAllowedFieldsNames(true);
         foreach ($tt->mandatory as $key => $val) {
            if ((!$check_allowed_fields_for_template || in_array($key, $allowed_fields))
                && (isset($input[$key])
                    && (empty($input[$key]) || ($input[$key] == 'NULL'))
                )) {
               $mandatory_missing[$key] = $fieldsname[$val];
            }
         }
         if (count($mandatory_missing)) {
            //TRANS: %s are the fields concerned
            $message = sprintf(__('Mandatory fields are not filled. Please correct: %s'),
                               implode(", ", $mandatory_missing));
            Session::addMessageAfterRedirect($message, false, ERROR);
            return false;
         }
      }

      return $input;
   }

   function prepareInputForUpdate($input) {

      if (!$this->checkFieldsConsistency($input)) {
         return false;
      }

      // Add document if needed
      $this->getFromDB($input["id"]); // entities_id field required

      if ($this->getType() !== Ticket::getType()) {
         //cannot be handled here for tickets. @see Ticket::prepareInputForUpdate()
         $input = $this->handleTemplateFields($input);
         if ($input === false) {
            return false;
         }
      }

      if (isset($input["document"]) && ($input["document"] > 0)) {
         $doc = new Document();
         if ($doc->getFromDB($input["document"])) {
            $docitem = new Document_Item();
            if ($docitem->add(['documents_id' => $input["document"],
                                    'itemtype'     => $this->getType(),
                                    'items_id'     => $input["id"]])) {
               // Force date_mod of tracking
               $input["date_mod"]     = $_SESSION["glpi_currenttime"];
               $input['_doc_added'][] = $doc->fields["name"];
            }
         }
         unset($input["document"]);
      }

      if (isset($input["date"]) && empty($input["date"])) {
         unset($input["date"]);
      }

      if (isset($input["closedate"]) && empty($input["closedate"])) {
         unset($input["closedate"]);
      }

      if (isset($input["solvedate"]) && empty($input["solvedate"])) {
         unset($input["solvedate"]);
      }

      // "do not compute" flag set by business rules for "takeintoaccount_delay_stat" field
      $do_not_compute_takeintoaccount = $this->isTakeIntoAccountComputationBlocked($input);

      if (isset($input['_itil_requester'])) {
         if (isset($input['_itil_requester']['_type'])) {
            $input['_itil_requester'] = [
               'type'                            => CommonITILActor::REQUESTER,
               $this->getForeignKeyField()       => $input['id'],
               '_do_not_compute_takeintoaccount' => $do_not_compute_takeintoaccount,
               '_from_object'                    => true,
            ] + $input['_itil_requester'];

            switch ($input['_itil_requester']['_type']) {
               case "user" :
                  if (isset($input['_itil_requester']['use_notification'])
                      && is_array($input['_itil_requester']['use_notification'])) {
                     $input['_itil_requester']['use_notification'] = $input['_itil_requester']['use_notification'][0];
                  }
                  if (isset($input['_itil_requester']['alternative_email'])
                      && is_array($input['_itil_requester']['alternative_email'])) {
                     $input['_itil_requester']['alternative_email'] = $input['_itil_requester']['alternative_email'][0];
                  }

                  if (!empty($this->userlinkclass)) {
                     if (isset($input['_itil_requester']['alternative_email'])
                         && $input['_itil_requester']['alternative_email']
                         && !NotificationMailing::isUserAddressValid($input['_itil_requester']['alternative_email'])) {

                        $input['_itil_requester']['alternative_email'] = '';
                        Session::addMessageAfterRedirect(__('Invalid email address'), false, ERROR);
                     }

                     if ((isset($input['_itil_requester']['alternative_email'])
                          && $input['_itil_requester']['alternative_email'])
                         || ($input['_itil_requester']['users_id'] > 0)) {

                        $useractors = new $this->userlinkclass();
                        if (isset($input['_auto_update'])
                            || $useractors->can(-1, CREATE, $input['_itil_requester'])) {
                           $useractors->add($input['_itil_requester']);
                           $input['_forcenotif']                     = true;
                        }
                     }
                  }
                  break;

               case "group" :
                  if (!empty($this->grouplinkclass)
                      && ($input['_itil_requester']['groups_id'] > 0)) {
                     $groupactors = new $this->grouplinkclass();
                     if (isset($input['_auto_update'])
                         || $groupactors->can(-1, CREATE, $input['_itil_requester'])) {
                        $groupactors->add($input['_itil_requester']);
                        $input['_forcenotif']                     = true;
                     }
                  }
                  break;
            }
         }
      }

      if (isset($input['_itil_observer'])) {
         if (isset($input['_itil_observer']['_type'])) {
            $input['_itil_observer'] = [
               'type'                            => CommonITILActor::OBSERVER,
               $this->getForeignKeyField()       => $input['id'],
               '_do_not_compute_takeintoaccount' => $do_not_compute_takeintoaccount,
               '_from_object'                    => true,
            ] + $input['_itil_observer'];

            switch ($input['_itil_observer']['_type']) {
               case "user" :
                  if (isset($input['_itil_observer']['use_notification'])
                      && is_array($input['_itil_observer']['use_notification'])) {
                     $input['_itil_observer']['use_notification'] = $input['_itil_observer']['use_notification'][0];
                  }
                  if (isset($input['_itil_observer']['alternative_email'])
                      && is_array($input['_itil_observer']['alternative_email'])) {
                     $input['_itil_observer']['alternative_email'] = $input['_itil_observer']['alternative_email'][0];
                  }

                  if (!empty($this->userlinkclass)) {
                     if (isset($input['_itil_observer']['alternative_email'])
                         && $input['_itil_observer']['alternative_email']
                         && !NotificationMailing::isUserAddressValid($input['_itil_observer']['alternative_email'])) {

                        $input['_itil_observer']['alternative_email'] = '';
                        Session::addMessageAfterRedirect(__('Invalid email address'), false, ERROR);
                     }
                     if ((isset($input['_itil_observer']['alternative_email'])
                          && $input['_itil_observer']['alternative_email'])
                         || ($input['_itil_observer']['users_id'] > 0)) {
                        $useractors = new $this->userlinkclass();
                        if (isset($input['_auto_update'])
                           || $useractors->can(-1, CREATE, $input['_itil_observer'])) {
                           $useractors->add($input['_itil_observer']);
                           $input['_forcenotif']                    = true;
                        }
                     }
                  }
                  break;

               case "group" :
                  if (!empty($this->grouplinkclass)
                       && ($input['_itil_observer']['groups_id'] > 0)) {
                     $groupactors = new $this->grouplinkclass();
                     if (isset($input['_auto_update'])
                         || $groupactors->can(-1, CREATE, $input['_itil_observer'])) {
                        $groupactors->add($input['_itil_observer']);
                        $input['_forcenotif']                    = true;
                     }
                  }
                  break;
            }
         }
      }

      if (isset($input['_itil_assign'])) {
         if (isset($input['_itil_assign']['_type'])) {
            $input['_itil_assign'] = [
               'type'                            => CommonITILActor::ASSIGN,
               $this->getForeignKeyField()       => $input['id'],
               '_do_not_compute_takeintoaccount' => $do_not_compute_takeintoaccount,
               '_from_object'                    => true,
            ] + $input['_itil_assign'];

            if (isset($input['_itil_assign']['use_notification'])
                  && is_array($input['_itil_assign']['use_notification'])) {
               $input['_itil_assign']['use_notification'] = $input['_itil_assign']['use_notification'][0];
            }
            if (isset($input['_itil_assign']['alternative_email'])
                  && is_array($input['_itil_assign']['alternative_email'])) {
               $input['_itil_assign']['alternative_email'] = $input['_itil_assign']['alternative_email'][0];
            }

            switch ($input['_itil_assign']['_type']) {
               case "user" :
                  if (!empty($this->userlinkclass)
                      && ((isset($input['_itil_assign']['alternative_email'])
                           && $input['_itil_assign']['alternative_email'])
                          || $input['_itil_assign']['users_id'] > 0)) {
                     $useractors = new $this->userlinkclass();
                     if (isset($input['_auto_update'])
                         || $useractors->can(-1, CREATE, $input['_itil_assign'])) {
                        $useractors->add($input['_itil_assign']);
                        $input['_forcenotif']                  = true;
                        if (((!isset($input['status'])
                             && in_array($this->fields['status'], $this->getNewStatusArray()))
                            || (isset($input['status'])
                                && in_array($input['status'], $this->getNewStatusArray())))
                            && !$this->isStatusComputationBlocked($input)) {
                           if (in_array(self::ASSIGNED, array_keys($this->getAllStatusArray()))) {
                              $input['status'] = self::ASSIGNED;
                           }
                        }
                     }
                  }
                  break;

               case "group" :
                  if (!empty($this->grouplinkclass)
                      && ($input['_itil_assign']['groups_id'] > 0)) {
                     $groupactors = new $this->grouplinkclass();

                     if (isset($input['_auto_update'])
                         || $groupactors->can(-1, CREATE, $input['_itil_assign'])) {
                        $groupactors->add($input['_itil_assign']);
                        $input['_forcenotif']                  = true;
                        if (((!isset($input['status'])
                             && (in_array($this->fields['status'], $this->getNewStatusArray())))
                            || (isset($input['status'])
                                && (in_array($input['status'], $this->getNewStatusArray()))))
                            && !$this->isStatusComputationBlocked($input)) {
                           if (in_array(self::ASSIGNED, array_keys($this->getAllStatusArray()))) {
                              $input['status'] = self::ASSIGNED;
                           }
                        }
                     }
                  }
                  break;

               case "supplier" :
                  if (!empty($this->supplierlinkclass)
                      && ((isset($input['_itil_assign']['alternative_email'])
                           && $input['_itil_assign']['alternative_email'])
                          || $input['_itil_assign']['suppliers_id'] > 0)) {
                     $supplieractors = new $this->supplierlinkclass();
                     if (isset($input['_auto_update'])
                         || $supplieractors->can(-1, CREATE, $input['_itil_assign'])) {
                        $supplieractors->add($input['_itil_assign']);
                        $input['_forcenotif']                  = true;
                        if (((!isset($input['status'])
                             && (in_array($this->fields['status'], $this->getNewStatusArray())))
                            || (isset($input['status'])
                                && (in_array($input['status'], $this->getNewStatusArray()))))
                            && !$this->isStatusComputationBlocked($input)) {
                           if (in_array(self::ASSIGNED, array_keys($this->getAllStatusArray()))) {
                              $input['status'] = self::ASSIGNED;
                           }

                        }
                     }
                  }
                  break;
            }
         }
      }

      $this->addAdditionalActors($input);

      // set last updater if interactive user
      if (!Session::isCron()) {
         $input['users_id_lastupdater'] = Session::getLoginUserID();
      }

      $solvedclosed = array_merge(
         $this->getSolvedStatusArray(),
         $this->getClosedStatusArray()
      );

      if (isset($input["status"])
          && !in_array($input["status"], $solvedclosed)) {
         $input['solvedate'] = 'NULL';
      }

      if (isset($input["status"]) && !in_array($input["status"], $this->getClosedStatusArray())) {
         $input['closedate'] = 'NULL';
      }

      // Setting a solution type means the ticket is solved
      if (isset($input["solutiontypes_id"])
          && (!isset($input['status']) || !in_array($input["status"], $solvedclosed))) {
         $solution = new ITILSolution();
         $soltype = new SolutionType();
         $soltype->getFromDB($input['solutiontypes_id']);
         $solution->add([
            'itemtype'           => $this->getType(),
            'items_id'           => $this->getID(),
            'solutiontypes_id'   => $input['solutiontypes_id'],
            'content'            => 'Solved using type ' . $soltype->getName()
         ]);
      }

      return $input;
   }

   function post_updateItem($history = 1) {
      // Handle files pasted in the file field
      $this->input = $this->addFiles($this->input);

      // Handle files pasted in the text area
      if (!isset($this->input['_donotadddocs']) || !$this->input['_donotadddocs']) {
         $options = [
            'force_update' => true,
            'name' => 'content',
            'content_field' => 'content',
         ];
         if (isset($this->input['solution'])) {
            $options['name'] = 'solution';
            $options['content_field'] = 'solution';
         }
         $this->input = $this->addFiles($this->input, $options);
      }

      // Handle deferred solution addition (for solution templates added by rule)
      if (isset($this->input['_solutiontemplates_id'])) {
         $template = new SolutionTemplate();
         if ($template->getFromDB($this->input['_solutiontemplates_id'])) {
            $solution = new ITILSolution();
            $solution->add([
               "itemtype" => static::getType(),
               "solutiontypes_id" => $template->fields['solutiontypes_id'],
               "content" => Toolbox::addslashes_deep($template->fields['content']),
               "status" => CommonITILValidation::WAITING,
               "items_id" => $this->fields['id']
            ]);
         }
      }
   }


   function pre_updateInDB() {
      global $DB;

      // get again object to reload actors
      $this->loadActors();

      // Check dates change interval due to the fact that second are not displayed in form
      if ((($key = array_search('date', $this->updates)) !== false)
          && (substr($this->fields["date"], 0, 16) == substr($this->oldvalues['date'], 0, 16))) {
         unset($this->updates[$key]);
         unset($this->oldvalues['date']);
      }

      if ((($key=array_search('closedate', $this->updates)) !== false)
          && !is_null($this->fields["closedate"]) && !is_null($this->oldvalues['closedate'])
          && (substr($this->fields["closedate"], 0, 16) == substr($this->oldvalues['closedate'], 0, 16))) {
         unset($this->updates[$key]);
         unset($this->oldvalues['closedate']);
      }

      if ((($key=array_search('time_to_resolve', $this->updates)) !== false)
          && !is_null($this->fields["time_to_resolve"]) && !is_null($this->oldvalues['time_to_resolve'])
          && (substr($this->fields["time_to_resolve"], 0, 16) == substr($this->oldvalues['time_to_resolve'], 0, 16))) {
         unset($this->updates[$key]);
         unset($this->oldvalues['time_to_resolve']);
      }

      if ((($key=array_search('solvedate', $this->updates)) !== false)
          && !is_null($this->fields["solvedate"]) && isset($this->oldvalues['time_to_resolve'])
          && !is_null($this->oldvalues['time_to_resolve'])
          && (substr($this->fields["solvedate"], 0, 16) == substr($this->oldvalues['solvedate'], 0, 16))) {
         unset($this->updates[$key]);
         unset($this->oldvalues['solvedate']);
      }

      if (isset($this->input["status"])) {
         if (($this->input["status"] != self::WAITING)
             && ($this->countSuppliers(CommonITILActor::ASSIGN) == 0)
             && ($this->countUsers(CommonITILActor::ASSIGN) == 0)
             && ($this->countGroups(CommonITILActor::ASSIGN) == 0)
             && !in_array($this->fields['status'], array_merge($this->getSolvedStatusArray(),
                                                              $this->getClosedStatusArray()))) {

            if (!in_array('status', $this->updates)) {
               $this->oldvalues['status'] = $this->fields['status'];
               $this->updates[] = 'status';
            }

            // $this->fields['status'] = self::INCOMING;
            // Don't change status if it's a new status allow
            if (in_array($this->oldvalues['status'], $this->getNewStatusArray())
                && !in_array($this->input['status'], $this->getNewStatusArray())) {
               $this->fields['status'] = $this->oldvalues['status'];
            }
         }

         if (in_array("status", $this->updates)
             && in_array($this->input["status"], $this->getSolvedStatusArray())) {
            $this->updates[]              = "solvedate";
            $this->oldvalues['solvedate'] = $this->fields["solvedate"];
            $this->fields["solvedate"]    = $_SESSION["glpi_currenttime"];
            // If invalid date : set open date
            if ($this->fields["solvedate"] < $this->fields["date"]) {
               $this->fields["solvedate"] = $this->fields["date"];
            }
         }

         if (in_array("status", $this->updates)
             && in_array($this->input["status"], $this->getClosedStatusArray())) {
            $this->updates[]              = "closedate";
            $this->oldvalues['closedate'] = $this->fields["closedate"];
            $this->fields["closedate"]    = $_SESSION["glpi_currenttime"];
            // If invalid date : set open date
            if ($this->fields["closedate"] < $this->fields["date"]) {
               $this->fields["closedate"] = $this->fields["date"];
            }
            // Set solvedate to closedate
            if (empty($this->fields["solvedate"])) {
               $this->updates[]              = "solvedate";
               $this->oldvalues['solvedate'] = $this->fields["solvedate"];
               $this->fields["solvedate"]    = $this->fields["closedate"];
            }
         }

      }

      // check dates

      // check time_to_resolve (SLA)
      if ((in_array("date", $this->updates) || in_array("time_to_resolve", $this->updates))
          && !is_null($this->fields["time_to_resolve"])) { // Date set

         if ($this->fields["time_to_resolve"] < $this->fields["date"]) {
            Session::addMessageAfterRedirect(__('Invalid dates. Update cancelled.'), false, ERROR);

            if (($key = array_search('date', $this->updates)) !== false) {
               unset($this->updates[$key]);
               unset($this->oldvalues['date']);
            }
            if (($key = array_search('time_to_resolve', $this->updates)) !== false) {
               unset($this->updates[$key]);
               unset($this->oldvalues['time_to_resolve']);
            }
         }
      }

      // check internal_time_to_resolve (OLA)
      if ((in_array("date", $this->updates) || in_array("internal_time_to_resolve", $this->updates))
          && !is_null($this->fields["internal_time_to_resolve"])) { // Date set

         if ($this->fields["internal_time_to_resolve"] < $this->fields["date"]) {
            Session::addMessageAfterRedirect(__('Invalid dates. Update cancelled.'), false, ERROR);

            if (($key = array_search('date', $this->updates)) !== false) {
               unset($this->updates[$key]);
               unset($this->oldvalues['date']);
            }
            if (($key = array_search('internal_time_to_resolve', $this->updates)) !== false) {
               unset($this->updates[$key]);
               unset($this->oldvalues['internal_time_to_resolve']);
            }
         }
      }

      // Status close : check dates
      if (in_array($this->fields["status"], $this->getClosedStatusArray())
          && (in_array("date", $this->updates) || in_array("closedate", $this->updates))) {

         // Invalid dates : no change
         // closedate must be > solvedate
         if ($this->fields["closedate"] < $this->fields["solvedate"]) {
            Session::addMessageAfterRedirect(__('Invalid dates. Update cancelled.'), false, ERROR);

            if (($key = array_search('closedate', $this->updates)) !== false) {
               unset($this->updates[$key]);
               unset($this->oldvalues['closedate']);
            }
         }

         // closedate must be > create date
         if ($this->fields["closedate"] < $this->fields["date"]) {
            Session::addMessageAfterRedirect(__('Invalid dates. Update cancelled.'), false, ERROR);
            if (($key = array_search('date', $this->updates)) !== false) {
               unset($this->updates[$key]);
               unset($this->oldvalues['date']);
            }
            if (($key = array_search('closedate', $this->updates)) !== false) {
               unset($this->updates[$key]);
               unset($this->oldvalues['closedate']);
            }
         }
      }

      if ((($key = array_search('status', $this->updates)) !== false)
          && $this->oldvalues['status'] == $this->fields['status']) {

         unset($this->updates[$key]);
         unset($this->oldvalues['status']);
      }

      // Status solved : check dates
      if (in_array($this->fields["status"], $this->getSolvedStatusArray())
          && (in_array("date", $this->updates) || in_array("solvedate", $this->updates))) {

         // Invalid dates : no change
         // solvedate must be > create date
         if ($this->fields["solvedate"] < $this->fields["date"]) {
            Session::addMessageAfterRedirect(__('Invalid dates. Update cancelled.'), false, ERROR);

            if (($key = array_search('date', $this->updates)) !== false) {
               unset($this->updates[$key]);
               unset($this->oldvalues['date']);
            }
            if (($key = array_search('solvedate', $this->updates)) !== false) {
               unset($this->updates[$key]);
               unset($this->oldvalues['solvedate']);
            }
         }
      }

      // Manage come back to waiting state
      if (!is_null($this->fields['begin_waiting_date'])
         && ($key = array_search('status', $this->updates)) !== false
         && (
            $this->oldvalues['status'] == self::WAITING
            // From solved to another state than closed
            || (
               in_array($this->oldvalues["status"], $this->getSolvedStatusArray())
               && !in_array($this->fields["status"], $this->getClosedStatusArray())
            )
            // From closed to any open state
            || (
               in_array($this->oldvalues["status"], $this->getClosedStatusArray())
               && in_array($this->fields["status"], $this->getNotSolvedStatusArray())
            )
         )
      ) {

         // Compute ticket waiting time use calendar if exists
         $calendar     = new Calendar();
         $calendars_id = $this->getCalendar();
         $delay_time   = 0;

         // Compute ticket waiting time use calendar if exists
         // Using calendar
         if (($calendars_id > 0)
             && $calendar->getFromDB($calendars_id)) {
            $delay_time = $calendar->getActiveTimeBetween($this->fields['begin_waiting_date'],
                                                          $_SESSION["glpi_currenttime"]);
         } else { // Not calendar defined
            $delay_time = strtotime($_SESSION["glpi_currenttime"])
                           -strtotime($this->fields['begin_waiting_date']);
         }

         // SLA case : compute sla_ttr duration
         if (isset($this->fields['slas_id_ttr']) && ($this->fields['slas_id_ttr'] > 0)) {
            $sla = new SLA();
            if ($sla->getFromDB($this->fields['slas_id_ttr'])) {
               $sla->setTicketCalendar($calendars_id);
               $delay_time_sla  = $sla->getActiveTimeBetween($this->fields['begin_waiting_date'],
                                                             $_SESSION["glpi_currenttime"]);
               $this->updates[] = "sla_waiting_duration";
               $this->fields["sla_waiting_duration"] += $delay_time_sla;
            }

            // Compute new time_to_resolve
            $this->updates[]                 = "time_to_resolve";
            $this->fields['time_to_resolve'] = $sla->computeDate($this->fields['date'],
                                                                 $this->fields["sla_waiting_duration"]);
            // Add current level to do
            $sla->addLevelToDo($this);

         } else {
            // Using calendar
            if (($calendars_id > 0)
                && $calendar->getFromDB($calendars_id)
                && $calendar->hasAWorkingDay()) {
               if ($this->fields['time_to_resolve'] > 0) {
                  // compute new due date using calendar
                  $this->updates[]                 = "time_to_resolve";
                  $this->fields['time_to_resolve'] = $calendar->computeEndDate($this->fields['time_to_resolve'],
                                                                               $delay_time);
               }

            } else { // Not calendar defined
               if ((int)$this->fields['time_to_resolve'] > 0) {
                  // compute new due date : no calendar so add computed delay_time
                  $this->updates[]                 = "time_to_resolve";
                  $this->fields['time_to_resolve'] = date('Y-m-d H:i:s',
                                                          $delay_time + strtotime($this->fields['time_to_resolve']));
               }
            }
         }

         // OLA case : compute ola_ttr duration
         if (isset($this->fields['olas_id_ttr']) && ($this->fields['olas_id_ttr'] > 0)) {
            $ola = new OLA();
            if ($ola->getFromDB($this->fields['olas_id_ttr'])) {
               $ola->setTicketCalendar($calendars_id);
               $delay_time_ola  = $ola->getActiveTimeBetween($this->fields['begin_waiting_date'],
                                                             $_SESSION["glpi_currenttime"]);
               $this->updates[]                      = "ola_waiting_duration";
               $this->fields["ola_waiting_duration"] += $delay_time_ola;
            }

            // Compute new internal_time_to_resolve
            $this->updates[]                          = "internal_time_to_resolve";
            $this->fields['internal_time_to_resolve'] = $ola->computeDate($this->fields['ola_ttr_begin_date'],
                                                                          $this->fields["ola_waiting_duration"]);
            // Add current level to do
            $ola->addLevelToDo($this, $this->fields["olalevels_id_ttr"]);

         } else if (array_key_exists("internal_time_to_resolve", $this->fields)) {
            // Change doesn't have internal_time_to_resolve
            // Using calendar
            if (($calendars_id > 0)
                && $calendar->getFromDB($calendars_id)
                && $calendar->hasAWorkingDay()) {
               if ((int)$this->fields['internal_time_to_resolve'] > 0) {
                  // compute new internal_time_to_resolve using calendar
                  $this->updates[]                          = "internal_time_to_resolve";
                  $this->fields['internal_time_to_resolve'] = $calendar->computeEndDate(
                                                                              $this->fields['internal_time_to_resolve'],
                                                                              $delay_time);
               }

            } else { // Not calendar defined
               if ((int)$this->fields['internal_time_to_resolve'] > 0) {
                  // compute new internal_time_to_resolve : no calendar so add computed delay_time
                  $this->updates[]                          = "internal_time_to_resolve";
                  $this->fields['internal_time_to_resolve'] = date('Y-m-d H:i:s',
                                                                   $delay_time +
                                                                   strtotime($this->fields['internal_time_to_resolve']));
               }
            }
         }

         $this->updates[]                   = "waiting_duration";
         $this->fields["waiting_duration"] += $delay_time;

         // Reset begin_waiting_date
         $this->updates[]                    = "begin_waiting_date";
         $this->fields["begin_waiting_date"] = 'NULL';
      }

      // Set begin waiting date if needed
      if ((($key = array_search('status', $this->updates)) !== false)
          && (($this->fields['status'] == self::WAITING)
              || in_array($this->fields["status"], $this->getSolvedStatusArray()))) {

         $this->updates[]                    = "begin_waiting_date";
         $this->fields["begin_waiting_date"] = $_SESSION["glpi_currenttime"];

         // Specific for tickets
         if (isset($this->fields['slas_id_ttr']) && ($this->fields['slas_id_ttr'] > 0)) {
            SLA::deleteLevelsToDo($this);
         }

         if (isset($this->fields['olas_id_ttr']) && ($this->fields['olas_id_ttr'] > 0)) {
            OLA::deleteLevelsToDo($this);
         }
      }

      // solve_delay_stat : use delay between opendate and solvedate
      if (in_array("solvedate", $this->updates)) {
         $this->updates[]                  = "solve_delay_stat";
         $this->fields['solve_delay_stat'] = $this->computeSolveDelayStat();
      }
      // close_delay_stat : use delay between opendate and closedate
      if (in_array("closedate", $this->updates)) {
         $this->updates[]                  = "close_delay_stat";
         $this->fields['close_delay_stat'] = $this->computeCloseDelayStat();
      }

      //Look for reopening
      $statuses = array_merge(
         $this->getSolvedStatusArray(),
         $this->getClosedStatusArray()
      );
      if (($key = array_search('status', $this->updates)) !== false
         && in_array($this->oldvalues['status'], $statuses)
         && !in_array($this->fields['status'], $statuses)
      ) {
         $users_id_reject = 0;
         // set last updater if interactive user
         if (!Session::isCron()) {
            $users_id_reject = Session::getLoginUserID();
         }

         //Mark existing solutions as refused
         $DB->update(
            ITILSolution::getTable(), [
               'status'             => CommonITILValidation::REFUSED,
               'users_id_approval'  => $users_id_reject,
               'date_approval'      => date('Y-m-d H:i:s')
            ], [
               'WHERE'  => [
                  'itemtype'  => static::getType(),
                  'items_id'  => $this->getID()
               ],
               'ORDER'  => [
                  'date_creation DESC',
                  'id DESC'
               ],
               'LIMIT'  => 1
            ]
         );

         //Delete existing survey
         $inquest = new TicketSatisfaction();
         $inquest->delete(['tickets_id' => $this->getID()]);
      }

      if (isset($this->input['_accepted'])) {
         //Mark last solution as approved
         $DB->update(
            ITILSolution::getTable(), [
               'status'             => CommonITILValidation::ACCEPTED,
               'users_id_approval'  => Session::getLoginUserID(),
               'date_approval'      => date('Y-m-d H:i:s')
            ], [
               'WHERE'  => [
                  'itemtype'  => static::getType(),
                  'items_id'  => $this->getID()
               ],
               'ORDER'  => [
                  'date_creation DESC',
                  'id DESC'
               ],
               'LIMIT'  => 1
            ]
         );
      }

      // Do not take into account date_mod if no update is done
      if ((count($this->updates) == 1)
          && (($key = array_search('date_mod', $this->updates)) !== false)) {
         unset($this->updates[$key]);
      }
   }


   function prepareInputForAdd($input) {
      global $CFG_GLPI;

      if (!$this->checkFieldsConsistency($input)) {
         return false;
      }

      if (is_null($input["name"])) {
         $input['name'] = '';
      }

      // save value before clean;
      $title = ltrim($input['name']);

      // Set default status to avoid notice
      if (!isset($input["status"])) {
         $input["status"] = self::INCOMING;
      }

      if (!isset($input["urgency"])
          || !($CFG_GLPI['urgency_mask']&(1<<$input["urgency"]))) {
         $input["urgency"] = 3;
      }
      if (!isset($input["impact"])
          || !($CFG_GLPI['impact_mask']&(1<<$input["impact"]))) {
         $input["impact"] = 3;
      }

      $canpriority = true;
      if ($this->getType() == 'Ticket') {
         $canpriority = Session::haveRight(Ticket::$rightname, Ticket::CHANGEPRIORITY);
      }

      if ($canpriority && !isset($input["priority"]) || !$canpriority) {
         $input["priority"] = $this->computePriority($input["urgency"], $input["impact"]);
      }

      // set last updater if interactive user
      if (!Session::isCron() && ($last_updater = Session::getLoginUserID(true))) {
         $input['users_id_lastupdater'] = $last_updater;
      }

      // No Auto set Import for external source
      if (!isset($input['_auto_import'])) {
         if (!isset($input["_users_id_requester"])) {
            if ($uid = Session::getLoginUserID()) {
               $input["_users_id_requester"] = $uid;
            }
         }
      }

      // No Auto set Import for external source
      if (($uid = Session::getLoginUserID())
          && !isset($input['_auto_import'])) {
         $input["users_id_recipient"] = $uid;
      } else if (isset($input["_users_id_requester"]) && $input["_users_id_requester"]
                 && !isset($input["users_id_recipient"])) {
         if (!is_array($input['_users_id_requester'])) {
            $input["users_id_recipient"] = $input["_users_id_requester"];
         }
      }

      // No name set name
      if (is_null($input["content"])) {
         $input['content'] = '';
      }
      $input["name"]    = ltrim($input["name"]);
      $input['content'] = ltrim($input['content']);
      if (empty($input["name"])) {
         $input['name'] = Html::clean(Html::entity_decode_deep($input['content']));
         $input["name"] = preg_replace('/\\r\\n/', ' ', $input['name']);
         $input["name"] = preg_replace('/\\n/', ' ', $input['name']);
         // For mailcollector
         $input["name"] = preg_replace('/\\\\r\\\\n/', ' ', $input['name']);
         $input["name"] = preg_replace('/\\\\n/', ' ', $input['name']);
         $input['name'] = Toolbox::stripslashes_deep($input['name']);
         $input["name"] = Toolbox::substr($input['name'], 0, 70);
         $input['name'] = Toolbox::addslashes_deep($input['name']);
      }

      // Set default dropdown
      $dropdown_fields = ['entities_id', 'itilcategories_id'];
      foreach ($dropdown_fields as $field) {
         if (!isset($input[$field])) {
            $input[$field] = 0;
         }
      }

      $input = $this->computeDefaultValuesForAdd($input);

      // Do not check mandatory on auto import (mailgates)
      $key = $this->getTemplateFormFieldName();
      if (!isset($input['_auto_import'])) {
         if (isset($input[$key]) && $input[$key]) {
            $tt_class = $this->getType() . 'Template';
            $tt = new $tt_class;
            if ($tt->getFromDBWithData($input[$key])) {
               if (count($tt->mandatory)) {
                  $mandatory_missing = [];
                  $fieldsname        = $tt->getAllowedFieldsNames(true);
                  foreach ($tt->mandatory as $key => $val) {
                     // for title if mandatory (restore initial value)
                     if ($key == 'name') {
                        $input['name']                     = $title;
                     }
                     // Check only defined values : Not defined not in form
                     if (isset($input[$key])) {
                        // If content is also predefined need to be different from predefined value
                        if (($key == 'content')
                              && isset($tt->predefined['content'])) {
                           // Clean new lines to be fix encoding
                           if (strcmp(preg_replace("/\r?\n/", "",
                                                   Html::cleanPostForTextArea($input[$key])),
                                       preg_replace("/\r?\n/", "",
                                                   $tt->predefined['content'])) == 0) {
                              Session::addMessageAfterRedirect(
                                 __('You cannot use predefined description verbatim'),
                                 false,
                                 ERROR
                              );
                              $mandatory_missing[$key] = $fieldsname[$val];
                           }
                        }

                        if (empty($input[$key]) || ($input[$key] == 'NULL')
                              || (is_array($input[$key])
                                 && ($input[$key] === [0 => "0"]))) {

                           $mandatory_missing[$key] = $fieldsname[$val];
                        }
                     }

                     if (($key == '_add_validation')
                           && !empty($input['users_id_validate'])
                           && isset($input['users_id_validate'][0])
                           && ($input['users_id_validate'][0] > 0)) {

                        unset($mandatory_missing['_add_validation']);
                     }

                     if (static::getType() === Ticket::getType()) {
                        // For time_to_resolve and time_to_own : check also slas
                        // For internal_time_to_resolve and internal_time_to_own : check also olas
                        foreach ([SLM::TTR, SLM::TTO] as $slmType) {
                           list($dateField, $slaField) = SLA::getFieldNames($slmType);
                           if (($key == $dateField)
                              && isset($input[$slaField]) && ($input[$slaField] > 0)
                              && isset($mandatory_missing[$dateField])) {
                              unset($mandatory_missing[$dateField]);
                           }
                           list($dateField, $olaField) = OLA::getFieldNames($slmType);
                           if (($key == $dateField)
                              && isset($input[$olaField]) && ($input[$olaField] > 0)
                              && isset($mandatory_missing[$dateField])) {
                              unset($mandatory_missing[$dateField]);
                           }
                        }
                     }

                     // For document mandatory
                     if (($key == '_documents_id')
                           && !isset($input['_filename'])
                           && !isset($input['_tag_filename'])
                           && !isset($input['_content'])
                           && !isset($input['_tag_content'])
                           && !isset($input['_stock_image'])
                           && !isset($input['_tag_stock_image'])) {

                        $mandatory_missing[$key] = $fieldsname[$val];
                     }
                  }

                  if (count($mandatory_missing)) {
                     //TRANS: %s are the fields concerned
                     $message = sprintf(
                        __('Mandatory fields are not filled. Please correct: %s'),
                        implode(", ", $mandatory_missing)
                     );
                     Session::addMessageAfterRedirect($message, false, ERROR);
                     return false;
                  }
               }
            }
         }
      }

      return $input;
   }

   /**
    * Check input fields consistency.
    *
    * @param array $input
    *
    * @return bool
    */
   private function checkFieldsConsistency(array $input): bool {
      if (array_key_exists('date', $input) && !empty($input['date'])
          && (!is_string($input['date']) || !preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $input['date']))) {
         Session::addMessageAfterRedirect(__('Incorrect value for date field.'), false, ERROR);
         return false;
      }

      return true;
   }

   /**
    * Compute default values for Add
    * (to be passed in prepareInputForAdd before and after rules if needed)
    *
    * @since 0.84
    *
    * @param $input
    *
    * @return string
   **/
   function computeDefaultValuesForAdd($input) {

      if (!isset($input["status"])) {
         $input["status"] = self::INCOMING;
      }

      if (!isset($input["date"]) || empty($input["date"])) {
         $input["date"] = $_SESSION["glpi_currenttime"];
      }

      if (isset($input["status"]) && in_array($input["status"], $this->getSolvedStatusArray())) {
         if (isset($input["date"])) {
            $input["solvedate"] = $input["date"];
         } else {
            $input["solvedate"] = $_SESSION["glpi_currenttime"];
         }
      }

      if (isset($input["status"]) && in_array($input["status"], $this->getClosedStatusArray())) {
         if (isset($input["date"])) {
            $input["closedate"] = $input["date"];
         } else {
            $input["closedate"] = $_SESSION["glpi_currenttime"];
         }
         $input['solvedate'] = $input["closedate"];
      }

      // Set begin waiting time if status is waiting
      if (isset($input["status"]) && ($input["status"] == self::WAITING)) {
         $input['begin_waiting_date'] = $input['date'];
      }

      return $input;
   }


   function post_addItem() {

      // Add tasks in tasktemplates if defined in itiltemplate
      if (isset($this->input['_tasktemplates_id'])
          && is_array($this->input['_tasktemplates_id'])
          && count($this->input['_tasktemplates_id'])) {
         $tasktemplate = new TaskTemplate;
         $itiltask_class = $this->getType().'Task';
         $itiltask   = new $itiltask_class;
         foreach ($this->input['_tasktemplates_id'] as $tasktemplates_id) {
            $tasktemplate->getFromDB($tasktemplates_id);
            $tasktemplate_content = Toolbox::addslashes_deep($tasktemplate->fields["content"]);
            $itiltask->add([
               'tasktemplates_id'            => $tasktemplates_id,
               'content'                     => $tasktemplate_content,
               'taskcategories_id'           => $tasktemplate->fields['taskcategories_id'],
               'actiontime'                  => $tasktemplate->fields['actiontime'],
               'state'                       => $tasktemplate->fields['state'],
               $this->getForeignKeyField()   => $this->fields['id'],
               'date'                        => $this->fields['date'],
               'is_private'                  => $tasktemplate->fields['is_private'],
               'users_id_tech'               => $tasktemplate->fields['users_id_tech'],
               'groups_id_tech'              => $tasktemplate->fields['groups_id_tech'],
               '_disablenotif'               => true
            ]);
         }
      }

      // Handle deferred solution addition (for solution templates added by rule)
      if (isset($this->input['_solutiontemplates_id'])) {
         $template = new SolutionTemplate();
         if ($template->getFromDB($this->input['_solutiontemplates_id'])) {
            $solution = new ITILSolution();
            $solution->add([
               "itemtype" => static::getType(),
               "solutiontypes_id" => $template->fields['solutiontypes_id'],
               "content" => Toolbox::addslashes_deep($template->fields['content']),
               "status" => CommonITILValidation::WAITING,
               "items_id" => $this->fields['id']
            ]);
         }
      }

      // Add document if needed, without notification for file input
      $this->input = $this->addFiles($this->input, ['force_update' => true]);
      // Add document if needed, without notification for textarea
      $this->input = $this->addFiles($this->input, ['name' => 'content', 'force_update' => true]);

      // Add default document if set in template
      if (isset($this->input['_documents_id'])
          && is_array($this->input['_documents_id'])
          && count($this->input['_documents_id'])) {
         $docitem = new Document_Item();
         foreach ($this->input['_documents_id'] as $docID) {
            $docitem->add(['documents_id' => $docID,
                                '_do_notif'    => false,
                                'itemtype'     => $this->getType(),
                                'items_id'     => $this->fields['id']]);
         }
      }

      $useractors = null;
      // Add user groups linked to ITIL objects
      if (!empty($this->userlinkclass)) {
         $useractors = new $this->userlinkclass();
      }
      $groupactors = null;
      if (!empty($this->grouplinkclass)) {
         $groupactors = new $this->grouplinkclass();
      }
      $supplieractors = null;
      if (!empty($this->supplierlinkclass)) {
         $supplieractors = new $this->supplierlinkclass();
      }

      // "do not compute" flag set by business rules for "takeintoaccount_delay_stat" field
      $do_not_compute_takeintoaccount = $this->isTakeIntoAccountComputationBlocked($this->input);

      if (!is_null($useractors)) {
         $user_input = [
            $useractors->getItilObjectForeignKey() => $this->fields['id'],
            '_do_not_compute_takeintoaccount'      => $do_not_compute_takeintoaccount,
            '_from_object'                         => true,
         ];

         if (isset($this->input["_users_id_requester"])) {

            if (is_array($this->input["_users_id_requester"])) {
               $tab_requester = $this->input["_users_id_requester"];
            } else {
               $tab_requester   = [];
               $tab_requester[] = $this->input["_users_id_requester"];
            }

            $requesterToAdd = [];
            foreach ($tab_requester as $key_requester => $requester) {
               if (in_array($requester, $requesterToAdd)) {
                  // This requester ID is already added;
                  continue;
               }

               $input2 = [
                  'users_id' => $requester,
                  'type'     => CommonITILActor::REQUESTER,
               ] + $user_input;

               if (isset($this->input["_users_id_requester_notif"])) {
                  foreach ($this->input["_users_id_requester_notif"] as $key => $val) {
                     if (isset($val[$key_requester])) {
                        $input2[$key] = $val[$key_requester];
                     }
                  }
               }

               //empty actor
               if ($input2['users_id'] == 0
                   && (!isset($input2['alternative_email'])
                       || empty($input2['alternative_email']))) {
                  continue;
               } else if ($requester != 0) {
                  $requesterToAdd[] = $requester;
               }

               $useractors->add($input2);
            }
         }

         if (isset($this->input["_users_id_observer"])) {

            if (is_array($this->input["_users_id_observer"])) {
               $tab_observer = $this->input["_users_id_observer"];
            } else {
               $tab_observer   = [];
               $tab_observer[] = $this->input["_users_id_observer"];
            }

            $observerToAdd = [];
            foreach ($tab_observer as $key_observer => $observer) {
               if (in_array($observer, $observerToAdd)) {
                  // This observer ID is already added;
                  continue;
               }

               $input2 = [
                  'users_id' => $observer,
                  'type'     => CommonITILActor::OBSERVER,
               ] + $user_input;

               if (isset($this->input["_users_id_observer_notif"])) {
                  foreach ($this->input["_users_id_observer_notif"] as $key => $val) {
                     if (isset($val[$key_observer])) {
                        $input2[$key] = $val[$key_observer];
                     }
                  }
               }

               //empty actor
               if ($input2['users_id'] == 0
                   && (!isset($input2['alternative_email'])
                       || empty($input2['alternative_email']))) {
                  continue;
               } else if ($observer != 0) {
                  $observerToAdd[] = $observer;
               }

               $useractors->add($input2);
            }
         }

         if (isset($this->input["_users_id_assign"])) {

            if (is_array($this->input["_users_id_assign"])) {
               $tab_assign = $this->input["_users_id_assign"];
            } else {
               $tab_assign   = [];
               $tab_assign[] = $this->input["_users_id_assign"];
            }

            $assignToAdd = [];
            foreach ($tab_assign as $key_assign => $assign) {
               if (in_array($assign, $assignToAdd)) {
                  // This assigned user ID is already added;
                  continue;
               }

               $input2 = [
                  'users_id' => $assign,
                  'type'     => CommonITILActor::ASSIGN,
               ] + $user_input;

               if (isset($this->input["_users_id_assign_notif"])) {
                  foreach ($this->input["_users_id_assign_notif"] as $key => $val) {
                     if (isset($val[$key_assign])) {
                        $input2[$key] = $val[$key_assign];
                     }
                  }
               }

               //empty actor
               if ($input2['users_id'] == 0
                   && (!isset($input2['alternative_email'])
                       || empty($input2['alternative_email']))) {
                  continue;
               } else if ($assign != 0) {
                  $assignToAdd[] = $assign;
               }

               $useractors->add($input2);
            }
         }
      }

      if (!is_null($groupactors)) {
         $group_input = [
            $groupactors->getItilObjectForeignKey() => $this->fields['id'],
            '_do_not_compute_takeintoaccount'       => $do_not_compute_takeintoaccount,
            '_from_object'                          => true,
         ];

         if (isset($this->input["_groups_id_requester"])) {
            $groups_id_requester = $this->input["_groups_id_requester"];
            if (!is_array($this->input["_groups_id_requester"])) {
               $groups_id_requester = [$this->input["_groups_id_requester"]];
            } else {
               $groups_id_requester = $this->input["_groups_id_requester"];
            }
            foreach ($groups_id_requester as $groups_id) {
               if ($groups_id > 0) {
                  $groupactors->add(
                     [
                        'groups_id' => $groups_id,
                        'type'      => CommonITILActor::REQUESTER,
                     ] + $group_input
                  );
               }
            }
         }

         if (isset($this->input["_groups_id_assign"])) {
            if (!is_array($this->input["_groups_id_assign"])) {
               $groups_id_assign = [$this->input["_groups_id_assign"]];
            } else {
               $groups_id_assign = $this->input["_groups_id_assign"];
            }
            foreach ($groups_id_assign as $groups_id) {
               if ($groups_id > 0) {
                  $groupactors->add(
                     [
                        'groups_id' => $groups_id,
                        'type'      => CommonITILActor::ASSIGN,
                     ] + $group_input
                  );
               }
            }
         }

         if (isset($this->input["_groups_id_observer"])) {
            if (!is_array($this->input["_groups_id_observer"])) {
               $groups_id_observer = [$this->input["_groups_id_observer"]];
            } else {
               $groups_id_observer = $this->input["_groups_id_observer"];
            }
            foreach ($groups_id_observer as $groups_id) {
               if ($groups_id > 0) {
                  $groupactors->add(
                     [
                        'groups_id' => $groups_id,
                        'type'      => CommonITILActor::OBSERVER,
                     ] + $group_input
                  );
               }
            }
         }
      }

      if (!is_null($supplieractors)) {
         $supplier_input = [
            $supplieractors->getItilObjectForeignKey() => $this->fields['id'],
            '_do_not_compute_takeintoaccount'          => $do_not_compute_takeintoaccount,
            '_from_object'                             => true,
         ];

         if (isset($this->input["_suppliers_id_assign"])
             && ($this->input["_suppliers_id_assign"] > 0)) {

            if (is_array($this->input["_suppliers_id_assign"])) {
               $tab_assign = $this->input["_suppliers_id_assign"];
            } else {
               $tab_assign   = [];
               $tab_assign[] = $this->input["_suppliers_id_assign"];
            }

            $supplierToAdd = [];
            foreach ($tab_assign as $key_assign => $assign) {
               if (in_array($assign, $supplierToAdd)) {
                  // This assigned supplier ID is already added;
                  continue;
               }
               $input3 = [
                  'suppliers_id' => $assign,
                  'type'         => CommonITILActor::ASSIGN,
               ] + $supplier_input;

               if (isset($this->input["_suppliers_id_assign_notif"])) {
                  foreach ($this->input["_suppliers_id_assign_notif"] as $key => $val) {
                     $input3[$key] = $val[$key_assign];
                  }
               }

               //empty supplier
               if ($input3['suppliers_id'] == 0
                   && (!isset($input3['alternative_email'])
                       || empty($input3['alternative_email']))) {
                  continue;
               } else if ($assign != 0) {
                  $supplierToAdd[] = $assign;
               }

               $supplieractors->add($input3);
            }
         }
      }

      // Additional actors
      $this->addAdditionalActors($this->input);

   }

   /**
   * @see CommonDBTM::post_clone
   */
   function post_clone($source, $history) {
      global $DB;
      $update = [];
      if (isset($source->fields['users_id_lastupdater'])) {
         $update['users_id_lastupdater'] = $source->fields['users_id_lastupdater'];
      }
      if (isset($source->fields['status'])) {
         $update['status'] = $source->fields['status'];
      }
      $DB->update(
         $this->getTable(),
         $update,
         ['id' => $this->getID()]
      );

   }


   /**
    * @since 0.84
    * @since 0.85 must have param $input
   **/
   private function addAdditionalActors($input) {

      $useractors = null;
      // Add user groups linked to ITIL objects
      if (!empty($this->userlinkclass)) {
         $useractors = new $this->userlinkclass();
      }
      $groupactors = null;
      if (!empty($this->grouplinkclass)) {
         $groupactors = new $this->grouplinkclass();
      }
      $supplieractors = null;
      if (!empty($this->supplierlinkclass)) {
         $supplieractors = new $this->supplierlinkclass();
      }

      // "do not compute" flag set by business rules for "takeintoaccount_delay_stat" field
      $do_not_compute_takeintoaccount = $this->isTakeIntoAccountComputationBlocked($input);

      // Additional groups actors
      if (!is_null($groupactors)) {
         $group_input = [
            $groupactors->getItilObjectForeignKey() => $this->fields['id'],
            '_do_not_compute_takeintoaccount'       => $do_not_compute_takeintoaccount,
            '_from_object'                          => true,
         ];

         // Requesters
         if (isset($input['_additional_groups_requesters'])
             && is_array($input['_additional_groups_requesters'])
             && count($input['_additional_groups_requesters'])) {
            foreach ($input['_additional_groups_requesters'] as $tmp) {
               if ($tmp > 0) {
                  $groupactors->add(
                     [
                        'type'      => CommonITILActor::REQUESTER,
                        'groups_id' => $tmp,
                     ] + $group_input
                  );
               }
            }
         }

         // Observers
         if (isset($input['_additional_groups_observers'])
             && is_array($input['_additional_groups_observers'])
             && count($input['_additional_groups_observers'])) {
            foreach ($input['_additional_groups_observers'] as $tmp) {
               if ($tmp > 0) {
                  $groupactors->add(
                     [
                        'type'      => CommonITILActor::OBSERVER,
                        'groups_id' => $tmp,
                     ] + $group_input
                  );
               }
            }
         }

         // Assigns
         if (isset($input['_additional_groups_assigns'])
             && is_array($input['_additional_groups_assigns'])
             && count($input['_additional_groups_assigns'])) {
            foreach ($input['_additional_groups_assigns'] as $tmp) {
               if ($tmp > 0) {
                  $groupactors->add(
                     [
                        'type'      => CommonITILActor::ASSIGN,
                        'groups_id' => $tmp,
                     ] + $group_input
                  );
               }
            }
         }
      }

      // Additional suppliers actors
      if (!is_null($supplieractors)) {
         $supplier_input = [
            $supplieractors->getItilObjectForeignKey() => $this->fields['id'],
            '_do_not_compute_takeintoaccount'          => $do_not_compute_takeintoaccount,
            '_from_object'                             => true,
         ];

         // Assigns
         if (isset($input['_additional_suppliers_assigns'])
             && is_array($input['_additional_suppliers_assigns'])
             && count($input['_additional_suppliers_assigns'])) {

            $input2 = [
               'type' => CommonITILActor::ASSIGN,
            ] + $supplier_input;

            foreach ($input["_additional_suppliers_assigns"] as $tmp) {
               if (isset($tmp['suppliers_id'])) {
                  foreach ($tmp as $key => $val) {
                     $input2[$key] = $val;
                  }
                  $supplieractors->add($input2);
               }
            }
         }
      }

      // Additional actors : using default notification parameters
      if (!is_null($useractors)) {
         $user_input = [
            $useractors->getItilObjectForeignKey() => $this->fields['id'],
            '_do_not_compute_takeintoaccount'      => $do_not_compute_takeintoaccount,
            '_from_object'                         => true,
         ];

         // Observers : for mailcollector
         if (isset($input["_additional_observers"])
             && is_array($input["_additional_observers"])
             && count($input["_additional_observers"])) {

            $input2 = [
               'type' => CommonITILActor::OBSERVER,
            ] + $user_input;

            foreach ($input["_additional_observers"] as $tmp) {
               if (isset($tmp['users_id'])) {
                  foreach ($tmp as $key => $val) {
                     $input2[$key] = $val;
                  }
                  $useractors->add($input2);
               }
            }
         }

         if (isset($input["_additional_assigns"])
             && is_array($input["_additional_assigns"])
             && count($input["_additional_assigns"])) {

            $input2 = [
               'type' => CommonITILActor::ASSIGN,
            ] + $user_input;

            foreach ($input["_additional_assigns"] as $tmp) {
               if (isset($tmp['users_id'])) {
                  foreach ($tmp as $key => $val) {
                     $input2[$key] = $val;
                  }
                  $useractors->add($input2);
               }
            }
         }
         if (isset($input["_additional_requesters"])
             && is_array($input["_additional_requesters"])
             && count($input["_additional_requesters"])) {

            $input2 = [
               'type' => CommonITILActor::REQUESTER,
            ] + $user_input;

            foreach ($input["_additional_requesters"] as $tmp) {
               if (isset($tmp['users_id'])) {
                  foreach ($tmp as $key => $val) {
                     $input2[$key] = $val;
                  }
                  $useractors->add($input2);
               }
            }
         }
      }
   }


   /**
    * Compute Priority
    *
    * @since 0.84
    *
    * @param $urgency   integer from 1 to 5
    * @param $impact    integer from 1 to 5
    *
    * @return integer from 1 to 5 (priority)
   **/
   static function computePriority($urgency, $impact) {
      global $CFG_GLPI;

      if (isset($CFG_GLPI[static::MATRIX_FIELD][$urgency][$impact])) {
         return $CFG_GLPI[static::MATRIX_FIELD][$urgency][$impact];
      }
      // Failback to trivial
      return round(($urgency+$impact)/2);
   }


   /**
    * Dropdown of ITIL object priority
    *
    * @since  version 0.84 new proto
    *
    * @param $options array of options
    *       - name     : select name (default is urgency)
    *       - value    : default value (default 0)
    *       - showtype : list proposed : normal, search (default normal)
    *       - wthmajor : boolean with major priority ?
    *       - display  : boolean if false get string
    *
    * @return string id of the select
   **/
   static function dropdownPriority(array $options = []) {

      $p = [
         'name'      => 'priority',
         'value'     => 0,
         'showtype'  => 'normal',
         'display'   => true,
         'withmajor' => false,
      ];

      if (is_array($options) && count($options)) {
         foreach ($options as $key => $val) {
            $p[$key] = $val;
         }
      }

      $values = [];

      if ($p['showtype'] == 'search') {
         $values[0]  = static::getPriorityName(0);
         $values[-5] = static::getPriorityName(-5);
         $values[-4] = static::getPriorityName(-4);
         $values[-3] = static::getPriorityName(-3);
         $values[-2] = static::getPriorityName(-2);
         $values[-1] = static::getPriorityName(-1);
      }

      if (($p['showtype'] == 'search')
          || $p['withmajor']) {
         $values[6] = static::getPriorityName(6);
      }
      $values[5] = static::getPriorityName(5);
      $values[4] = static::getPriorityName(4);
      $values[3] = static::getPriorityName(3);
      $values[2] = static::getPriorityName(2);
      $values[1] = static::getPriorityName(1);

      return Dropdown::showFromArray($p['name'], $values, $p);
   }


   /**
    * Get ITIL object priority Name
    *
    * @param integer $value priority ID
   **/
   static function getPriorityName($value) {

      switch ($value) {
         case 6 :
            return _x('priority', 'Major');

         case 5 :
            return _x('priority', 'Very high');

         case 4 :
            return _x('priority', 'High');

         case 3 :
            return _x('priority', 'Medium');

         case 2 :
            return _x('priority', 'Low');

         case 1 :
            return _x('priority', 'Very low');

         // No standard one :
         case 0 :
            return _x('priority', 'All');
         case -1 :
            return _x('priority', 'At least very low');
         case -2 :
            return _x('priority', 'At least low');
         case -3 :
            return _x('priority', 'At least medium');
         case -4 :
            return _x('priority', 'At least high');
         case -5 :
            return _x('priority', 'At least very high');

         default :
            // Return $value if not define
            return $value;

      }
   }


   /**
    * Dropdown of ITIL object Urgency
    *
    * @since 0.84 new proto
    *
    * @param $options array of options
    *       - name     : select name (default is urgency)
    *       - value    : default value (default 0)
    *       - showtype : list proposed : normal, search (default normal)
    *       - display  : boolean if false get string
    *
    * @return string id of the select
   **/
   static function dropdownUrgency(array $options = []) {
      global $CFG_GLPI;

      $p = [
         'name'     => 'urgency',
         'value'    => 0,
         'showtype' => 'normal',
         'display'  => true,
      ];

      if (is_array($options) && count($options)) {
         foreach ($options as $key => $val) {
            $p[$key] = $val;
         }
      }

      $values = [];

      if ($p['showtype'] == 'search') {
         $values[0]  = static::getUrgencyName(0);
         $values[-5] = static::getUrgencyName(-5);
         $values[-4] = static::getUrgencyName(-4);
         $values[-3] = static::getUrgencyName(-3);
         $values[-2] = static::getUrgencyName(-2);
         $values[-1] = static::getUrgencyName(-1);
      }

      if (isset($CFG_GLPI[static::URGENCY_MASK_FIELD])) {
         if (($p['showtype'] == 'search')
             || ($CFG_GLPI[static::URGENCY_MASK_FIELD] & (1<<5))) {
            $values[5]  = static::getUrgencyName(5);
         }

         if (($p['showtype'] == 'search')
             || ($CFG_GLPI[static::URGENCY_MASK_FIELD] & (1<<4))) {
            $values[4]  = static::getUrgencyName(4);
         }

         $values[3]  = static::getUrgencyName(3);

         if (($p['showtype'] == 'search')
             || ($CFG_GLPI[static::URGENCY_MASK_FIELD] & (1<<2))) {
            $values[2]  = static::getUrgencyName(2);
         }

         if (($p['showtype'] == 'search')
             || ($CFG_GLPI[static::URGENCY_MASK_FIELD] & (1<<1))) {
            $values[1]  = static::getUrgencyName(1);
         }
      }

      return Dropdown::showFromArray($p['name'], $values, $p);
   }


   /**
    * Get ITIL object Urgency Name
    *
    * @param integer $value urgency ID
   **/
   static function getUrgencyName($value) {

      switch ($value) {
         case 5 :
            return _x('urgency', 'Very high');

         case 4 :
            return _x('urgency', 'High');

         case 3 :
            return _x('urgency', 'Medium');

         case 2 :
            return _x('urgency', 'Low');

         case 1 :
            return _x('urgency', 'Very low');

         // No standard one :
         case 0 :
            return _x('urgency', 'All');
         case -1 :
            return _x('urgency', 'At least very low');
         case -2 :
            return _x('urgency', 'At least low');
         case -3 :
            return _x('urgency', 'At least medium');
         case -4 :
            return _x('urgency', 'At least high');
         case -5 :
            return _x('urgency', 'At least very high');

         default :
            // Return $value if not define
            return $value;

      }
   }


   /**
    * Dropdown of ITIL object Impact
    *
    * @since 0.84 new proto
    *
    * @param $options   array of options
    *  - name     : select name (default is impact)
    *  - value    : default value (default 0)
    *  - showtype : list proposed : normal, search (default normal)
    *  - display  : boolean if false get string
    *
    * \
    * @return string id of the select
   **/
   static function dropdownImpact(array $options = []) {
      global $CFG_GLPI;

      $p = [
         'name'     => 'impact',
         'value'    => 0,
         'showtype' => 'normal',
         'display'  => true,
      ];

      if (is_array($options) && count($options)) {
         foreach ($options as $key => $val) {
            $p[$key] = $val;
         }
      }
      $values = [];

      if ($p['showtype'] == 'search') {
         $values[0]  = static::getImpactName(0);
         $values[-5] = static::getImpactName(-5);
         $values[-4] = static::getImpactName(-4);
         $values[-3] = static::getImpactName(-3);
         $values[-2] = static::getImpactName(-2);
         $values[-1] = static::getImpactName(-1);
      }

      if (isset($CFG_GLPI[static::IMPACT_MASK_FIELD])) {
         if (($p['showtype'] == 'search')
             || ($CFG_GLPI[static::IMPACT_MASK_FIELD] & (1<<5))) {
            $values[5]  = static::getImpactName(5);
         }

         if (($p['showtype'] == 'search')
             || ($CFG_GLPI[static::IMPACT_MASK_FIELD] & (1<<4))) {
            $values[4]  = static::getImpactName(4);
         }

         $values[3]  = static::getImpactName(3);

         if (($p['showtype'] == 'search')
             || ($CFG_GLPI[static::IMPACT_MASK_FIELD] & (1<<2))) {
            $values[2]  = static::getImpactName(2);
         }

         if (($p['showtype'] == 'search')
             || ($CFG_GLPI[static::IMPACT_MASK_FIELD] & (1<<1))) {
            $values[1]  = static::getImpactName(1);
         }
      }

      return Dropdown::showFromArray($p['name'], $values, $p);
   }


   /**
    * Get ITIL object Impact Name
    *
    * @param integer $value impact ID
   **/
   static function getImpactName($value) {

      switch ($value) {
         case 5 :
            return _x('impact', 'Very high');

         case 4 :
            return _x('impact', 'High');

         case 3 :
            return _x('impact', 'Medium');

         case 2 :
            return _x('impact', 'Low');

         case 1 :
            return _x('impact', 'Very low');

         // No standard one :
         case 0 :
            return _x('impact', 'All');
         case -1 :
            return _x('impact', 'At least very low');
         case -2 :
            return _x('impact', 'At least low');
         case -3 :
            return _x('impact', 'At least medium');
         case -4 :
            return _x('impact', 'At least high');
         case -5 :
            return _x('impact', 'At least very high');

         default :
            // Return $value if not define
            return $value;
      }
   }


   /**
    * Get the ITIL object status list
    *
    * @param $withmetaforsearch boolean (false by default)
    *
    * @return array
   **/
   static function getAllStatusArray($withmetaforsearch = false) {

      // To be overridden by class
      $tab = [];

      return $tab;
   }


   /**
    * Get the ITIL object closed status list
    *
    * @since 0.83
    *
    * @return array
   **/
   static function getClosedStatusArray() {

      // To be overridden by class
      $tab = [];
      return $tab;
   }


   /**
    * Get the ITIL object solved status list
    *
    * @since 0.83
    *
    * @return array
   **/
   static function getSolvedStatusArray() {

      // To be overridden by class
      $tab = [];
      return $tab;
   }

   /**
    * Get the ITIL object all status list without solved and closed status
    *
    * @since 9.2.1
    *
    * @return array
   **/
   static function getNotSolvedStatusArray() {
      $all = static::getAllStatusArray();
      foreach (static::getSolvedStatusArray() as $status) {
         if (isset($all[$status])) {
            unset($all[$status]);
         }
      }
      foreach (static::getClosedStatusArray() as $status) {
         if (isset($all[$status])) {
            unset($all[$status]);
         }
      }
      $nosolved = array_keys($all);

      return $nosolved;
   }


   /**
    * Get the ITIL object new status list
    *
    * @since 0.83.8
    *
    * @return array
   **/
   static function getNewStatusArray() {

      // To be overriden by class
      $tab = [];
      return $tab;
   }


   /**
    * Get the ITIL object process status list
    *
    * @since 0.83
    *
    * @return array
   **/
   static function getProcessStatus() {

      // To be overridden by class
      $tab = [];
      return $tab;
   }


   /**
    * check is the user can change from / to a status
    *
    * @since 0.84
    *
    * @param integer $old value of old/current status
    * @param integer $new value of target status
    *
    * @return boolean
   **/
   static function isAllowedStatus($old, $new) {

      if (isset($_SESSION['glpiactiveprofile'][static::STATUS_MATRIX_FIELD][$old][$new])
          && !$_SESSION['glpiactiveprofile'][static::STATUS_MATRIX_FIELD][$old][$new]) {
         return false;
      }

      if (array_key_exists(static::STATUS_MATRIX_FIELD,
                           $_SESSION['glpiactiveprofile'])) { // maybe not set for post-only
         return true;
      }

      return false;
   }


   /**
    * Get the ITIL object status allowed for a current status
    *
    * @since 0.84 new proto
    *
    * @param integer $current   status
    *
    * @return array
   **/
   static function getAllowedStatusArray($current) {

      $tab = static::getAllStatusArray();
      if (!isset($current)) {
         $current = self::INCOMING;
      }

      foreach (array_keys($tab) as $status) {
         if (($status != $current)
             && !static::isAllowedStatus($current, $status)) {
            unset($tab[$status]);
         }
      }
      return $tab;
   }

   /**
    * Is the ITIL object status exists for the object
    *
    * @since 0.85
    *
    * @param integer $status   status
    *
    * @return boolean
   **/
   static function isStatusExists($status) {

      $tab = static::getAllStatusArray();

      return isset($tab[$status]);
   }

   /**
    * Dropdown of object status
    *
    * @since 0.84 new proto
    *
    * @param $options   array of options
    *  - name     : select name (default is status)
    *  - value    : default value (default self::INCOMING)
    *  - showtype : list proposed : normal, search or allowed (default normal)
    *  - display  : boolean if false get string
    *
    * @return string|integer Output string if display option is set to false,
    *                        otherwise random part of dropdown id
   **/
   static function dropdownStatus(array $options = []) {

      $p = [
         'name'     => 'status',
         'showtype' => 'normal',
         'display'  => true,
      ];

      if (is_array($options) && count($options)) {
         foreach ($options as $key => $val) {
            $p[$key] = $val;
         }
      }

      if (!isset($p['value']) || empty($p['value'])) {
         $p['value']     = self::INCOMING;
      }

      switch ($p['showtype']) {
         case 'allowed' :
            $tab = static::getAllowedStatusArray($p['value']);
            break;

         case 'search' :
            $tab = static::getAllStatusArray(true);
            break;

         default :
            $tab = static::getAllStatusArray(false);
            break;
      }

      return Dropdown::showFromArray($p['name'], $tab, $p);
   }


   /**
    * Get ITIL object status Name
    *
    * @since 0.84
    *
    * @param integer $value     status ID
   **/
   static function getStatus($value) {

      $tab  = static::getAllStatusArray(true);
      // Return $value if not defined
      return (isset($tab[$value]) ? $tab[$value] : $value);
   }


   /**
    * get field part name corresponding to actor type
    *
    * @param $type      integer : user type
    *
    * @since 0.84.6
    *
    * @return string|boolean Field part or false if not applicable
   **/
   static function getActorFieldNameType($type) {

      switch ($type) {
         case CommonITILActor::REQUESTER :
            return 'requester';

         case CommonITILActor::OBSERVER :
            return 'observer';

         case CommonITILActor::ASSIGN :
            return 'assign';

         default :
            return false;
      }
   }


   /**
    * show groups asociated
    *
    * @param $type      integer : user type
    * @param $canedit   boolean : can edit ?
    * @param $options   array    options for default values ($options of showForm)
    *
    * @return void
   **/
   function showGroupsAssociated($type, $canedit, array $options = []) {

      $groupicon = static::getActorIcon('group', $type);
      $group     = new Group();
      $linkclass = new $this->grouplinkclass();

      $typename  = static::getActorFieldNameType($type);

      $candelete = true;
      $mandatory = '';
      // For ticket templates : mandatories
      $key = $this->getTemplateFormFieldName();
      if (isset($options[$key])) {
         $mandatory = $options[$key]->getMandatoryMark("_groups_id_".$typename);
         if ($options[$key]->isMandatoryField("_groups_id_".$typename)
             && isset($this->groups[$type]) && (count($this->groups[$type])==1)) {
            $candelete = false;
         }
      }

      if (isset($this->groups[$type]) && count($this->groups[$type])) {
         foreach ($this->groups[$type] as $d) {
            echo "<div class='actor_row'>";
            $k = $d['groups_id'];
            echo "$mandatory$groupicon&nbsp;";
            if ($group->getFromDB($k)) {
               $entity = $this->getEntityID();
               if (Entity::getUsedConfig('anonymize_support_agents', $entity)
                  && Session::getCurrentInterface() == 'helpdesk'
                  && $type == CommonITILActor::ASSIGN
               ) {
                  echo __("Helpdesk group");
               } else {
                  echo $group->getLink(['comments' => true]);
               }
            }
            if ($canedit && $candelete) {
               Html::showSimpleForm($linkclass->getFormURL(), 'delete',
                                    _x('button', 'Delete permanently'),
                                    ['id' => $d['id']],
                                    'fa-times-circle');
            }
            echo "</div>";
         }
      }
   }

   /**
    * show suppliers associated
    *
    * @since 0.84
    *
    * @param $type      integer : user type
    * @param $canedit   boolean : can edit ?
    * @param $options   array    options for default values ($options of showForm)
    *
    * @return void
   **/
   function showSuppliersAssociated($type, $canedit, array $options = []) {
      global $CFG_GLPI;

      $showsupplierlink = 0;
      if (Session::haveRight('contact_enterprise', READ)) {
         $showsupplierlink = 2;
      }

      $suppliericon = static::getActorIcon('supplier', $type);
      $supplier     = new Supplier();
      $linksupplier = new $this->supplierlinkclass();

      $typename     = static::getActorFieldNameType($type);

      $candelete    = true;
      $mandatory    = '';
      // For ticket templates : mandatories
      $key = $this->getTemplateFormFieldName();
      if (isset($options[$key])) {
         $mandatory = $options[$key]->getMandatoryMark("_suppliers_id_".$typename);
         if ($options[$key]->isMandatoryField("_suppliers_id_".$typename)
             && isset($this->suppliers[$type]) && (count($this->suppliers[$type])==1)) {
            $candelete = false;
         }
      }

      if (isset($this->suppliers[$type]) && count($this->suppliers[$type])) {
         foreach ($this->suppliers[$type] as $d) {
            echo "<div class='actor_row'>";
            $suppliers_id = $d['suppliers_id'];

            echo "$mandatory$suppliericon&nbsp;";

            $email = $d['alternative_email'];
            if ($suppliers_id) {
               if ($supplier->getFromDB($suppliers_id)) {
                  echo $supplier->getLink(['comments' => $showsupplierlink]);
                  echo "&nbsp;";

                  $tmpname = Dropdown::getDropdownName($supplier->getTable(), $suppliers_id, 1);
                  Html::showToolTip($tmpname['comment']);

                  if (empty($email)) {
                     $email = $supplier->fields['email'];
                  }
               }
            } else {
               echo "<a href='mailto:$email'>$email</a>";
            }

            if ($CFG_GLPI['notifications_mailing']) {
               $text = __('Email followup')
                  . "&nbsp;" . Dropdown::getYesNo($d['use_notification'])
                  . '<br />';

               if ($d['use_notification']) {
                  $text .= sprintf(__('%1$s: %2$s'), _n('Email', 'Emails', 1), $email);
               }
               if ($canedit) {
                  $opt = ['awesome-class' => 'fa-envelope',
                          'popup' => $linksupplier->getFormURLWithID($d['id'])];
                  Html::showToolTip($text, $opt);
               }
            }

            if ($canedit && $candelete) {
               Html::showSimpleForm($linksupplier->getFormURL(), 'delete',
                                    _x('button', 'Delete permanently'),
                                    ['id' => $d['id']],
                                    'fa-times-circle');
            }

            echo '</div>';
         }
      }
   }

   /**
    * display a value according to a field
    *
    * @since 0.83
    *
    * @param $field     String         name of the field
    * @param $values    String / Array with the value to display
    * @param $options   Array          of option
    *
    * @return a string
   **/
   static function getSpecificValueToDisplay($field, $values, array $options = []) {

      if (!is_array($values)) {
         $values = [$field => $values];
      }
      switch ($field) {
         case 'status':
            return static::getStatus($values[$field]);

         case 'urgency':
            return static::getUrgencyName($values[$field]);

         case 'impact':
            return static::getImpactName($values[$field]);

         case 'priority':
            return static::getPriorityName($values[$field]);

         case 'global_validation' :
            return CommonITILValidation::getStatus($values[$field]);

      }
      return parent::getSpecificValueToDisplay($field, $values, $options);
   }


   /**
    * @since 0.84
    *
    * @param $field
    * @param $name            (default '')
    * @param $values          (default '')
    * @param $options   array
   **/
   static function getSpecificValueToSelect($field, $name = '', $values = '', array $options = []) {

      if (!is_array($values)) {
         $values = [$field => $values];
      }
      $options['display'] = false;

      switch ($field) {
         case 'status' :
            $options['name']  = $name;
            $options['value'] = $values[$field];
            return static::dropdownStatus($options);

         case 'impact' :
            $options['name']  = $name;
            $options['value'] = $values[$field];
            return static::dropdownImpact($options);

         case 'urgency' :
            $options['name']  = $name;
            $options['value'] = $values[$field];
            return static::dropdownUrgency($options);

         case 'priority' :
            $options['name']  = $name;
            $options['value'] = $values[$field];
            return static::dropdownPriority($options);

         case 'global_validation' :
            $options['global'] = true;
            $options['value']  = $values[$field];
            return CommonITILValidation::dropdownStatus($name, $options);
      }
      return parent::getSpecificValueToSelect($field, $name, $values, $options);
   }


   /**
    * @since 0.85
    *
    * @see CommonDBTM::showMassiveActionsSubForm()
   **/
   static function showMassiveActionsSubForm(MassiveAction $ma) {
      global $CFG_GLPI;

      switch ($ma->getAction()) {
         case 'add_task' :
            $itemtype = $ma->getItemtype(true);
            $tasktype = $itemtype.'Task';
            if ($ttype = getItemForItemtype($tasktype)) {
               $ttype->showMassiveActionAddTaskForm();
               return true;
            }
            return false;

         case 'add_actor' :
            $types            = [0                          => Dropdown::EMPTY_VALUE,
                                      CommonITILActor::REQUESTER => _n('Requester', 'Requesters', 1),
                                      CommonITILActor::OBSERVER  => _n('Watcher', 'Watchers', 1),
                                      CommonITILActor::ASSIGN    => __('Assigned to')];
            $rand             = Dropdown::showFromArray('actortype', $types);

            $paramsmassaction = ['actortype' => '__VALUE__'];

            Ajax::updateItemOnSelectEvent("dropdown_actortype$rand", "show_massiveaction_field",
                                          $CFG_GLPI["root_doc"].
                                             "/ajax/dropdownMassiveActionAddActor.php",
                                          $paramsmassaction);
            echo "<span id='show_massiveaction_field'>&nbsp;</span>\n";
            return true;
         case 'update_notif' :

            Dropdown::showYesNo('use_notification');
            echo "<br><br>";
            echo Html::submit(_x('button', 'Post'), ['name' => 'massiveaction']);
            return true;
            return true;
      }
      return parent::showMassiveActionsSubForm($ma);
   }


   /**
    * @since 0.85
    *
    * @see CommonDBTM::processMassiveActionsForOneItemtype()
   **/
   static function processMassiveActionsForOneItemtype(MassiveAction $ma, CommonDBTM $item,
                                                       array $ids) {

      switch ($ma->getAction()) {
         case 'add_actor' :
            $input = $ma->getInput();
            foreach ($ids as $id) {
               $input2 = ['id' => $id];
               if (isset($input['_itil_requester'])) {
                  $input2['_itil_requester'] = $input['_itil_requester'];
               }
               if (isset($input['_itil_observer'])) {
                  $input2['_itil_observer'] = $input['_itil_observer'];
               }
               if (isset($input['_itil_assign'])) {
                  $input2['_itil_assign'] = $input['_itil_assign'];
               }
               if ($item->can($id, UPDATE)) {
                  if ($item->update($input2)) {
                     $ma->itemDone($item->getType(), $id, MassiveAction::ACTION_OK);
                  } else {
                     $ma->itemDone($item->getType(), $id, MassiveAction::ACTION_KO);
                     $ma->addMessage($item->getErrorMessage(ERROR_ON_ACTION));
                  }
               } else {
                  $ma->itemDone($item->getType(), $id, MassiveAction::ACTION_NORIGHT);
                  $ma->addMessage($item->getErrorMessage(ERROR_RIGHT));
               }
            }
            return;

         case 'update_notif' :
            $input = $ma->getInput();
            foreach ($ids as $id) {
               if ($item->can($id, UPDATE)) {
                  $linkclass = new $item->userlinkclass();
                  foreach ($linkclass->getActors($id) as $users) {
                     foreach ($users as $data) {
                        $data['use_notification'] = $input['use_notification'];
                        $linkclass->update($data);
                     }
                  }
                  $linkclass = new $item->supplierlinkclass();
                  foreach ($linkclass->getActors($id) as $users) {
                     foreach ($users as $data) {
                        $data['use_notification'] = $input['use_notification'];
                        $linkclass->update($data);
                     }
                  }

                  $ma->itemDone($item->getType(), $id, MassiveAction::ACTION_OK);
               } else {
                  $ma->itemDone($item->getType(), $id, MassiveAction::ACTION_NORIGHT);
                  $ma->addMessage($item->getErrorMessage(ERROR_RIGHT));
               }
            }
            return;

         case 'add_task' :
            if (!($task = getItemForItemtype($item->getType().'Task'))) {
               $ma->itemDone($item->getType(), $ids, MassiveAction::ACTION_KO);
               break;
            }
            $field = $item->getForeignKeyField();

            $input = $ma->getInput();

            foreach ($ids as $id) {
               if ($item->getFromDB($id)) {
                  $input2 = [
                     $field              => $id,
                     'taskcategories_id' => $input['taskcategories_id'],
                     'actiontime'        => $input['actiontime'],
                     'state'             => $input['state'],
                     'content'           => $input['content']
                  ];
                  if ($task->can(-1, CREATE, $input2)) {
                     if ($task->add($input2)) {
                        $ma->itemDone($item->getType(), $id, MassiveAction::ACTION_OK);
                     } else {
                        $ma->itemDone($item->getType(), $id, MassiveAction::ACTION_KO);
                        $ma->addMessage($item->getErrorMessage(ERROR_ON_ACTION));
                     }
                  } else {
                     $ma->itemDone($item->getType(), $id, MassiveAction::ACTION_NORIGHT);
                     $ma->addMessage($item->getErrorMessage(ERROR_RIGHT));
                  }
               } else {
                  $ma->itemDone($item->getType(), $id, MassiveAction::ACTION_KO);
                  $ma->addMessage($item->getErrorMessage(ERROR_NOT_FOUND));
               }
            }
            return;
      }
      parent::processMassiveActionsForOneItemtype($ma, $item, $ids);
   }


   /**
    * @since 0.85
   **/
   function getSearchOptionsMain() {
      global $DB;

      $tab = [];

      $tab[] = [
         'id'                 => 'common',
         'name'               => __('Characteristics')
      ];

      $tab[] = [
         'id'                 => '1',
         'table'              => $this->getTable(),
         'field'              => 'name',
         'name'               => __('Title'),
         'datatype'           => 'itemlink',
         'searchtype'         => 'contains',
         'massiveaction'      => false,
         'additionalfields'   => ['id', 'content', 'status']
      ];

      $tab[] = [
         'id'                 => '21',
         'table'              => $this->getTable(),
         'field'              => 'content',
         'name'               => __('Description'),
         'massiveaction'      => false,
         'datatype'           => 'text',
         'htmltext'           => true
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
         'id'                 => '12',
         'table'              => $this->getTable(),
         'field'              => 'status',
         'name'               => __('Status'),
         'searchtype'         => 'equals',
         'datatype'           => 'specific'
      ];

      $tab[] = [
         'id'                 => '10',
         'table'              => $this->getTable(),
         'field'              => 'urgency',
         'name'               => __('Urgency'),
         'searchtype'         => 'equals',
         'datatype'           => 'specific'
      ];

      $tab[] = [
         'id'                 => '11',
         'table'              => $this->getTable(),
         'field'              => 'impact',
         'name'               => __('Impact'),
         'searchtype'         => 'equals',
         'datatype'           => 'specific'
      ];

      $tab[] = [
         'id'                 => '3',
         'table'              => $this->getTable(),
         'field'              => 'priority',
         'name'               => __('Priority'),
         'searchtype'         => 'equals',
         'datatype'           => 'specific'
      ];

      $tab[] = [
         'id'                 => '15',
         'table'              => $this->getTable(),
         'field'              => 'date',
         'name'               => __('Opening date'),
         'datatype'           => 'datetime',
         'massiveaction'      => false
      ];

      $tab[] = [
         'id'                 => '16',
         'table'              => $this->getTable(),
         'field'              => 'closedate',
         'name'               => __('Closing date'),
         'datatype'           => 'datetime',
         'massiveaction'      => false
      ];

      $tab[] = [
         'id'                 => '18',
         'table'              => $this->getTable(),
         'field'              => 'time_to_resolve',
         'name'               => __('Time to resolve'),
         'datatype'           => 'datetime',
         'maybefuture'        => true,
         'massiveaction'      => false,
         'additionalfields'   => ['status']
      ];

      $tab[] = [
         'id'                 => '151',
         'table'              => $this->getTable(),
         'field'              => 'time_to_resolve',
         'name'               => __('Time to resolve + Progress'),
         'massiveaction'      => false,
         'nosearch'           => true,
         'additionalfields'   => ['status']
      ];

      $tab[] = [
         'id'                 => '82',
         'table'              => $this->getTable(),
         'field'              => 'is_late',
         'name'               => __('Time to resolve exceeded'),
         'datatype'           => 'bool',
         'massiveaction'      => false,
         'computation'        => self::generateSLAOLAComputation('time_to_resolve')
      ];

      $tab[] = [
         'id'                 => '17',
         'table'              => $this->getTable(),
         'field'              => 'solvedate',
         'name'               => __('Resolution date'),
         'datatype'           => 'datetime',
         'massiveaction'      => false
      ];

      $tab[] = [
         'id'                 => '19',
         'table'              => $this->getTable(),
         'field'              => 'date_mod',
         'name'               => __('Last update'),
         'datatype'           => 'datetime',
         'massiveaction'      => false
      ];

      $newtab = [
         'id'                 => '7',
         'table'              => 'glpi_itilcategories',
         'field'              => 'completename',
         'name'               => __('Category'),
         'datatype'           => 'dropdown'
      ];

      if (!Session::isCron() // no filter for cron
          && Session::getCurrentInterface() == 'helpdesk') {
         $newtab['condition']         = ['is_helpdeskvisible' => 1];
      }
      $tab[] = $newtab;

      $tab[] = [
         'id'                 => '80',
         'table'              => 'glpi_entities',
         'field'              => 'completename',
         'name'               => Entity::getTypeName(1),
         'massiveaction'      => false,
         'datatype'           => 'dropdown'
      ];

      $tab[] = [
         'id'                 => '45',
         'table'              => $this->getTable(),
         'field'              => 'actiontime',
         'name'               => __('Total duration'),
         'datatype'           => 'timestamp',
         'massiveaction'      => false,
         'nosearch'           => true
      ];

      $newtab = [
         'id'                 => '64',
         'table'              => 'glpi_users',
         'field'              => 'name',
         'linkfield'          => 'users_id_lastupdater',
         'name'               => __('Last edit by'),
         'massiveaction'      => false,
         'datatype'           => 'dropdown',
         'right'              => 'all'
      ];

      // Filter search fields for helpdesk
      if (!Session::isCron() // no filter for cron
          && Session::getCurrentInterface() != 'central') {
         // last updater no search
         $newtab['nosearch'] = true;
      }
      $tab[] = $newtab;

      // add objectlock search options
      $tab = array_merge($tab, ObjectLock::rawSearchOptionsToAdd(get_class($this)));

      // For ITIL template
      $tab[] = [
         'id'                 => '142',
         'table'              => 'glpi_documents',
         'field'              => 'name',
         'name'               => Document::getTypeName(Session::getPluralNumber()),
         'forcegroupby'       => true,
         'usehaving'          => true,
         'nosearch'           => true,
         'nodisplay'          => true,
         'datatype'           => 'dropdown',
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'           => 'items_id',
            'beforejoin'         => [
               'table'              => 'glpi_documents_items',
               'joinparams'         => [
                  'jointype'           => 'itemtype_item'
               ]
            ]
         ]
      ];

      return $tab;
   }


   /**
    * @since 0.85
   **/
   function getSearchOptionsSolution() {
      $tab = [];

      $tab[] = [
         'id'                 => 'solution',
         'name'               => ITILSolution::getTypeName(1)
      ];

      $tab[] = [
         'id'                 => '23',
         'table'              => 'glpi_solutiontypes',
         'field'              => 'name',
         'name'               => SolutionType::getTypeName(1),
         'datatype'           => 'dropdown',
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => ITILSolution::getTable(),
               'joinparams'         => [
                  'jointype'           => 'itemtype_item',
               ]
            ]
         ]
      ];

      $tab[] = [
         'id'                 => '24',
         'table'              => ITILSolution::getTable(),
         'field'              => 'content',
         'name'               => ITILSolution::getTypeName(1),
         'datatype'           => 'text',
         'htmltext'           => true,
         'massiveaction'      => false,
         'forcegroupby'       => true,
         'joinparams'         => [
            'jointype'           => 'itemtype_item'
         ]
      ];

      $tab[] = [
         'id'                  => '38',
         'table'               => ITILSolution::getTable(),
         'field'               => 'status',
         'name'                => __('Any solution status'),
         'datatype'            => 'specific',
         'searchtype'          => ['equals', 'notequals'],
         'searchequalsonfield' => true,
         'massiveaction'       => false,
         'forcegroupby'        => true,
         'joinparams'          => [
            'jointype' => 'itemtype_item'
         ]
      ];

      $tab[] = [
         'id'                  => '39',
         'table'               => ITILSolution::getTable(),
         'field'               => 'status',
         'name'                => __('Last solution status'),
         'datatype'            => 'specific',
         'searchtype'          => ['equals', 'notequals'],
         'searchequalsonfield' => true,
         'massiveaction'       => false,
         'forcegroupby'        => true,
         'joinparams'          => [
            'jointype'  => 'itemtype_item',
            // Get only last created solution
            'condition' => '
               AND NEWTABLE.`id` = (
                  SELECT `id` FROM `' . ITILSolution::getTable() . '`
                  WHERE `' . ITILSolution::getTable() . '`.`items_id` = REFTABLE.`id`
                     AND `' . ITILSolution::getTable() . '`.`itemtype` = \'' . static::getType() . '\'
                  ORDER BY `' . ITILSolution::getTable() . '`.`id` DESC
                  LIMIT 1
               )'
         ]
      ];

      return $tab;
   }


   function getSearchOptionsStats() {
      $tab = [];

      $tab[] = [
         'id'                 => 'stats',
         'name'               => __('Statistics')
      ];

      $tab[] = [
         'id'                 => '154',
         'table'              => $this->getTable(),
         'field'              => 'solve_delay_stat',
         'name'               => __('Resolution time'),
         'datatype'           => 'timestamp',
         'forcegroupby'       => true,
         'massiveaction'      => false
      ];

      $tab[] = [
         'id'                 => '152',
         'table'              => $this->getTable(),
         'field'              => 'close_delay_stat',
         'name'               => __('Closing time'),
         'datatype'           => 'timestamp',
         'forcegroupby'       => true,
         'massiveaction'      => false
      ];

      $tab[] = [
         'id'                 => '153',
         'table'              => $this->getTable(),
         'field'              => 'waiting_duration',
         'name'               => __('Waiting time'),
         'datatype'           => 'timestamp',
         'forcegroupby'       => true,
         'massiveaction'      => false
      ];

      return $tab;
   }


   function getSearchOptionsActors() {
      $tab = [];

      $tab[] = [
         'id'                 => 'requester',
         'name'               => _n('Requester', 'Requesters', 1)
      ];

      $newtab = [
         'id'                 => '4', // Also in Ticket_User::post_addItem() and Log::getHistoryData()
         'table'              => 'glpi_users',
         'field'              => 'name',
         'datatype'           => 'dropdown',
         'right'              => 'all',
         'name'               => _n('Requester', 'Requesters', 1),
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => getTableForItemType($this->userlinkclass),
               'joinparams'         => [
                  'jointype'           => 'child',
                  'condition'          => 'AND NEWTABLE.`type` = '.CommonITILActor::REQUESTER
               ]
            ]
         ]
      ];

      if (!Session::isCron() // no filter for cron
          && Session::getCurrentInterface() == 'helpdesk') {
         $newtab['right']       = 'id';
      }
      $tab[] = $newtab;

      $newtab = [
         'id'                 => '71',  // Also in Group_Ticket::post_addItem() and Log::getHistoryData()
         'table'              => 'glpi_groups',
         'field'              => 'completename',
         'datatype'           => 'dropdown',
         'name'               => _n('Requester group', 'Requester groups', 1),
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'condition'          => ['is_requester' => 1],
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => getTableForItemType($this->grouplinkclass),
               'joinparams'         => [
                  'jointype'           => 'child',
                  'condition'          => 'AND NEWTABLE.`type` = '.CommonITILActor::REQUESTER
               ]
            ]
         ]
      ];

      if (!Session::isCron() // no filter for cron
          && Session::getCurrentInterface() == 'helpdesk') {
         $newtab['condition'] = array_merge(
            $newtab['condition'],
            ['id' => [$_SESSION['glpigroups']]]
         );
      }
      $tab[] = $newtab;

      $newtab = [
         'id'                 => '22',
         'table'              => 'glpi_users',
         'field'              => 'name',
         'datatype'           => 'dropdown',
         'right'              => 'all',
         'linkfield'          => 'users_id_recipient',
         'name'               => __('Writer')
      ];

      if (!Session::isCron() // no filter for cron
          && Session::getCurrentInterface() == 'helpdesk') {
         $newtab['right']       = 'id';
      }
      $tab[] = $newtab;

      $tab[] = [
         'id'                 => 'observer',
         'name'               => _n('Watcher', 'Watchers', 1)
      ];

      $tab[] = [
         'id'                 => '66', // Also in Ticket_User::post_addItem() and Log::getHistoryData()
         'table'              => 'glpi_users',
         'field'              => 'name',
         'datatype'           => 'dropdown',
         'right'              => 'all',
         'name'               => _n('Watcher', 'Watchers', 1),
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => getTableForItemType($this->userlinkclass),
               'joinparams'         => [
                  'jointype'           => 'child',
                  'condition'          => 'AND NEWTABLE.`type` = '.CommonITILActor::OBSERVER
               ]
            ]
         ]
      ];

      $tab[] = [
         'id'                 => '65', // Also in Group_Ticket::post_addItem() and Log::getHistoryData()
         'table'              => 'glpi_groups',
         'field'              => 'completename',
         'datatype'           => 'dropdown',
         'name'               => _n('Watcher group', 'Watcher groups', 1),
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'condition'          => ['is_watcher' => 1],
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => getTableForItemType($this->grouplinkclass),
               'joinparams'         => [
                  'jointype'           => 'child',
                  'condition'          => 'AND NEWTABLE.`type` = '.CommonITILActor::OBSERVER
               ]
            ]
         ]
      ];

      $tab[] = [
         'id'                 => 'assign',
         'name'               => __('Assigned to')
      ];

      $tab[] = [
         'id'                 => '5', // Also in Ticket_User::post_addItem() and Log::getHistoryData()
         'table'              => 'glpi_users',
         'field'              => 'name',
         'datatype'           => 'dropdown',
         'right'              => 'own_ticket',
         'name'               => __('Technician'),
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => getTableForItemType($this->userlinkclass),
               'joinparams'         => [
                  'jointype'           => 'child',
                  'condition'          => 'AND NEWTABLE.`type` = '.CommonITILActor::ASSIGN
               ]
            ]
         ]
      ];

      $tab[] = [
         'id'                 => '6', // Also in Supplier_Ticket::post_addItem() and Log::getHistoryData()
         'table'              => 'glpi_suppliers',
         'field'              => 'name',
         'datatype'           => 'dropdown',
         'name'               => __('Assigned to a supplier'),
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => getTableForItemType($this->supplierlinkclass),
               'joinparams'         => [
                  'jointype'           => 'child',
                  'condition'          => 'AND NEWTABLE.`type` = '.CommonITILActor::ASSIGN
               ]
            ]
         ]
      ];

      $tab[] = [
         'id'                 => '8', // Also in Group_Ticket::post_addItem() and Log::getHistoryData()
         'table'              => 'glpi_groups',
         'field'              => 'completename',
         'datatype'           => 'dropdown',
         'name'               => __('Technician group'),
         'forcegroupby'       => true,
         'massiveaction'      => false,
         'condition'          => ['is_assign' => 1],
         'joinparams'         => [
            'beforejoin'         => [
               'table'              => getTableForItemType($this->grouplinkclass),
               'joinparams'         => [
                  'jointype'           => 'child',
                  'condition'          => 'AND NEWTABLE.`type` = '.CommonITILActor::ASSIGN
               ]
            ]
         ]
      ];

      $tab[] = [
         'id'                 => 'notification',
         'name'               => _n('Notification', 'Notifications', Session::getPluralNumber())
      ];

      $tab[] = [
         'id'                 => '35',
         'table'              => getTableForItemType($this->userlinkclass),
         'field'              => 'use_notification',
         'name'               => __('Email followup'),
         'datatype'           => 'bool',
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'           => 'child',
            'condition'          => 'AND NEWTABLE.`type` = '.CommonITILActor::REQUESTER
         ]
      ];

      $tab[] = [
         'id'                 => '34',
         'table'              => getTableForItemType($this->userlinkclass),
         'field'              => 'alternative_email',
         'name'               => __('Email for followup'),
         'datatype'           => 'email',
         'massiveaction'      => false,
         'joinparams'         => [
            'jointype'           => 'child',
            'condition'          => 'AND NEWTABLE.`type` = '.CommonITILActor::REQUESTER
         ]
      ];

      return $tab;
   }

   static function generateSLAOLAComputation($type, $table = "TABLE") {
      global $DB;

      switch ($type) {
         case 'internal_time_to_own':
         case 'time_to_own':
            return 'IF('.$DB->quoteName($table.'.'.$type).' IS NOT NULL
            AND '.$DB->quoteName($table.'.status').' <> '.self::WAITING.'
            AND ('.$DB->quoteName($table.'.takeintoaccount_delay_stat').'
                        > TIME_TO_SEC(TIMEDIFF('.$DB->quoteName($table.'.'.$type).',
                                               '.$DB->quoteName($table.'.date').'))
                 OR ('.$DB->quoteName($table.'.takeintoaccount_delay_stat').' = 0
                      AND '.$DB->quoteName($table.'.'.$type).' < NOW())),
            1, 0)';
            break;

         case 'internal_time_to_resolve':
         case 'time_to_resolve':
            return 'IF(' . $DB->quoteName($table.'.'.$type) . ' IS NOT NULL
            AND ' . $DB->quoteName($table.'.status') . ' <> 4
            AND (' . $DB->quoteName($table.'.solvedate') . ' > ' . $DB->quoteName($table.'.'.$type) . '
                  OR (' . $DB->quoteName($table.'.solvedate') . ' IS NULL
                     AND ' . $DB->quoteName($table.'.'.$type) . ' < NOW())),
            1, 0)';
            break;
      }
   }

   /**
    * Get status icon
    *
    * @since 9.3
    *
    * @return string
    */
   public static function getStatusIcon($status) {
      $class = static::getStatusClass($status);
      $label = static::getStatus($status);
      return "<i class='$class' title='$label'></i>";
   }

   /**
    * Get status class
    *
    * @since 9.3
    *
    * @return string
    */
   public static function getStatusClass($status) {
      $class = null;
      $solid = true;

      switch ($status) {
         case self::INCOMING :
            $class = 'circle';
            break;
         case self::ASSIGNED :
            $class = 'circle';
            $solid = false;
            break;
         case self::PLANNED :
            $class = 'calendar';
            break;
         case self::WAITING :
            $class = 'circle';
            break;
         case self::SOLVED :
            $class = 'circle';
            $solid = false;
            break;
         case self::CLOSED :
            $class = 'circle';
            break;
         case self::ACCEPTED :
            $class = 'check-circle';
            break;
         case self::OBSERVED :
            $class = 'eye';
            break;
         case self::EVALUATION :
            $class = 'circle';
            $solid = false;
            break;
         case self::APPROVAL :
            $class = 'question-circle';
            break;
         case self::TEST :
            $class = 'question-circle';
            break;
         case self::QUALIFICATION :
            $class = 'circle';
            $solid = false;
            break;
      }

      return $class == null
         ? ''
         : 'itilstatus ' . ($solid ? 'fas fa-' : 'far fa-') . $class.
         " ".static::getStatusKey($status);
   }

   /**
    * Get status key
    *
    * @since 9.3
    *
    * @return string
    */
   public static function getStatusKey($status) {
      $key = '';
      switch ($status) {
         case self::INCOMING :
            $key = 'new';
            break;
         case self::ASSIGNED :
            $key = 'assigned';
            break;
         case self::PLANNED :
            $key = 'planned';
            break;
         case self::WAITING :
            $key = 'waiting';
            break;
         case self::SOLVED :
            $key = 'solved';
            break;
         case self::CLOSED :
            $key = 'closed';
            break;
         case self::ACCEPTED :
            $key = 'accepted';
            break;
         case self::OBSERVED :
            $key = 'observe';
            break;
         case self::EVALUATION :
            $key = 'eval';
            break;
         case self::APPROVAL :
            $key = 'approval';
            break;
         case self::TEST :
            $key = 'test';
            break;
         case self::QUALIFICATION :
            $key = 'qualif';
            break;
      }
      return $key;
   }


   /**
    * Get Icon for Actor
    *
    * @param $user_group   string   'user or 'group'
    * @param $type         integer  user/group type
    *
    * @return string
   **/
   static function getActorIcon($user_group, $type) {
      global $CFG_GLPI;

      switch ($user_group) {
         case 'user' :
            $icontitle = addslashes(User::getTypeName(1)).' - '.$type; // should never be used
            switch ($type) {
               case CommonITILActor::REQUESTER :
                  $icontitle = __s('Requester user');
                  break;

               case CommonITILActor::OBSERVER :
                  $icontitle = __s('Watcher user');
                  break;

               case CommonITILActor::ASSIGN :
                  $icontitle = __s('Technician');
                  break;
            }
            return "<i class='fas fa-user' title='$icontitle'></i><span class='sr-only'>$icontitle</span>";

         case 'group' :
            $icontitle = Group::getTypeName(1);
            switch ($type) {
               case CommonITILActor::REQUESTER :
                  $icontitle = _sn('Requester group', 'Requester groups', 1);
                  break;

               case CommonITILActor::OBSERVER :
                  $icontitle = _sn('Watcher group', 'Watcher groups', 1);
                  break;

               case CommonITILActor::ASSIGN :
                  $icontitle = __s('Group in charge of the ticket');
                  break;
            }

            return "<i class='fas fa-users' title='$icontitle'></i>" .
                "<span class='sr-only'>$icontitle</span>";

         case 'supplier' :
            $icontitle = Supplier::getTypeName(1);
            return "<i class='fas fa-dolly' alt=\"$icontitle\" title=\"$icontitle\"></i>";

      }
      return '';

   }


   /**
    * show tooltip for user notification information
    *
    * @param $type      integer  user type
    * @param $canedit   boolean  can edit ?
    * @param $options   array    options for default values ($options of showForm)
    *
    * @return void
   **/
   function showUsersAssociated($type, $canedit, array $options = []) {
      global $CFG_GLPI;

      $showuserlink = 0;
      if (User::canView()) {
         $showuserlink = 2;
      }
      $usericon  = static::getActorIcon('user', $type);
      $user      = new User();
      $linkuser  = new $this->userlinkclass();

      $typename  = static::getActorFieldNameType($type);

      $candelete = true;
      $mandatory = '';
      // For ticket templates : mandatories
      $key = $this->getTemplateFormFieldName();
      if (isset($options[$key])) {
         $mandatory = $options[$key]->getMandatoryMark("_users_id_".$typename);
         if ($options[$key]->isMandatoryField("_users_id_".$typename)
             && isset($this->users[$type]) && (count($this->users[$type])==1)) {
            $candelete = false;
         }
      }

      if (isset($this->users[$type]) && count($this->users[$type])) {
         foreach ($this->users[$type] as $d) {
            echo "<div class='actor_row'>";
            $k = $d['users_id'];

            echo "$mandatory$usericon&nbsp;";

            if ($k) {
               $userdata = getUserName($k, 2);
            } else {
               $email         = $d['alternative_email'];
               $userdata      = "<a href='mailto:$email'>$email</a>";
            }

            $entity = $this->getEntityID();
            if (Entity::getUsedConfig('anonymize_support_agents', $entity)
               && Session::getCurrentInterface() == 'helpdesk'
               && $type == CommonITILActor::ASSIGN
            ) {
               echo __("Helpdesk");
            } else {
               if ($k) {
                  $param = ['display' => false];
                  if ($showuserlink) {
                     $param['link'] = $userdata["link"];
                  }
                  echo $userdata['name']."&nbsp;".Html::showToolTip($userdata["comment"], $param);
               } else {
                  echo $userdata;
               }
            }

            if ($CFG_GLPI['notifications_mailing']) {
               $text = __('Email followup')."&nbsp;".Dropdown::getYesNo($d['use_notification']).
                       '<br>';

               if ($d['use_notification']) {
                  $uemail = $d['alternative_email'];
                  if (empty($uemail) && $user->getFromDB($d['users_id'])) {
                     $uemail = $user->getDefaultEmail();
                  }
                  $text .= sprintf(__('%1$s: %2$s'), _n('Email', 'Emails', 1), $uemail);
                  if (!NotificationMailing::isUserAddressValid($uemail)) {
                     $text .= "&nbsp;<span class='red'>".__('Invalid email address')."</span>";
                  }
               }

               if ($canedit
                   || ($d['users_id'] == Session::getLoginUserID())) {
                  $opt      = ['awesome-class' => 'fa-envelope',
                                    'popup' => $linkuser->getFormURLWithID($d['id'])];
                  echo "&nbsp;";
                  Html::showToolTip($text, $opt);
               }
            }

            if ($canedit && $candelete) {
               Html::showSimpleForm($linkuser->getFormURL(), 'delete',
                                    _x('button', 'Delete permanently'),
                                    ['id' => $d['id']],
                                    'fa-times-circle');
            }
            echo "</div>";
         }
      }
   }


   /**
    * show actor add div
    *
    * @param $type         string   actor type
    * @param $rand_type    integer  rand value of div to use
    * @param $entities_id  integer  entity ID
    * @param $is_hidden    array    of hidden fields (if empty consider as not hidden)
    * @param $withgroup    boolean  allow adding a group (true by default)
    * @param $withsupplier boolean  allow adding a supplier (only one possible in ASSIGN case)
    *                               (false by default)
    * @param $inobject     boolean  display in ITIL object ? (true by default)
    *
    * @return void|boolean Nothing if displayed, false if not applicable
   **/
   function showActorAddForm($type, $rand_type, $entities_id, $is_hidden = [],
                             $withgroup = true, $withsupplier = false, $inobject = true) {
      global $CFG_GLPI;

      $types = ['user'  => User::getTypeName(1)];

      if ($withgroup) {
         $types['group'] = Group::getTypeName(1);
      }

      if ($withsupplier
          && ($type == CommonITILActor::ASSIGN)) {
         $types['supplier'] = Supplier::getTypeName(1);
      }

      $typename = static::getActorFieldNameType($type);
      switch ($type) {
         case CommonITILActor::REQUESTER :
            if (isset($is_hidden['_users_id_requester']) && $is_hidden['_users_id_requester']) {
               unset($types['user']);
            }
            if (isset($is_hidden['_groups_id_requester']) && $is_hidden['_groups_id_requester']) {
               unset($types['group']);
            }
            break;

         case CommonITILActor::OBSERVER :
            if (isset($is_hidden['_users_id_observer']) && $is_hidden['_users_id_observer']) {
               unset($types['user']);
            }
            if (isset($is_hidden['_groups_id_observer']) && $is_hidden['_groups_id_observer']) {
               unset($types['group']);
            }
            break;

         case CommonITILActor::ASSIGN :
            if (isset($is_hidden['_users_id_assign']) && $is_hidden['_users_id_assign']) {
               unset($types['user']);
            }
            if (isset($is_hidden['_groups_id_assign']) && $is_hidden['_groups_id_assign']) {
               unset($types['group']);
            }
            if (isset($types['supplier'])
               && isset($is_hidden['_suppliers_id_assign']) && $is_hidden['_suppliers_id_assign']) {
               unset($types['supplier']);
            }
            break;

         default :
            return false;
      }

      echo "<div ".($inobject?"style='display:none'":'')." id='itilactor$rand_type' class='actor-dropdown'>";
      $rand   = Dropdown::showFromArray("_itil_".$typename."[_type]", $types,
                                        ['display_emptychoice' => true]);
      $params = ['type'            => '__VALUE__',
                      'actortype'       => $typename,
                      'itemtype'        => $this->getType(),
                      'allow_email'     => (($type == CommonITILActor::OBSERVER)
                                            || $type == CommonITILActor::REQUESTER),
                      'entity_restrict' => $entities_id,
                      'use_notif'       => Entity::getUsedConfig('is_notif_enable_default', $entities_id, '', 1)];

      Ajax::updateItemOnSelectEvent("dropdown__itil_".$typename."[_type]$rand",
                                    "showitilactor".$typename."_$rand",
                                    $CFG_GLPI["root_doc"]."/ajax/dropdownItilActors.php",
                                    $params);
      echo "<span id='showitilactor".$typename."_$rand' class='actor-dropdown'>&nbsp;</span>";
      if ($inobject) {
         echo "<hr>";
      }
      echo "</div>";
   }


   /**
    * show user add div on creation
    *
    * @param $type      integer  actor type
    * @param $options   array    options for default values ($options of showForm)
    *
    * @return integer Random part of inputs ids
   **/
   function showActorAddFormOnCreate($type, array $options) {
      global $CFG_GLPI;

      $typename = static::getActorFieldNameType($type);

      $itemtype = $this->getType();

      echo static::getActorIcon('user', $type);
      // For ticket templates : mandatories
      $key = $this->getTemplateFormFieldName();
      if (isset($options[$key])) {
         echo $options[$key]->getMandatoryMark("_users_id_".$typename);
      }
      echo "&nbsp;";

      if (!isset($options["_right"])) {
         $right = $this->getDefaultActorRightSearch($type);
      } else {
         $right = $options["_right"];
      }

      if ($options["_users_id_".$typename] == 0 && !isset($_REQUEST["_users_id_$typename"]) && !isset($this->input["_users_id_$typename"])) {
         $options["_users_id_".$typename] = $this->getDefaultActor($type);
      }
      $rand   = mt_rand();
      $actor_name = '_users_id_'.$typename;
      if ($type == CommonITILActor::OBSERVER) {
         $actor_name = '_users_id_'.$typename.'[]';
      }
      $params = ['name'        => $actor_name,
                      'value'       => $options["_users_id_".$typename],
                      'right'       => $right,
                      'rand'        => $rand,
                      'entity'      => (isset($options['entities_id'])
                                        ? $options['entities_id']: $options['entity_restrict'])];

      //only for active ldap and corresponding right
      $ldap_methods = getAllDataFromTable('glpi_authldaps', ['is_active' => 1]);
      if (count($ldap_methods)
            && Session::haveRight('user', User::IMPORTEXTAUTHUSERS)) {
         $params['ldap_import'] = true;
      }

      if ($this->userentity_oncreate
          && ($type == CommonITILActor::REQUESTER)) {
         $params['on_change'] = 'this.form.submit()';
         unset($params['entity']);
      }

      $params['_user_index'] = 0;
      if (isset($options['_user_index'])) {
         $params['_user_index'] = $options['_user_index'];
      }

      if ($CFG_GLPI['notifications_mailing']) {
         $paramscomment
            = ['value' => '__VALUE__',
                    'field' => "_users_id_".$typename."_notif",
                    '_user_index'
                            => $params['_user_index'],
                    'allow_email'
                            => (($type == CommonITILActor::REQUESTER)
                                || ($type == CommonITILActor::OBSERVER)),
                    'use_notification'
                            => $options["_users_id_".$typename."_notif"]['use_notification']];
         if (isset($options["_users_id_".$typename."_notif"]['alternative_email'])) {
            $paramscomment['alternative_email']
               = $options["_users_id_".$typename."_notif"]['alternative_email'];
         }
         $params['toupdate'] = ['value_fieldname'
                                                  => 'value',
                                     'to_update'  => "notif_".$typename."_$rand",
                                     'url'        => $CFG_GLPI["root_doc"]."/ajax/uemailUpdate.php",
                                     'moreparams' => $paramscomment];

      }

      if (($itemtype == 'Ticket')
          && ($type == CommonITILActor::ASSIGN)) {
         $toupdate = [];
         if (isset($params['toupdate']) && is_array($params['toupdate'])) {
            $toupdate[] = $params['toupdate'];
         }
         $toupdate[] = ['value_fieldname' => 'value',
                             'to_update'       => "countassign_$rand",
                             'url'             => $CFG_GLPI["root_doc"].
                                                      "/ajax/ticketassigninformation.php",
                             'moreparams'      => ['users_id_assign' => '__VALUE__']];
         $params['toupdate'] = $toupdate;
      }

      // List all users in the active entities
      User::dropdown($params);

      if ($itemtype == 'Ticket') {

         // display opened tickets for user
         if (($type == CommonITILActor::REQUESTER)
             && ($options["_users_id_".$typename] > 0)
             && (Session::getCurrentInterface() != "helpdesk")) {

            $options2 = [
               'criteria' => [
                  [
                     'field'      => 4, // users_id
                     'searchtype' => 'equals',
                     'value'      => $options["_users_id_".$typename],
                     'link'       => 'AND',
                  ],
                  [
                     'field'      => 12, // status
                     'searchtype' => 'equals',
                     'value'      => 'notold',
                     'link'       => 'AND',
                  ],
               ],
               'reset'    => 'reset',
            ];

            $url = $this->getSearchURL()."?".Toolbox::append_params($options2, '&amp;');

            echo "&nbsp;<a href='$url' title=\"".__s('Processing')."\">(";
            printf(__('%1$s: %2$s'), __('Processing'),
                   $this->countActiveObjectsForUser($options["_users_id_".$typename]));
            echo ")</a>";
         }

         // Display active tickets for a tech
         // Need to update information on dropdown changes
         if ($type == CommonITILActor::ASSIGN) {
            echo "<span id='countassign_$rand'>";
            echo "</span>";

            echo "<script type='text/javascript'>";
            echo "$(function() {";
            Ajax::updateItemJsCode("countassign_$rand",
                                   $CFG_GLPI["root_doc"]."/ajax/ticketassigninformation.php",
                                   ['users_id_assign' => '__VALUE__'],
                                   "dropdown__users_id_".$typename.$rand);
            echo "});</script>";
         }
      }

      if ($CFG_GLPI['notifications_mailing']) {
         echo "<div id='notif_".$typename."_$rand'>";
         echo "</div>";

         echo "<script type='text/javascript'>";
         echo "$(function() {";
         Ajax::updateItemJsCode("notif_".$typename."_$rand",
                                $CFG_GLPI["root_doc"]."/ajax/uemailUpdate.php", $paramscomment,
                                "dropdown_".$actor_name.$rand);
         echo "});</script>";
      }

      return $rand;
   }


   /**
    * show supplier add div on creation
    *
    * @param $options   array    options for default values ($options of showForm)
    *
    * @return void
    **/
   function showSupplierAddFormOnCreate(array $options) {
      global $CFG_GLPI;

      $itemtype = $this->getType();

      echo static::getActorIcon('supplier', 'assign');
      // For ticket templates : mandatories
      $key = $this->getTemplateFormFieldName();
      if (isset($options[$key])) {
         echo $options[$key]->getMandatoryMark("_suppliers_id_assign");
      }
      echo "&nbsp;";

      $rand   = mt_rand();
      $params = ['name'        => '_suppliers_id_assign',
                      'value'       => $options["_suppliers_id_assign"],
                      'rand'        => $rand];

      if ($CFG_GLPI['notifications_mailing']) {
         $paramscomment = ['value'       => '__VALUE__',
                                'field'       => "_suppliers_id_assign_notif",
                                'allow_email' => true,
                                'typefield'   => 'supplier',
                                'use_notification'
                                    => $options["_suppliers_id_assign_notif"]['use_notification']];
         if (isset($options["_suppliers_id_assign_notif"]['alternative_email'])) {
            $paramscomment['alternative_email']
            = $options["_suppliers_id_assign_notif"]['alternative_email'];
         }
         $params['toupdate'] = ['value_fieldname'
                                                  => 'value',
                                     'to_update'  => "notif_assign_$rand",
                                     'url'        => $CFG_GLPI["root_doc"]."/ajax/uemailUpdate.php",
                                     'moreparams' => $paramscomment];

      }

      if ($itemtype == 'Ticket') {
         $toupdate = [];
         if (isset($params['toupdate']) && is_array($params['toupdate'])) {
            $toupdate[] = $params['toupdate'];
         }
         $toupdate[] = ['value_fieldname' => 'value',
                             'to_update'       => "countassign_$rand",
                             'url'             => $CFG_GLPI["root_doc"].
                                                      "/ajax/ticketassigninformation.php",
                             'moreparams'      => ['suppliers_id_assign' => '__VALUE__']];
         $params['toupdate'] = $toupdate;
      }

      Supplier::dropdown($params);

      if ($itemtype == 'Ticket') {
         // Display active tickets for a tech
         // Need to update information on dropdown changes
         echo "<span id='countassign_$rand'>";
         echo "</span>";
         echo "<script type='text/javascript'>";
         echo "$(function() {";
         Ajax::updateItemJsCode("countassign_$rand",
                                $CFG_GLPI["root_doc"]."/ajax/ticketassigninformation.php",
                                ['suppliers_id_assign' => '__VALUE__'],
                                "dropdown__suppliers_id_assign".$rand);
         echo "});</script>";
      }

      if ($CFG_GLPI['notifications_mailing']) {
         echo "<div id='notif_assign_$rand'>";
         echo "</div>";

         echo "<script type='text/javascript'>";
         echo "$(function() {";
         Ajax::updateItemJsCode("notif_assign_$rand",
                                $CFG_GLPI["root_doc"]."/ajax/uemailUpdate.php", $paramscomment,
                                "dropdown__suppliers_id_assign".$rand);
         echo "});</script>";
      }
   }



   /**
    * show actor part in ITIL object form
    *
    * @param $ID        integer  ITIL object ID
    * @param $options   array    options for default values ($options of showForm)
    *
    * @return void
   **/
   function showActorsPartForm($ID, array $options) {
      global $CFG_GLPI;

      $options['_default_use_notification'] = 1;

      if (isset($options['entities_id'])) {
         $options['_default_use_notification'] = Entity::getUsedConfig('is_notif_enable_default', $options['entities_id'], '', 1);
      }

      // check is_hidden fields
      $is_hidden = [];
      foreach (['_users_id_requester', '_groups_id_requester',
                     '_users_id_observer', '_groups_id_observer',
                     '_users_id_assign', '_groups_id_assign',
                     '_suppliers_id_assign'] as $f) {
         $is_hidden[$f] = false;
         $key = $this->getTemplateFormFieldName();
         if (isset($options[$key])
             && $options[$key]->isHiddenField($f)) {
            $is_hidden[$f] = true;
         }
      }
      $can_admin = $this->canAdminActors();
      // on creation can select actor
      if (!$ID) {
         $can_admin = true;
      }

      $can_assign     = $this->canAssign();
      $can_assigntome = $this->canAssignToMe();

      if (isset($options['_noupdate']) && !$options['_noupdate']) {
         $can_admin       = false;
         $can_assign      = false;
         $can_assigntome  = false;
      }

      // Manage actors
      echo "<div class='tab_actors tab_cadre_fixe' id='mainformtable5'>";
      echo "<div class='responsive_hidden actor_title'>".__('Actor')."</div>";

      // ====== Requesters BLOC ======
      //
      //
      echo "<span class='actor-bloc'>";
      echo "<div class='actor-head'>";
      if (!$is_hidden['_users_id_requester'] || !$is_hidden['_groups_id_requester']) {
         echo _n('Requester', 'Requesters', 1);
      }
      $rand_requester      = -1;
      $candeleterequester  = false;

      if ($ID
          && $can_admin
          && (!$is_hidden['_users_id_requester'] || !$is_hidden['_groups_id_requester'])
          && !in_array($this->fields['status'], $this->getClosedStatusArray())
      ) {
         $rand_requester = mt_rand();
         echo "&nbsp;";
         echo "<span class='fa fa-plus pointer' title=\"".__s('Add')."\"
                onClick=\"".Html::jsShow("itilactor$rand_requester")."\"
                ><span class='sr-only'>" . __s('Add') . "</span></span>";
         $candeleterequester = true;
      }
      echo "</div>"; // end .actor-head

      echo "<div class='actor-content'>";
      if ($rand_requester >= 0) {
         $this->showActorAddForm(CommonITILActor::REQUESTER, $rand_requester,
                                 $this->fields['entities_id'], $is_hidden);
      }

      // Requester
      if (!$ID) {
         $reqdisplay = false;
         if ($can_admin
             && !$is_hidden['_users_id_requester']) {
            $this->showActorAddFormOnCreate(CommonITILActor::REQUESTER, $options);
            $reqdisplay = true;
         } else {
            $delegating = User::getDelegateGroupsForUser($options['entities_id']);
            if (count($delegating)
                && !$is_hidden['_users_id_requester']) {
               //$this->getDefaultActor(CommonITILActor::REQUESTER);
               $options['_right'] = "delegate";
               $this->showActorAddFormOnCreate(CommonITILActor::REQUESTER, $options);
               $reqdisplay = true;
            } else { // predefined value
               if (isset($options["_users_id_requester"]) && $options["_users_id_requester"]) {
                  echo static::getActorIcon('user', CommonITILActor::REQUESTER)."&nbsp;";
                  echo Dropdown::getDropdownName("glpi_users", $options["_users_id_requester"]);
                  echo "<input type='hidden' name='_users_id_requester' value=\"".
                         $options["_users_id_requester"]."\">";
                  echo '<br>';
                  $reqdisplay=true;
               }
            }
         }

         //If user have access to more than one entity, then display a combobox : Ticket case
         if ($this->userentity_oncreate
             && isset($this->countentitiesforuser)
             && ($this->countentitiesforuser > 1)) {
            echo "<br>";
            $rand = Entity::dropdown(['value'     => $this->fields["entities_id"],
                                           'entity'    => $this->userentities,
                                           'on_change' => 'this.form.submit()']);
         } else {
            echo "<input type='hidden' name='entities_id' value='".$this->fields["entities_id"]."'>";
         }
         if ($reqdisplay) {
            echo '<hr>';
         }

      } else if (!$is_hidden['_users_id_requester']) {
         $this->showUsersAssociated(CommonITILActor::REQUESTER, $candeleterequester, $options);
      }

      // Requester Group
      if (!$ID) {
         if ($can_admin
             && !$is_hidden['_groups_id_requester']) {
            echo static::getActorIcon('group', CommonITILActor::REQUESTER);
            /// For ticket templates : mandatories
            $key = $this->getTemplateFormFieldName();
            if (isset($options[$key])) {
               echo $options[$key]->getMandatoryMark('_groups_id_requester');
            }
            echo "&nbsp;";

            Group::dropdown([
               'name'      => '_groups_id_requester',
               'value'     => $options["_groups_id_requester"],
               'entity'    => $this->fields["entities_id"],
               'condition' => ['is_requester' => 1]
            ]);

         } else { // predefined value
            if (isset($options["_groups_id_requester"]) && $options["_groups_id_requester"]) {
               echo static::getActorIcon('group', CommonITILActor::REQUESTER)."&nbsp;";
               echo Dropdown::getDropdownName("glpi_groups", $options["_groups_id_requester"]);
               echo "<input type='hidden' name='_groups_id_requester' value=\"".
                      $options["_groups_id_requester"]."\">";
               echo '<br>';
            }
         }
      } else if (!$is_hidden['_groups_id_requester']) {
         $this->showGroupsAssociated(CommonITILActor::REQUESTER, $candeleterequester, $options);
      }
      echo "</div>"; // end .actor-content
      echo "</span>"; // end .actor-bloc

      // ====== Observers BLOC ======

      echo "<span class='actor-bloc'>";
      echo "<div class='actor-head'>";
      if (!$is_hidden['_users_id_observer'] || !$is_hidden['_groups_id_observer']) {
         echo _n('Watcher', 'Watchers', 1);
      }
      $rand_observer       = -1;
      $candeleteobserver   = false;

      if ($ID
          && $can_admin
          && (!$is_hidden['_users_id_observer'] || !$is_hidden['_groups_id_observer'])
          && !in_array($this->fields['status'], $this->getClosedStatusArray())
      ) {
         $rand_observer = mt_rand();

         echo "&nbsp;";
         echo "<span class='fa fa-plus pointer' title=\"".__s('Add')."\"
                onClick=\"".Html::jsShow("itilactor$rand_observer")."\"
                ><span class='sr-only'>" . __s('Add') . "</span></span>";
         $candeleteobserver = true;

      }
      if (($ID > 0)
           && !in_array($this->fields['status'], $this->getClosedStatusArray())
           && !$is_hidden['_users_id_observer']
           && !$this->isUser(CommonITILActor::OBSERVER, Session::getLoginUserID())
           && !$this->isUser(CommonITILActor::REQUESTER, Session::getLoginUserID())) {
         Html::showSimpleForm($this->getFormURL(), 'addme_observer',
                              __('Associate myself'),
                              [$this->getForeignKeyField() => $this->fields['id']],
                              'fa-male');
      }

      echo "</div>"; // end .actor-head
      echo "<div class='actor-content'>";
      if ($rand_observer >= 0) {
         $this->showActorAddForm(CommonITILActor::OBSERVER, $rand_observer,
                                 $this->fields['entities_id'], $is_hidden);
      }

      // Observer
      if (!$ID) {
         if ($can_admin
             && !$is_hidden['_users_id_observer']) {
            $this->showActorAddFormOnCreate(CommonITILActor::OBSERVER, $options);
            echo '<hr>';
         } else { // predefined value
            if (!is_array($options['_users_id_observer'])) {
               $options['_users_id_observer'] = [$options['_users_id_observer']];
            }
            if (isset($options["_users_id_observer"][0]) && $options["_users_id_observer"][0]) {
               echo static::getActorIcon('user', CommonITILActor::OBSERVER)."&nbsp;";
               echo Dropdown::getDropdownName("glpi_users", $options["_users_id_observer"][0]);
               echo "<input type='hidden' name='_users_id_observer' value=\"".
                      $options["_users_id_observer"][0]."\">";
               echo '<hr>';
            }
         }
      } else if (!$is_hidden['_users_id_observer']) {
         $this->showUsersAssociated(CommonITILActor::OBSERVER, $candeleteobserver, $options);
      }

      // Observer Group
      if (!$ID) {
         if ($can_admin
             && !$is_hidden['_groups_id_observer']) {
            echo static::getActorIcon('group', CommonITILActor::OBSERVER);
            /// For ticket templates : mandatories
            $key = $this->getTemplateFormFieldName();
            if (isset($options[$key])) {
               echo $options[$key]->getMandatoryMark('_groups_id_observer');
            }
            echo "&nbsp;";

            Group::dropdown([
               'name'      => '_groups_id_observer',
               'value'     => $options["_groups_id_observer"],
               'entity'    => $this->fields["entities_id"],
               'condition' => ['is_requester' => 1]
            ]);
         } else { // predefined value
            if (isset($options["_groups_id_observer"]) && $options["_groups_id_observer"]) {
               echo static::getActorIcon('group', CommonITILActor::OBSERVER)."&nbsp;";
               echo Dropdown::getDropdownName("glpi_groups", $options["_groups_id_observer"]);
               echo "<input type='hidden' name='_groups_id_observer' value=\"".
                      $options["_groups_id_observer"]."\">";
               echo '<br>';
            }
         }
      } else if (!$is_hidden['_groups_id_observer']) {
         $this->showGroupsAssociated(CommonITILActor::OBSERVER, $candeleteobserver, $options);
      }
      echo "</div>"; // end .actor-content
      echo "</span>"; // end .actor-bloc

      // ====== Assign BLOC ======

      echo "<span class='actor-bloc'>";
      echo "<div class='actor-head'>";
      if (!$is_hidden['_users_id_assign']
          || !$is_hidden['_groups_id_assign']
          || !$is_hidden['_suppliers_id_assign']) {
         echo __('Assigned to');
      }
      $rand_assign      = -1;
      $candeleteassign  = false;
      if ($ID
          && ($can_assign || $can_assigntome)
          && (!$is_hidden['_users_id_assign']
              || !$is_hidden['_groups_id_assign']
              || !$is_hidden['_suppliers_id_assign'])
          && $this->isAllowedStatus($this->fields['status'], CommonITILObject::ASSIGNED)) {
         $rand_assign = mt_rand();

         echo "&nbsp;";
         echo "<span class='fa fa-plus pointer' title=\"".__s('Add')."\"
                onClick=\"".Html::jsShow("itilactor$rand_assign")."\"
                ><span class='sr-only'>" . __s('Add') . "</span></span>";
      }
      if ($ID
          && $can_assigntome
          && !in_array($this->fields['status'], $this->getClosedStatusArray())
          && !$is_hidden['_users_id_assign']
          && !$this->isUser(CommonITILActor::ASSIGN, Session::getLoginUserID())
          && $this->isAllowedStatus($this->fields['status'], CommonITILObject::ASSIGNED)) {
         Html::showSimpleForm($this->getFormURL(), 'addme_assign', __('Associate myself'),
                              [$this->getForeignKeyField() => $this->fields['id']],
                              'fa-male');
      }
      if ($ID
          && $can_assign) {
         $candeleteassign = true;
      }
      echo "</div>"; // end .actor-head

      echo "<div class='actor-content'>";
      if ($rand_assign >= 0) {
         $this->showActorAddForm(CommonITILActor::ASSIGN, $rand_assign, $this->fields['entities_id'],
                                 $is_hidden, $this->canAssign(), $this->canAssign());
      }

      // Assign User
      if (!$ID) {
         if ($can_assign
             && !$is_hidden['_users_id_assign']
             && $this->isAllowedStatus(CommonITILObject::INCOMING, CommonITILObject::ASSIGNED)) {
            $this->showActorAddFormOnCreate(CommonITILActor::ASSIGN, $options);
            echo '<hr>';

         } else if ($can_assigntome
                    && !$is_hidden['_users_id_assign']
                    && $this->isAllowedStatus(CommonITILObject::INCOMING, CommonITILObject::ASSIGNED)) {
            echo static::getActorIcon('user', CommonITILActor::ASSIGN)."&nbsp;";
            User::dropdown(['name'        => '_users_id_assign',
                                 'value'       => $options["_users_id_assign"],
                                 'entity'      => $this->fields["entities_id"],
                                 'ldap_import' => true]);
            echo '<hr>';

         } else { // predefined value
            if (isset($options["_users_id_assign"]) && $options["_users_id_assign"]
                && $this->isAllowedStatus(CommonITILObject::INCOMING, CommonITILObject::ASSIGNED)) {
               echo static::getActorIcon('user', CommonITILActor::ASSIGN)."&nbsp;";
               echo Dropdown::getDropdownName("glpi_users", $options["_users_id_assign"]);
               echo "<input type='hidden' name='_users_id_assign' value=\"".
                      $options["_users_id_assign"]."\">";
               echo '<hr>';
            }
         }

      } else if (!$is_hidden['_users_id_assign']) {
         $this->showUsersAssociated(CommonITILActor::ASSIGN, $candeleteassign, $options);
      }

      // Assign Groups
      if (!$ID) {
         if ($can_assign
             && !$is_hidden['_groups_id_assign']
             && $this->isAllowedStatus(CommonITILObject::INCOMING, CommonITILObject::ASSIGNED)) {
            echo static::getActorIcon('group', CommonITILActor::ASSIGN);
            /// For ticket templates : mandatories
            $key = $this->getTemplateFormFieldName();
            if (isset($options[$key])) {
               echo $options[$key]->getMandatoryMark('_groups_id_assign');
            }
            echo "&nbsp;";
            $rand   = mt_rand();
            $params = [
               'name'      => '_groups_id_assign',
               'value'     => $options["_groups_id_assign"],
               'entity'    => $this->fields["entities_id"],
               'condition' => ['is_assign' => 1],
               'rand'      => $rand
            ];

            if ($this->getType() == 'Ticket') {
               $params['toupdate'] = ['value_fieldname' => 'value',
                                           'to_update'       => "countgroupassign_$rand",
                                           'url'             => $CFG_GLPI["root_doc"].
                                                                "/ajax/ticketassigninformation.php",
                                           'moreparams'      => ['groups_id_assign'
                                                                        => '__VALUE__']];
            }

            Group::dropdown($params);
            echo "<span id='countgroupassign_$rand'>";
            echo "</span>";

            echo "<script type='text/javascript'>";
            echo "$(function() {";
            Ajax::updateItemJsCode("countgroupassign_$rand",
                                   $CFG_GLPI["root_doc"]."/ajax/ticketassigninformation.php",
                                   ['groups_id_assign' => '__VALUE__'],
                                   "dropdown__groups_id_assign$rand");
            echo "});</script>";

            echo '<hr>';
         } else { // predefined value
            if (isset($options["_groups_id_assign"])
                && $options["_groups_id_assign"]
                && $this->isAllowedStatus(CommonITILObject::INCOMING, CommonITILObject::ASSIGNED)) {
               echo static::getActorIcon('group', CommonITILActor::ASSIGN)."&nbsp;";
               echo Dropdown::getDropdownName("glpi_groups", $options["_groups_id_assign"]);
               echo "<input type='hidden' name='_groups_id_assign' value=\"".
                      $options["_groups_id_assign"]."\">";
               echo '<hr>';
            }
         }

      } else if (!$is_hidden['_groups_id_assign']) {
         $this->showGroupsAssociated(CommonITILActor::ASSIGN, $candeleteassign, $options);
      }

      // Assign Suppliers
      if (!$ID) {
         if ($can_assign
             && !$is_hidden['_suppliers_id_assign']
             && $this->isAllowedStatus(CommonITILObject::INCOMING, CommonITILObject::ASSIGNED)) {
            $this->showSupplierAddFormOnCreate($options);
         } else { // predefined value
            if (isset($options["_suppliers_id_assign"])
                && $options["_suppliers_id_assign"]
                && $this->isAllowedStatus(CommonITILObject::INCOMING, CommonITILObject::ASSIGNED)) {
               echo static::getActorIcon('supplier', CommonITILActor::ASSIGN)."&nbsp;";
               echo Dropdown::getDropdownName("glpi_suppliers", $options["_suppliers_id_assign"]);
               echo "<input type='hidden' name='_suppliers_id_assign' value=\"".
                      $options["_suppliers_id_assign"]."\">";
               echo '<hr>';
            }
         }

      } else if (!$is_hidden['_suppliers_id_assign']) {
         $this->showSuppliersAssociated(CommonITILActor::ASSIGN, $candeleteassign, $options);
      }

      echo "</div>"; // end .actor-content
      echo "</span>"; // end .actor-bloc

      echo "</div>"; // tab_actors
   }


   /**
    * @param $actiontime
   **/
   static function getActionTime($actiontime) {
      return Html::timestampToString($actiontime, false);
   }


   /**
    * @param $ID
    * @param $itemtype
    * @param $link      (default 0)
   **/
   static function getAssignName($ID, $itemtype, $link = 0) {

      switch ($itemtype) {
         case 'User' :
            if ($ID == 0) {
               return "";
            }
            return getUserName($ID, $link);

         case 'Supplier' :
         case 'Group' :
            $item = new $itemtype();
            if ($item->getFromDB($ID)) {
               if ($link) {
                  return $item->getLink(['comments' => true]);
               }
               return $item->getNameID();
            }
            return "";
      }
   }

   /**
    * Form to add a solution to an ITIL object
    *
    * @since 0.84
    * @since 9.2 Signature has changed
    *
    * @param CommonITILObject $item item instance
    *
    * @param $entities_id
   **/
   static function showMassiveSolutionForm(CommonITILObject $item) {
      echo "<table class='tab_cadre_fixe'>";
      echo '<tr><th colspan=4>'.__('Solve tickets').'</th></tr>';

      $solution = new ITILSolution();
      $solution->showForm(
         null,
         [
            'item'   => $item,
            'entity' => $item->getEntityID(),
            'noform' => true,
            'nokb'   => true
         ]
      );

      echo "</td></tr>";
      echo '</table>';
   }


   /**
    * Update date mod of the ITIL object
    *
    * @param $ID                    integer  ID of the ITIL object
    * @param $no_stat_computation   boolean  do not cumpute take into account stat (false by default)
    * @param $users_id_lastupdater  integer  to force last_update id (default 0 = not used)
   **/
   function updateDateMod($ID, $no_stat_computation = false, $users_id_lastupdater = 0) {
      global $DB;

      if ($this->getFromDB($ID)) {
         // Force date mod and lastupdater
         $update = ['date_mod' => $_SESSION['glpi_currenttime']];

         // set last updater if interactive user
         if (!Session::isCron()) {
            $update['users_id_lastupdater'] = Session::getLoginUserID();
         } else if ($users_id_lastupdater > 0) {
            $update['users_id_lastupdater'] = $users_id_lastupdater;
         }

         $DB->update(
            $this->getTable(),
            $update,
            ['id' => $ID]
         );
      }
   }


   /**
    * Update actiontime of the object based on actiontime of the tasks
    *
    * @param integer $ID ID of the object
    *
    * @return boolean : success
   **/
   function updateActionTime($ID) {
      global $DB;

      $tot       = 0;
      $tasktable = getTableForItemType($this->getType().'Task');

      $result = $DB->request([
         'SELECT' => ['SUM' => 'actiontime as sumtime'],
         'FROM'   => $tasktable,
         'WHERE'  => [$this->getForeignKeyField() => $ID]
      ])->next();
      $sum = $result['sumtime'];
      if (!is_null($sum)) {
         $tot += $sum;
      }

      $result = $DB->update(
         $this->getTable(), [
            'actiontime' => $tot
         ], [
            'id' => $ID
         ]
      );
      return $result;
   }


   /**
    * Get all available types to which an ITIL object can be assigned
   **/
   static function getAllTypesForHelpdesk() {
      global $PLUGIN_HOOKS, $CFG_GLPI;

      /// TODO ticket_types -> itil_types

      $types = [];
      $ptypes = [];
      //Types of the plugins (keep the plugin hook for right check)
      if (isset($PLUGIN_HOOKS['assign_to_ticket'])) {
         foreach (array_keys($PLUGIN_HOOKS['assign_to_ticket']) as $plugin) {
            if (!Plugin::isPluginActive($plugin)) {
               continue;
            }
            $ptypes = Plugin::doOneHook($plugin, 'AssignToTicket', $ptypes);
         }
      }
      asort($ptypes);
      //Types of the core (after the plugin for robustness)
      foreach ($CFG_GLPI["ticket_types"] as $itemtype) {
         if ($item = getItemForItemtype($itemtype)) {
            if (!isPluginItemType($itemtype) // No plugin here
                && isset($_SESSION["glpiactiveprofile"]["helpdesk_item_type"])
                  && in_array($itemtype, $_SESSION["glpiactiveprofile"]["helpdesk_item_type"])) {
               $types[$itemtype] = $item->getTypeName(1);
            }
         }
      }
      asort($types); // core type first... asort could be better ?

      // Drop not available plugins
      foreach (array_keys($ptypes) as $itemtype) {
         if (!isset($_SESSION["glpiactiveprofile"]["helpdesk_item_type"])
             || !in_array($itemtype, $_SESSION["glpiactiveprofile"]["helpdesk_item_type"])) {
            unset($ptypes[$itemtype]);
         }
      }

      $types = array_merge($types, $ptypes);
      return $types;
   }


   /**
    * Check if it's possible to assign ITIL object to a type (core or plugin)
    *
    * @param string $itemtype the object's type
    *
    * @return true if ticket can be assign to this type, false if not
   **/
   static function isPossibleToAssignType($itemtype) {

      if (in_array($itemtype, $_SESSION["glpiactiveprofile"]["helpdesk_item_type"])) {
         return true;
      }
      return false;
   }


   /**
    * Compute solve delay stat of the current ticket
   **/
   function computeSolveDelayStat() {

      if (isset($this->fields['id'])
          && !empty($this->fields['date'])
          && !empty($this->fields['solvedate'])) {

         $calendars_id = $this->getCalendar();
         $calendar     = new Calendar();

         // Using calendar
         if (($calendars_id > 0)
             && $calendar->getFromDB($calendars_id)) {
            return max(0, $calendar->getActiveTimeBetween($this->fields['date'],
                                                          $this->fields['solvedate'])
                                                            -$this->fields["waiting_duration"]);
         }
         // Not calendar defined
         return max(0, strtotime($this->fields['solvedate'])-strtotime($this->fields['date'])
                       -$this->fields["waiting_duration"]);
      }
      return 0;
   }


   /**
    * Compute close delay stat of the current ticket
   **/
   function computeCloseDelayStat() {

      if (isset($this->fields['id'])
          && !empty($this->fields['date'])
          && !empty($this->fields['closedate'])) {

         $calendars_id = $this->getCalendar();
         $calendar     = new Calendar();

         // Using calendar
         if (($calendars_id > 0)
             && $calendar->getFromDB($calendars_id)) {
            return max(0, $calendar->getActiveTimeBetween($this->fields['date'],
                                                          $this->fields['closedate'])
                                                             -$this->fields["waiting_duration"]);
         }
         // Not calendar defined
         return max(0, strtotime($this->fields['closedate'])-strtotime($this->fields['date'])
                       -$this->fields["waiting_duration"]);
      }
      return 0;
   }


   function showStats() {

      if (!$this->canView()
          || !isset($this->fields['id'])) {
         return false;
      }

      $this->showStatsDates();
      Plugin::doHook('show_item_stats', $this);
      $this->showStatsTimes();
   }

   function showStatsDates() {
      echo "<table class='tab_cadre_fixe'>";
      echo "<tr><th colspan='2'>"._n('Date', 'Dates', Session::getPluralNumber())."</th></tr>";

      echo "<tr class='tab_bg_2'><td>".__('Opening date')."</td>";
      echo "<td>".Html::convDateTime($this->fields['date'])."</td></tr>";

      echo "<tr class='tab_bg_2'><td>".__('Time to resolve')."</td>";
      echo "<td>".Html::convDateTime($this->fields['time_to_resolve'])."</td></tr>";

      if (in_array($this->fields['status'], array_merge($this->getSolvedStatusArray(),
                                                        $this->getClosedStatusArray()))) {
         echo "<tr class='tab_bg_2'><td>".__('Resolution date')."</td>";
         echo "<td>".Html::convDateTime($this->fields['solvedate'])."</td></tr>";
      }

      if (in_array($this->fields['status'], $this->getClosedStatusArray())) {
         echo "<tr class='tab_bg_2'><td>".__('Closing date')."</td>";
         echo "<td>".Html::convDateTime($this->fields['closedate'])."</td></tr>";
      }
      echo "</table>";
   }

   function showStatsTimes() {
      echo "<div class='dates_timelines'>";
      echo "<table class='tab_cadre_fixe'>";
      echo "<tr><th colspan='2'>"._n('Time', 'Times', Session::getPluralNumber())."</th></tr>";

      if (isset($this->fields['takeintoaccount_delay_stat'])) {
         echo "<tr class='tab_bg_2'><td>".__('Take into account')."</td><td>";
         if ($this->fields['takeintoaccount_delay_stat'] > 0) {
            echo Html::timestampToString($this->fields['takeintoaccount_delay_stat'], 0, false);
         } else {
            echo '&nbsp;';
         }
         echo "</td></tr>";
      }

      if (in_array($this->fields['status'], array_merge($this->getSolvedStatusArray(),
                                                        $this->getClosedStatusArray()))) {
         echo "<tr class='tab_bg_2'><td>".__('Resolution')."</td><td>";

         if ($this->fields['solve_delay_stat'] > 0) {
            echo Html::timestampToString($this->fields['solve_delay_stat'], 0, false);
         } else {
            echo '&nbsp;';
         }
         echo "</td></tr>";
      }

      if (in_array($this->fields['status'], $this->getClosedStatusArray())) {
         echo "<tr class='tab_bg_2'><td>".__('Closure')."</td><td>";
         if ($this->fields['close_delay_stat'] > 0) {
            echo Html::timestampToString($this->fields['close_delay_stat'], true, false);
         } else {
            echo '&nbsp;';
         }
         echo "</td></tr>";
      }

      echo "<tr class='tab_bg_2'><td>".__('Pending')."</td><td>";
      if ($this->fields['waiting_duration'] > 0) {
         echo Html::timestampToString($this->fields['waiting_duration'], 0, false);
      } else {
         echo '&nbsp;';
      }
      echo "</td></tr>";

      echo "</table>";
      echo "</div>";
   }


   /** Get users_ids of itil object between 2 dates
    *
    * @param string $date1 begin date
    * @param string $date2 end date
    *
    * @return array contains the distinct users_ids which have itil object
   **/
   function getUsedAuthorBetween($date1 = '', $date2 = '') {
      global $DB;

      $linkclass = new $this->userlinkclass();
      $linktable = $linkclass->getTable();

      $ctable = $this->getTable();
      $criteria = [
         'SELECT'          => [
            'glpi_users.id AS users_id',
            'glpi_users.name AS name',
            'glpi_users.realname AS realname',
            'glpi_users.firstname AS firstname'
         ],
         'DISTINCT' => true,
         'FROM'            => $ctable,
         'LEFT JOIN'       => [
            $linktable  => [
               'ON' => [
                  $linktable  => $this->getForeignKeyField(),
                  $ctable     => 'id', [
                     'AND' => [
                        "$linktable.type"    => CommonITILActor::REQUESTER
                     ]
                  ]
               ]
            ]
         ],
         'INNER JOIN'      => [
            'glpi_users'   => [
               'ON' => [
                  $linktable     => 'users_id',
                  'glpi_users'   => 'id'
               ]
            ]
         ],
         'WHERE'           => [
            "$ctable.is_deleted" => 0
         ] + getEntitiesRestrictCriteria($ctable),
         'ORDERBY'         => [
            'realname',
            'firstname',
            'name'
         ]
      ];

      if (!empty($date1) || !empty($date2)) {
         $criteria['WHERE'][] = [
            'OR' => [
               getDateCriteria("$ctable.date", $date1, $date2),
               getDateCriteria("$ctable.closedate", $date1, $date2),
            ]
         ];
      }

      $iterator = $DB->request($criteria);
      $tab    = [];
      while ($line = $iterator->next()) {
         $tab[] = [
            'id'   => $line['users_id'],
            'link' => formatUserName(
               $line['users_id'],
               $line['name'],
               $line['realname'],
               $line['firstname'],
               1
            )
         ];
      }
      return $tab;
   }


   /** Get recipient of itil object between 2 dates
    *
    * @param string $date1 begin date
    * @param string $date2 end date
    *
    * @return array contains the distinct recipents which have itil object
   **/
   function getUsedRecipientBetween($date1 = '', $date2 = '') {
      global $DB;

      $ctable = $this->getTable();
      $criteria = [
         'SELECT'          => [
            'glpi_users.id AS user_id',
            'glpi_users.name AS name',
            'glpi_users.realname AS realname',
            'glpi_users.firstname AS firstname'
         ],
         'DISTINCT'        => true,
         'FROM'            => $ctable,
         'LEFT JOIN'       => [
            'glpi_users'   => [
               'ON' => [
                  $ctable        => 'users_id_recipient',
                  'glpi_users'   => 'id'
               ]
            ]
         ],
         'WHERE'           => [
            "$ctable.is_deleted" => 0
         ] + getEntitiesRestrictCriteria($ctable),
         'ORDERBY'         => [
            'realname',
            'firstname',
            'name'
         ]
      ];

      if (!empty($date1) || !empty($date2)) {
         $criteria['WHERE'][] = [
            'OR' => [
               getDateCriteria("$ctable.date", $date1, $date2),
               getDateCriteria("$ctable.closedate", $date1, $date2),
            ]
         ];
      }

      $iterator = $DB->request($criteria);
      $tab    = [];

      while ($line = $iterator->next()) {
         $tab[] = [
            'id'   => $line['user_id'],
            'link' => formatUserName(
               $line['user_id'],
               $line['name'],
               $line['realname'],
               $line['firstname'],
               1
            )
         ];
      }
      return $tab;
   }


   /** Get groups which have itil object between 2 dates
    *
    * @param string $date1 begin date
    * @param string $date2 end date
    *
    * @return array contains the distinct groups of tickets
   **/
   function getUsedGroupBetween($date1 = '', $date2 = '') {
      global $DB;

      $linkclass = new $this->grouplinkclass();
      $linktable = $linkclass->getTable();

      $ctable = $this->getTable();
      $criteria = [
         'SELECT' => [
            'glpi_groups.id',
            'glpi_groups.completename'
         ],
         'DISTINCT'        => true,
         'FROM'            => $ctable,
         'LEFT JOIN'       => [
            $linktable  => [
               'ON' => [
                  $linktable  => $this->getForeignKeyField(),
                  $ctable     => 'id', [
                     'AND' => [
                        "$linktable.type"    => CommonITILActor::REQUESTER
                     ]
                  ]
               ]
            ]
         ],
         'INNER JOIN'      => [
            'glpi_groups'   => [
               'ON' => [
                  $linktable     => 'groups_id',
                  'glpi_groups'   => 'id'
               ]
            ]
         ],
         'WHERE'           => [
            "$ctable.is_deleted" => 0
         ] + getEntitiesRestrictCriteria($ctable),
         'ORDERBY'         => [
            'glpi_groups.completename'
         ]
      ];

      if (!empty($date1) || !empty($date2)) {
         $criteria['WHERE'][] = [
            'OR' => [
               getDateCriteria("$ctable.date", $date1, $date2),
               getDateCriteria("$ctable.closedate", $date1, $date2),
            ]
         ];
      }

      $iterator = $DB->request($criteria);
      $tab    = [];

      while ($line = $iterator->next()) {
         $tab[] = [
            'id'   => $line['id'],
            'link' => $line['completename'],
         ];
      }
      return $tab;
   }


   /** Get recipient of itil object between 2 dates
    *
    * @param string  $date1 begin date
    * @param string  $date2 end date
    * @param boolean $title indicates if stat if by title (true) or type (false)
    *
    * @return array contains the distinct recipents which have tickets
   **/
   function getUsedUserTitleOrTypeBetween($date1 = '', $date2 = '', $title = true) {
      global $DB;

      $linkclass = new $this->userlinkclass();
      $linktable = $linkclass->getTable();

      if ($title) {
         $table = "glpi_usertitles";
         $field = "usertitles_id";
      } else {
         $table = "glpi_usercategories";
         $field = "usercategories_id";
      }

      $ctable = $this->getTable();
      $criteria = [
         'SELECT'          => "glpi_users.$field",
         'DISTINCT'        => true,
         'FROM'            => $ctable,
         'INNER JOIN'      => [
            $linktable  => [
               'ON' => [
                  $linktable  => $this->getForeignKeyField(),
                  $ctable     => 'id'
               ]
            ],
            'glpi_users'   => [
               'ON' => [
                  $linktable     => 'users_id',
                  'glpi_users'   => 'id'
               ]
            ]
         ],
         'LEFT JOIN'       => [
            $table         => [
               'ON' => [
                  'glpi_users'   => $field,
                  $table         => 'id'
               ]
            ]
         ],
         'WHERE'           => [
            "$ctable.is_deleted" => 0
         ] + getEntitiesRestrictCriteria($ctable),
         'ORDERBY'         => [
            "glpi_users.$field"
         ]
      ];

      if (!empty($date1) || !empty($date2)) {
         $criteria['WHERE'][] = [
            'OR' => [
               getDateCriteria("$ctable.date", $date1, $date2),
               getDateCriteria("$ctable.closedate", $date1, $date2),
            ]
         ];
      }

      $iterator = $DB->request($criteria);
      $tab    = [];
      while ($line = $iterator->next()) {
         $tab[] = [
            'id'   => $line[$field],
            'link' => Dropdown::getDropdownName($table, $line[$field]),
         ];
      }
      return $tab;
   }


   /**
    * Get priorities of itil object between 2 dates
    *
    * @param string $date1 begin date
    * @param string $date2 end date
    *
    * @return array contains the distinct priorities of tickets
   **/
   function getUsedPriorityBetween($date1 = '', $date2 = '') {
      global $DB;

      $ctable = $this->getTable();
      $criteria = [
         'SELECT'          => 'priority',
         'DISTINCT'        => true,
         'FROM'            => $ctable,
         'WHERE'           => [
            "$ctable.is_deleted" => 0
         ] + getEntitiesRestrictCriteria($ctable),
         'ORDERBY'         => 'priority'
      ];

      if (!empty($date1) || !empty($date2)) {
         $criteria['WHERE'][] = [
            'OR' => [
               getDateCriteria("$ctable.date", $date1, $date2),
               getDateCriteria("$ctable.closedate", $date1, $date2),
            ]
         ];
      }

      $iterator = $DB->request($criteria);
      $tab    = [];
      while ($line = $iterator->next()) {
         $tab[] = [
            'id'   => $line['priority'],
            'link' => static::getPriorityName($line['priority']),
         ];
      }
      return $tab;
   }


   /**
    * Get urgencies of itil object between 2 dates
    *
    * @param string $date1 begin date
    * @param string $date2 end date
    *
    * @return array contains the distinct priorities of tickets
   **/
   function getUsedUrgencyBetween($date1 = '', $date2 = '') {
      global $DB;

      $ctable = $this->getTable();
      $criteria = [
         'SELECT'          => 'urgency',
         'DISTINCT'        => true,
         'FROM'            => $ctable,
         'WHERE'           => [
            "$ctable.is_deleted" => 0
         ] + getEntitiesRestrictCriteria($ctable),
         'ORDERBY'         => 'urgency'
      ];

      if (!empty($date1) || !empty($date2)) {
         $criteria['WHERE'][] = [
            'OR' => [
               getDateCriteria("$ctable.date", $date1, $date2),
               getDateCriteria("$ctable.closedate", $date1, $date2),
            ]
         ];
      }

      $iterator = $DB->request($criteria);
      $tab    = [];

      while ($line = $iterator->next()) {
         $tab[] = [
            'id'   => $line['urgency'],
            'link' => static::getUrgencyName($line['urgency']),
         ];
      }
      return $tab;
   }


   /**
    * Get impacts of itil object between 2 dates
    *
    * @param string $date1 begin date
    * @param string $date2 end date
    *
    * @return array contains the distinct priorities of tickets
   **/
   function getUsedImpactBetween($date1 = '', $date2 = '') {
      global $DB;

      $ctable = $this->getTable();
      $criteria = [
         'SELECT'          => 'impact',
         'DISTINCT'        => true,
         'FROM'            => $ctable,
         'WHERE'           => [
            "$ctable.is_deleted" => 0
         ] + getEntitiesRestrictCriteria($ctable),
         'ORDERBY'         => 'impact'
      ];

      if (!empty($date1) || !empty($date2)) {
         $criteria['WHERE'][] = [
            'OR' => [
               getDateCriteria("$ctable.date", $date1, $date2),
               getDateCriteria("$ctable.closedate", $date1, $date2),
            ]
         ];
      }

      $iterator = $DB->request($criteria);
      $tab    = [];

      while ($line = $iterator->next()) {
         $tab[] = [
            'id'   => $line['impact'],
            'link' => static::getImpactName($line['impact']),
         ];
      }
      return $tab;
   }


   /**
    * Get request types of itil object between 2 dates
    *
    * @param string $date1 begin date
    * @param string $date2 end date
    *
    * @return array contains the distinct request types of tickets
   **/
   function getUsedRequestTypeBetween($date1 = '', $date2 = '') {
      global $DB;

      $ctable = $this->getTable();
      $criteria = [
         'SELECT'          => 'requesttypes_id',
         'DISTINCT'        => true,
         'FROM'            => $ctable,
         'WHERE'           => [
            "$ctable.is_deleted" => 0
         ] + getEntitiesRestrictCriteria($ctable),
         'ORDERBY'         => 'requesttypes_id'
      ];

      if (!empty($date1) || !empty($date2)) {
         $criteria['WHERE'][] = [
            'OR' => [
               getDateCriteria("$ctable.date", $date1, $date2),
               getDateCriteria("$ctable.closedate", $date1, $date2),
            ]
         ];
      }

      $iterator = $DB->request($criteria);
      $tab    = [];
      while ($line = $iterator->next()) {
         $tab[] = [
            'id'   => $line['requesttypes_id'],
            'link' => Dropdown::getDropdownName('glpi_requesttypes', $line['requesttypes_id']),
         ];
      }
      return $tab;
   }


   /**
    * Get solution types of itil object between 2 dates
    *
    * @param string $date1 begin date
    * @param string $date2 end date
    *
    * @return array contains the distinct request types of tickets
   **/
   function getUsedSolutionTypeBetween($date1 = '', $date2 = '') {
      global $DB;

      $ctable = $this->getTable();
      $criteria = [
         'SELECT'          => 'solutiontypes_id',
         'DISTINCT'        => true,
         'FROM'            => ITILSolution::getTable(),
         'INNER JOIN'      => [
            $ctable   => [
               'ON' => [
                  ITILSolution::getTable()   => 'items_id',
                  $ctable                    => 'id'
               ]
            ]
         ],
         'WHERE'           => [
            ITILSolution::getTable() . ".itemtype" => $this->getType(),
            "$ctable.is_deleted"                   => 0
         ] + getEntitiesRestrictCriteria($ctable),
         'ORDERBY'         => 'solutiontypes_id'
      ];

      if (!empty($date1) || !empty($date2)) {
         $criteria['WHERE'][] = [
            'OR' => [
               getDateCriteria("$ctable.date", $date1, $date2),
               getDateCriteria("$ctable.closedate", $date1, $date2),
            ]
         ];
      }

      $iterator = $DB->request($criteria);
      $tab    = [];
      while ($line = $iterator->next()) {
         $tab[] = [
            'id'   => $line['solutiontypes_id'],
            'link' => Dropdown::getDropdownName('glpi_solutiontypes', $line['solutiontypes_id']),
         ];
      }
      return $tab;
   }


   /** Get users which have intervention assigned to  between 2 dates
    *
    * @param string $date1 begin date
    * @param string $date2 end date
    *
    * @return array contains the distinct users which have any intervention assigned to.
   **/
   function getUsedTechBetween($date1 = '', $date2 = '') {
      global $DB;

      $linkclass = new $this->userlinkclass();
      $linktable = $linkclass->getTable();
      $showlink = User::canView();

      $ctable = $this->getTable();
      $criteria = [
         'SELECT'          => [
            'glpi_users.id AS users_id',
            'glpi_users.name AS name',
            'glpi_users.realname AS realname',
            'glpi_users.firstname AS firstname'
         ],
         'DISTINCT'        => true,
         'FROM'            => $ctable,
         'LEFT JOIN'       => [
            $linktable  => [
               'ON' => [
                  $linktable  => $this->getForeignKeyField(),
                  $ctable     => 'id', [
                     'AND' => [
                        "$linktable.type"    => CommonITILActor::ASSIGN
                     ]
                  ]
               ]
            ],
            'glpi_users'   => [
               'ON' => [
                  $linktable     => 'users_id',
                  'glpi_users'   => 'id'
               ]
            ]
         ],
         'WHERE'           => [
            "$ctable.is_deleted" => 0
         ] + getEntitiesRestrictCriteria($ctable),
         'ORDERBY'         => [
            'realname',
            'firstname',
            'name'
         ]
      ];

      if (!empty($date1) || !empty($date2)) {
         $criteria['WHERE'][] = [
            'OR' => [
               getDateCriteria("$ctable.date", $date1, $date2),
               getDateCriteria("$ctable.closedate", $date1, $date2),
            ]
         ];
      }

      $iterator = $DB->request($criteria);
      $tab    = [];

      while ($line = $iterator->next()) {
         $tab[] = [
            'id'   => $line['users_id'],
            'link' => formatUserName($line['users_id'], $line['name'], $line['realname'], $line['firstname'], $showlink),
         ];
      }
      return $tab;
   }


   /** Get users which have followup assigned to  between 2 dates
    *
    * @param string $date1 begin date
    * @param string $date2 end date
    *
    * @return array contains the distinct users which have any followup assigned to.
   **/
   function getUsedTechTaskBetween($date1 = '', $date2 = '') {
      global $DB;

      $linktable = getTableForItemType($this->getType().'Task');
      $showlink = User::canView();

      $ctable = $this->getTable();
      $criteria = [
         'SELECT'          => [
            'glpi_users.id AS users_id',
            'glpi_users.name AS name',
            'glpi_users.realname AS realname',
            'glpi_users.firstname AS firstname'
         ],
         'DISTINCT' => true,
         'FROM'            => $ctable,
         'LEFT JOIN'       => [
            $linktable  => [
               'ON' => [
                  $linktable  => $this->getForeignKeyField(),
                  $ctable     => 'id'
               ]
            ],
            'glpi_users'   => [
               'ON' => [
                  $linktable     => 'users_id',
                  'glpi_users'   => 'id'
               ]
            ],
            'glpi_profiles_users'   => [
               'ON' => [
                  'glpi_users'            => 'id',
                  'glpi_profiles_users'   => 'users_id'
               ]
            ],
            'glpi_profiles'         => [
               'ON' => [
                  'glpi_profiles'         => 'id',
                  'glpi_profiles_users'   => 'profiles_id'
               ]
            ],
            'glpi_profilerights'    => [
               'ON' => [
                  'glpi_profiles'      => 'id',
                  'glpi_profilerights' => 'profiles_id'
               ]
            ]
         ],
         'WHERE'           => [
            "$ctable.is_deleted"          => 0,
            'glpi_profilerights.name'     => 'ticket',
            'glpi_profilerights.rights'   => ['&', Ticket::OWN],
            "$linktable.users_id"         => ['<>', 0],
            ['NOT'                        => ["$linktable.users_id" => null]]
         ] + getEntitiesRestrictCriteria($ctable),
         'ORDERBY'         => [
            'realname',
            'firstname',
            'name'
         ]
      ];

      if (!empty($date1) || !empty($date2)) {
         $criteria['WHERE'][] = [
            'OR' => [
               getDateCriteria("$ctable.date", $date1, $date2),
               getDateCriteria("$ctable.closedate", $date1, $date2),
            ]
         ];
      }

      $iterator = $DB->request($criteria);
      $tab    = [];

      while ($line = $iterator->next()) {
         $tab[] = [
            'id'   => $line['users_id'],
            'link' => formatUserName($line['users_id'], $line['name'], $line['realname'], $line['firstname'], $showlink),
         ];
      }
      return $tab;
   }


   /** Get enterprises which have itil object assigned to between 2 dates
    *
    * @param string $date1 begin date
    * @param string $date2 end date
    *
    * @return array contains the distinct enterprises which have any tickets assigned to.
   **/
   function getUsedSupplierBetween($date1 = '', $date2 = '') {
      global $DB;

      $linkclass = new $this->supplierlinkclass();
      $linktable = $linkclass->getTable();

      $ctable = $this->getTable();
      $criteria = [
         'SELECT'          => [
            'glpi_suppliers.id AS suppliers_id_assign',
            'glpi_suppliers.name AS name'
         ],
         'DISTINCT'        => true,
         'FROM'            => $ctable,
         'LEFT JOIN'       => [
            $linktable        => [
               'ON' => [
                  $linktable  => $this->getForeignKeyField(),
                  $ctable     => 'id', [
                     'AND' => [
                        "$linktable.type"    => CommonITILActor::ASSIGN
                     ]
                  ]
               ]
            ],
            'glpi_suppliers'  => [
               'ON' => [
                  $linktable        => 'suppliers_id',
                  'glpi_suppliers'  => 'id'
               ]
            ]
         ],
         'WHERE'           => [
            "$ctable.is_deleted" => 0
         ] + getEntitiesRestrictCriteria($ctable),
         'ORDERBY'         => [
            'name'
         ]
      ];

      if (!empty($date1) || !empty($date2)) {
         $criteria['WHERE'][] = [
            'OR' => [
               getDateCriteria("$ctable.date", $date1, $date2),
               getDateCriteria("$ctable.closedate", $date1, $date2),
            ]
         ];
      }

      $iterator = $DB->request($criteria);
      $tab    = [];
      while ($line = $iterator->next()) {
         $tab[] = [
            'id'   => $line['suppliers_id_assign'],
            'link' => '<a href="' . Supplier::getFormURLWithID($line['suppliers_id_assign']) . '">' . $line['name'] . '</a>',
         ];
      }
      return $tab;
   }


   /** Get groups assigned to itil object between 2 dates
    *
    * @param string $date1 begin date
    * @param string $date2 end date
    *
    * @return array contains the distinct groups assigned to a tickets
   **/
   function getUsedAssignGroupBetween($date1 = '', $date2 = '') {
      global $DB;

      $linkclass = new $this->grouplinkclass();
      $linktable = $linkclass->getTable();

      $ctable = $this->getTable();
      $criteria = [
         'SELECT' => [
            'glpi_groups.id',
            'glpi_groups.completename'
         ],
         'DISTINCT'        => true,
         'FROM'            => $ctable,
         'LEFT JOIN'       => [
            $linktable  => [
               'ON' => [
                  $linktable  => $this->getForeignKeyField(),
                  $ctable     => 'id', [
                     'AND' => [
                        "$linktable.type"    => CommonITILActor::ASSIGN
                     ]
                  ]
               ]
            ],
            'glpi_groups'   => [
               'ON' => [
                  $linktable     => 'groups_id',
                  'glpi_groups'   => 'id'
               ]
            ]
         ],
         'WHERE'           => [
            "$ctable.is_deleted" => 0
         ] + getEntitiesRestrictCriteria($ctable),
         'ORDERBY'         => [
            'glpi_groups.completename'
         ]
      ];

      if (!empty($date1) || !empty($date2)) {
         $criteria['WHERE'][] = [
            'OR' => [
               getDateCriteria("$ctable.date", $date1, $date2),
               getDateCriteria("$ctable.closedate", $date1, $date2),
            ]
         ];
      }

      $iterator = $DB->request($criteria);
      $tab    = [];
      while ($line = $iterator->next()) {
         $tab[] = [
            'id'   => $line['id'],
            'link' => $line['completename'],
         ];
      }
      return $tab;
   }


   /**
    * Display a line for an object
    *
    * @since 0.85 (befor in each object with differents parameters)
    *
    * @param $id                 Integer  ID of the object
    * @param $options            array of options
    *      output_type            : Default output type (see Search class / default Search::HTML_OUTPUT)
    *      row_num                : row num used for display
    *      type_for_massiveaction : itemtype for massive action
    *      id_for_massaction      : default 0 means no massive action
    *      followups              : show followup columns
    *
    * @since 9.5.6 Usage of "followups" option is deprecated
    */
   static function showShort($id, $options = []) {
      global $DB;

      $p = [
         'output_type'            => Search::HTML_OUTPUT,
         'row_num'                => 0,
         'type_for_massiveaction' => 0,
         'id_for_massiveaction'   => 0,
         'followups'              => false,
      ];

      if (count($options)) {
         foreach ($options as $key => $val) {
            $p[$key] = $val;
         }
      }

      if ($p['followups']) {
         Toolbox::deprecated('Usage of "followups" option is deprecated.');
      }

      $rand = mt_rand();

      /// TODO to be cleaned. Get datas and clean display links

      // Prints a job in short form
      // Should be called in a <table>-segment
      // Print links or not in case of user view
      // Make new job object and fill it from database, if success, print it
      $item         = new static();

      $candelete   = static::canDelete();
      $canupdate   = Session::haveRight(static::$rightname, UPDATE);
      $showprivate = Session::haveRight('followup', ITILFollowup::SEEPRIVATE);
      $align       = "class='left'";
      $align_desc  = "class='left";

      if ($p['followups']) {
         $align      .= " top'";
         $align_desc .= " top'";
      } else {
         $align      .= "'";
         $align_desc .= "'";
      }

      if ($item->getFromDB($id)) {
         $item_num = 1;
         $bgcolor  = $_SESSION["glpipriority_".$item->fields["priority"]];

         echo Search::showNewLine($p['output_type'], $p['row_num']%2, $item->isDeleted());

         $check_col = '';
         if (($candelete || $canupdate)
             && ($p['output_type'] == Search::HTML_OUTPUT)
             && $p['id_for_massiveaction']) {

            $check_col = Html::getMassiveActionCheckBox($p['type_for_massiveaction'], $p['id_for_massiveaction']);
         }
         echo Search::showItem($p['output_type'], $check_col, $item_num, $p['row_num'], $align);

         // First column
         $first_col = sprintf(__('%1$s: %2$s'), __('ID'), $item->fields["id"]);
         if ($p['output_type'] == Search::HTML_OUTPUT) {
            $first_col .= "&nbsp;".static::getStatusIcon($item->fields["status"]);
         } else {
            $first_col = sprintf(__('%1$s - %2$s'), $first_col,
                                 static::getStatus($item->fields["status"]));
         }

         echo Search::showItem($p['output_type'], $first_col, $item_num, $p['row_num'], $align);

         // Second column
         if ($item->fields['status'] == static::CLOSED) {
            $second_col = sprintf(__('Closed on %s'),
                                  ($p['output_type'] == Search::HTML_OUTPUT?'<br>':'').
                                    Html::convDateTime($item->fields['closedate']));
         } else if ($item->fields['status'] == static::SOLVED) {
            $second_col = sprintf(__('Solved on %s'),
                                  ($p['output_type'] == Search::HTML_OUTPUT?'<br>':'').
                                    Html::convDateTime($item->fields['solvedate']));
         } else if ($item->fields['begin_waiting_date']) {
            $second_col = sprintf(__('Put on hold on %s'),
                                  ($p['output_type'] == Search::HTML_OUTPUT?'<br>':'').
                                    Html::convDateTime($item->fields['begin_waiting_date']));
         } else if ($item->fields['time_to_resolve']) {
            $second_col = sprintf(__('%1$s: %2$s'), __('Time to resolve'),
                                  ($p['output_type'] == Search::HTML_OUTPUT?'<br>':'').
                                    Html::convDateTime($item->fields['time_to_resolve']));
         } else {
            $second_col = sprintf(__('Opened on %s'),
                                  ($p['output_type'] == Search::HTML_OUTPUT?'<br>':'').
                                    Html::convDateTime($item->fields['date']));
         }

         echo Search::showItem($p['output_type'], $second_col, $item_num, $p['row_num'], $align." width=130");

         // Second BIS column
         $second_col = Html::convDateTime($item->fields["date_mod"]);
         echo Search::showItem($p['output_type'], $second_col, $item_num, $p['row_num'], $align." width=90");

         // Second TER column
         if (count($_SESSION["glpiactiveentities"]) > 1) {
            $second_col = Dropdown::getDropdownName('glpi_entities', $item->fields['entities_id']);
            echo Search::showItem($p['output_type'], $second_col, $item_num, $p['row_num'],
                                  $align." width=100");
         }

         // Third Column
         echo Search::showItem($p['output_type'],
                               "<span class='b'>".static::getPriorityName($item->fields["priority"]).
                                 "</span>",
                               $item_num, $p['row_num'], "$align bgcolor='$bgcolor'");

         // Fourth Column
         $fourth_col = "";

         foreach ($item->getUsers(CommonITILActor::REQUESTER) as $d) {
            $userdata    = getUserName($d["users_id"], 2);
            $fourth_col .= sprintf(__('%1$s %2$s'),
                                    "<span class='b'>".$userdata['name']."</span>",
                                    Html::showToolTip($userdata["comment"],
                                                      ['link'    => $userdata["link"],
                                                            'display' => false]));
            $fourth_col .= "<br>";
         }

         foreach ($item->getGroups(CommonITILActor::REQUESTER) as $d) {
            $fourth_col .= Dropdown::getDropdownName("glpi_groups", $d["groups_id"]);
            $fourth_col .= "<br>";
         }

         echo Search::showItem($p['output_type'], $fourth_col, $item_num, $p['row_num'], $align);

         // Fifth column
         $fifth_col = "";

         $entity = $item->getEntityID();
         $anonymize_helpdesk = Entity::getUsedConfig('anonymize_support_agents', $entity)
            && Session::getCurrentInterface() == 'helpdesk';

         foreach ($item->getUsers(CommonITILActor::ASSIGN) as $d) {
            if ($anonymize_helpdesk) {
               $fifth_col .= __("Helpdesk");
            } else {
               $userdata   = getUserName($d["users_id"], 2);
               $fifth_col .= sprintf(__('%1$s %2$s'),
                                    "<span class='b'>".$userdata['name']."</span>",
                                    Html::showToolTip($userdata["comment"],
                                                      ['link'    => $userdata["link"],
                                                            'display' => false]));
            }

            $fifth_col .= "<br>";
         }

         foreach ($item->getGroups(CommonITILActor::ASSIGN) as $d) {
            if ($anonymize_helpdesk) {
               $fifth_col .= __("Helpdesk group");
            } else {
               $fifth_col .= Dropdown::getDropdownName("glpi_groups", $d["groups_id"]);
            }
            $fifth_col .= "<br>";
         }

         foreach ($item->getSuppliers(CommonITILActor::ASSIGN) as $d) {
            $fifth_col .= Dropdown::getDropdownName("glpi_suppliers", $d["suppliers_id"]);
            $fifth_col .= "<br>";
         }

         echo Search::showItem($p['output_type'], $fifth_col, $item_num, $p['row_num'], $align);

         // Sixth Colum
         // Ticket : simple link to item
         $sixth_col  = "";
         $is_deleted = false;
         $item_ticket = new Item_Ticket();
         $data = $item_ticket->find(['tickets_id' => $item->fields['id']]);

         if ($item->getType() == 'Ticket') {
            if (!empty($data)) {
               foreach ($data as $val) {
                  if (!empty($val["itemtype"]) && ($val["items_id"] > 0)) {
                     if ($object = getItemForItemtype($val["itemtype"])) {
                        if ($object->getFromDB($val["items_id"])) {
                           $is_deleted = $object->isDeleted();

                           $sixth_col .= $object->getTypeName();
                           $sixth_col .= " - <span class='b'>";
                           if ($item->canView()) {
                              $sixth_col .= $object->getLink();
                           } else {
                              $sixth_col .= $object->getNameID();
                           }
                           $sixth_col .= "</span><br>";
                        }
                     }
                  }
               }
            } else {
               $sixth_col = __('General');
            }

            echo Search::showItem($p['output_type'], $sixth_col, $item_num, $p['row_num'], ($is_deleted ? " class='center deleted' " : $align));
         }

         // Seventh column
         echo Search::showItem($p['output_type'],
                               "<span class='b'>".
                                 Dropdown::getDropdownName('glpi_itilcategories',
                                                           $item->fields["itilcategories_id"]).
                               "</span>",
                               $item_num, $p['row_num'], $align);

         // Eigth column
         $eigth_column = "<span class='b'>".$item->getName()."</span>&nbsp;";

         // Add link
         if ($item->canViewItem()) {
            $eigth_column = "<a id='".$item->getType().$item->fields["id"]."$rand' href=\"".$item->getLinkURL()
                              ."\">$eigth_column</a>";

            if ($p['followups']
                && ($p['output_type'] == Search::HTML_OUTPUT)) {
               $eigth_column .= ITILFollowup::showShortForITILObject($item->fields["id"], static::class);
            } else {
               $eigth_column  = sprintf(
                  __('%1$s (%2$s)'),
                  $eigth_column,
                  sprintf(
                     __('%1$s - %2$s'),
                     $item->numberOfFollowups($showprivate),
                     $item->numberOfTasks($showprivate)
                  )
               );
            }
         }

         if ($p['output_type'] == Search::HTML_OUTPUT) {
            $eigth_column = sprintf(__('%1$s %2$s'), $eigth_column,
                                    Html::showToolTip(Html::clean(Html::entity_decode_deep($item->fields["content"])),
                                                      ['display' => false,
                                                            'applyto' => $item->getType().$item->fields["id"].
                                                                           $rand]));
         }

         echo Search::showItem($p['output_type'], $eigth_column, $item_num, $p['row_num'],
                               $align_desc." width='200'");

         //tenth column
         $tenth_column  = '';
         $planned_infos = '';

         $tasktype      = $item->getType()."Task";
         $plan          = new $tasktype();
         $items         = [];

         $result = $DB->request(
            [
               'FROM'  => $plan->getTable(),
               'WHERE' => [
                  $item->getForeignKeyField() => $item->fields['id'],
               ],
            ]
         );
         foreach ($result as $plan) {

            if (isset($plan['begin']) && $plan['begin']) {
               $items[$plan['id']] = $plan['id'];
               $planned_infos .= sprintf(__('From %s').
                                            ($p['output_type'] == Search::HTML_OUTPUT?'<br>':''),
                                         Html::convDateTime($plan['begin']));
               $planned_infos .= sprintf(__('To %s').
                                            ($p['output_type'] == Search::HTML_OUTPUT?'<br>':''),
                                         Html::convDateTime($plan['end']));
               if ($plan['users_id_tech']) {
                  $planned_infos .= sprintf(__('By %s').
                                               ($p['output_type'] == Search::HTML_OUTPUT?'<br>':''),
                                            getUserName($plan['users_id_tech']));
               }
               $planned_infos .= "<br>";
            }

         }

         $tenth_column = count($items);
         if ($tenth_column) {
            $tenth_column = "<span class='pointer'
                              id='".$item->getType().$item->fields["id"]."planning$rand'>".
                              $tenth_column.'</span>';
            $tenth_column = sprintf(__('%1$s %2$s'), $tenth_column,
                                    Html::showToolTip($planned_infos,
                                                      ['display' => false,
                                                            'applyto' => $item->getType().
                                                                           $item->fields["id"].
                                                                           "planning".$rand]));
         }
         echo Search::showItem($p['output_type'], $tenth_column, $item_num, $p['row_num'],
                               $align_desc." width='150'");

         // Finish Line
         echo Search::showEndLine($p['output_type']);
      } else {
         echo "<tr class='tab_bg_2'>";
         echo "<td colspan='6' ><i>".__('No item in progress.')."</i></td></tr>";
      }
   }

   /**
    * @param integer $output_type Output type
    * @param string  $mass_id     id of the form to check all
    */
   static function commonListHeader($output_type = Search::HTML_OUTPUT, $mass_id = '') {

      // New Line for Header Items Line
      echo Search::showNewLine($output_type);
      // $show_sort if
      $header_num                      = 1;

      $items                           = [];
      $items[(empty($mass_id)?'&nbsp':Html::getCheckAllAsCheckbox($mass_id))] = '';
      $items[__('Status')]             = "status";
      $items[_n('Date', 'Dates', 1)]               = "date";
      $items[__('Last update')]        = "date_mod";

      if (count($_SESSION["glpiactiveentities"]) > 1) {
         $items[Entity::getTypeName(Session::getPluralNumber())] = "glpi_entities.completename";
      }

      $items[__('Priority')]           = "priority";
      $items[_n('Requester', 'Requesters', 1)]          = "users_id";
      $items[__('Assigned')]           = "users_id_assign";
      if (static::getType() == 'Ticket') {
         $items[_n('Associated element', 'Associated elements', Session::getPluralNumber())] = "";
      }
      $items[__('Category')]           = "glpi_itilcategories.completename";
      $items[__('Title')]              = "name";
      $items[__('Planification')]      = "glpi_tickettasks.begin";

      foreach (array_keys($items) as $key) {
         $link   = "";
         echo Search::showHeaderItem($output_type, $key, $header_num, $link);
      }

      // End Line for column headers
      echo Search::showEndLine($output_type);
   }


   /**
    * Get correct Calendar: Entity or Sla
    *
    * @since 0.90.4
    *
    **/
   function getCalendar() {
      return Entity::getUsedConfig('calendars_id', $this->fields['entities_id']);
   }


   /**
    * Summary of getTimelinePosition
    * Returns the position of the $sub_type for the $user_id in the timeline
    *
    * @param int $items_id is the id of the ITIL object
    * @param string $sub_type is ITILFollowup, Document_Item, TicketTask, TicketValidation or Solution
    * @param int $users_id
    * @since 9.2
    */
   static function getTimelinePosition($items_id, $sub_type, $users_id) {
      $itilobject = new static;
      $itilobject->fields['id'] = $items_id;
      $actors = $itilobject->getITILActors();

      // 1) rule for followups, documents, tasks and validations:
      //    Matrix for position of timeline objects
      //    R O A (R=Requester, O=Observer, A=AssignedTo)
      //    0 0 1 -> Right
      //    0 1 0 -> Left
      //    0 1 1 -> R
      //    1 0 0 -> L
      //    1 0 1 -> L
      //    1 1 0 -> L
      //    1 1 1 -> L
      //    if users_id is not in the actor list, then pos is left
      // 2) rule for solutions: always on the right side

      // default position is left
      $pos = self::TIMELINE_LEFT;

      $pos_matrix = [];
      $pos_matrix[0][0][1] = self::TIMELINE_RIGHT;
      $pos_matrix[0][1][1] = self::TIMELINE_RIGHT;

      switch ($sub_type) {
         case 'ITILFollowup':
         case 'Document_Item':
         case static::class.'Task':
         case static::class.'Validation':
            if (isset($actors[$users_id])) {
               $r = in_array(CommonITILActor::REQUESTER, $actors[$users_id]) ? 1 : 0;
               $o = in_array(CommonITILActor::OBSERVER, $actors[$users_id]) ? 1 : 0;
               $a = in_array(CommonITILActor::ASSIGN, $actors[$users_id]) ? 1 : 0;
               if (isset($pos_matrix[$r][$o][$a])) {
                  $pos = $pos_matrix[$r][$o][$a];
               }
            }
            break;
         case 'Solution':
            $pos = self::TIMELINE_RIGHT;
            break;
      }

      return $pos;
   }


   /**
    * Gets submit button with a status dropdown
    *
    * @since 9.4.0
    *
    * @param integer $items_id
    * @param string  $action
    *
    * @return string HTML code for splitted submit button
   **/
   static function getSplittedSubmitButtonHtml($items_id, $action = "add") {
      $locale = _sx('button', 'Add');
      if ($action == 'update') {
         $locale = _x('button', 'Save');
      }
      $item       = new static();
      $item->getFromDB($items_id);
      $all_status   = static::getAllowedStatusArray($item->fields['status']);
      $rand = mt_rand();
      $html = "<div class='x-split-button' id='x-split-button'>
               <input type='submit' value='$locale' name='$action' class='x-button x-button-main'>
               <span class='x-button x-button-drop'>&nbsp;</span>
               <ul class='x-button-drop-menu'>";
      foreach ($all_status as $status_key => $status_label) {
         $checked = "";
         if ($status_key == $item->fields['status']) {
            $checked = "checked='checked'";
         }
         $html .= "<li data-status='".static::getStatusKey($status_key)."'>";
         $html .= "<input type='radio' id='status_radio_$status_key$rand' name='_status'
                    $checked value='$status_key'>";
         $html .= "<label for='status_radio_$status_key$rand'>";
         $html .= static::getStatusIcon($status_key) . "&nbsp;";
         $html .= $status_label;
         $html .= "</label>";
         $html .= "</li>";
      }
      $html .= "</ul></div>";
      $html.= "<script type='text/javascript'>$(function() {split_button();});</script>";
      return $html;
   }

   /**
    * Displays the timeline filter buttons
    *
    * @since 9.4.0
    *
    * @return void
    */
   function filterTimeline() {

      echo "<div class='filter_timeline'>";
      echo "<h3>".__("Timeline filter")." : </h3>";
      echo "<ul>";

      $objType = static::getType();

      echo "<li><a href='#' class='far fa-comment pointer' data-type='ITILFollowup' title='"._sn('Followup', 'Followups', 1).
         "'><span class='sr-only'>" . _n('Followup', 'Followups', 1) . "</span></a></li>";
      echo "<li><a href='#' class='far fa-check-square pointer' data-type='ITILTask' title='"._sn('Task', 'Tasks', 1).
         "'><span class='sr-only'>" . _n('Task', 'Tasks', 1) . "</span></a></li>";
      echo "<li><a href='#' class='fa fa-paperclip pointer' data-type='Document_Item' title='"._sn('Document', 'Documents', 1).
         "'><span class='sr-only'>" . Document::getTypeName(1) . "</span></a></li>";
      if (($objType === "Ticket") or ($objType === "Change")) {
         echo "<li><a href='#' class='far fa-thumbs-up pointer' data-type='ITILValidation' title='"._sn('Validation', 'Validations', 1).
            "'><span class='sr-only'>" . _n('Validation', 'Validations', 1) . "</span></a></li>";
      }
      echo "<li><a href='#' class='fa fa-check pointer' data-type='Solution' title='"._sn('Solution', 'Solutions', 1).
         "'><span class='sr-only'>" . ITILSolution::getTypeName(1)  . "</span></a></li>";
      echo "<li><a href='#' class='fa fa-ban pointer' data-type='reset' title=\"".__s("Reset display options").
         "\"><span class='sr-only'>" . __('Reset display options')  . "</span></a></li>";
      echo "</ul>";
      echo "</div>";

      echo "<script type='text/javascript'>$(function() {filter_timeline();});</script>";
   }


   /**
    * Displays the timeline header (filters)
    *
    * @since 9.4.0
    *
    * @return void
    */
   function showTimelineHeader() {

      echo "<h2>".__("Actions historical")." : </h2>";
      $this->filterTimeline();
   }


   /**
    * Displays the form at the top of the timeline.
    * Includes buttons to add items to the timeline, new item form, and approbation form.
    *
    * @since 9.4.0
    *
    * @param integer $rand random value used by JavaScript function names
    *
    * @return void
    */
   function showTimelineForm($rand) {

      global $CFG_GLPI, $DB;

      $objType = static::getType();
      $foreignKey = static::getForeignKeyField();

      //check sub-items rights
      $tmp = [$foreignKey => $this->getID()];
      $fupClass = "ITILFollowup";
      $fup = new $fupClass;
      $fup->getEmpty();
      $fup->fields['itemtype'] = $objType;
      $fup->fields['items_id'] = $this->getID();

      $taskClass = $objType."Task";
      $task = new $taskClass;

      $canadd_fup = $fup->can(-1, CREATE, $tmp) && !in_array($this->fields["status"],
                        array_merge($this->getSolvedStatusArray(), $this->getClosedStatusArray()));
      $canadd_task = $task->can(-1, CREATE, $tmp) && !in_array($this->fields["status"],
                         array_merge($this->getSolvedStatusArray(), $this->getClosedStatusArray()));
      $canadd_document = $canadd_fup || $this->canAddItem('Document') && !in_array($this->fields["status"],
                         array_merge($this->getSolvedStatusArray(), $this->getClosedStatusArray()));
      $canadd_solution = $objType::canUpdate() && $this->canSolve() && !in_array($this->fields["status"], $this->getSolvedStatusArray());

      $validation_class = $objType.'Validation';
      $canadd_validation = false;
      if (class_exists($validation_class)) {
         $validation = new $validation_class();
         $canadd_validation = $validation->can(-1, CREATE, $tmp) && !in_array($this->fields["status"],
               array_merge($this->getSolvedStatusArray(), $this->getClosedStatusArray()));
      }

      // javascript function for add and edit items
      echo "<script type='text/javascript' >
      function change_task_state(tasks_id, target) {
         $.post('".$CFG_GLPI["root_doc"]."/ajax/timeline.php',
                {'action':     'change_task_state',
                  'tasks_id':   tasks_id,
                  'parenttype': '$objType',
                  '$foreignKey': ".$this->fields['id']."
                })
                .done(function(response) {
                  $(target).removeClass('state_1 state_2')
                           .addClass('state_'+response.state)
                           .attr('title', response.label);
                });
      }

      function viewEditSubitem" . $this->fields['id'] . "$rand(e, itemtype, items_id, o, domid) {
               domid = (typeof domid === 'undefined')
                         ? 'viewitem".$this->fields['id'].$rand."'
                         : domid;
               var target = e.target || window.event.srcElement;
               if (target.nodeName == 'a') return;
               if (target.className == 'read_more_button') return;

               var _eltsel = '[data-uid='+domid+']';
               var _elt = $(_eltsel);
               _elt.addClass('edited');
               $(_eltsel + ' .displayed_content').hide();
               $(_eltsel + ' .cancel_edit_item_content').show()
                                                        .click(function() {
                                                            $(this).hide();
                                                            _elt.removeClass('edited');
                                                            $(_eltsel + ' .edit_item_content').empty().hide();
                                                            $(_eltsel + ' .displayed_content').show();
                                                        });
               $(_eltsel + ' .edit_item_content').show()
                                                 .load('".$CFG_GLPI["root_doc"]."/ajax/timeline.php',
                                                       {'action'    : 'viewsubitem',
                                                        'type'      : itemtype,
                                                        'parenttype': '$objType',
                                                        '$foreignKey': ".$this->fields['id'].",
                                                        'id'        : items_id
                                                       });
      };
      </script>";

      if (!$canadd_fup && !$canadd_task && !$canadd_document && !$canadd_solution && !$this->canReopen()) {
         return false;
      }

      echo "<script type='text/javascript' >\n";
      echo "function viewAddSubitem" . $this->fields['id'] . "$rand(itemtype) {\n";
      $params = ['action'     => 'viewsubitem',
                      'type'       => 'itemtype',
                      'parenttype' => $objType,
                      $foreignKey => $this->fields['id'],
                      'id'         => -1];
      if (isset($_GET['load_kb_sol'])) {
         $params['load_kb_sol'] = $_GET['load_kb_sol'];
      }
      $out = Ajax::updateItemJsCode("viewitem" . $this->fields['id'] . "$rand",
                                    $CFG_GLPI["root_doc"]."/ajax/timeline.php",
                                    $params, "", false);
      echo str_replace("\"itemtype\"", "itemtype", $out);
      echo "$('#approbation_form$rand').remove()";
      echo "};";

      if (isset($_GET['load_kb_sol'])) {
         echo "viewAddSubitem" . $this->fields['id'] . "$rand('Solution');";
      }

      if (isset($_GET['_openfollowup'])) {
         echo "viewAddSubitem" . $this->fields['id'] . "$rand('ITILFollowup')";
      }
      echo "</script>\n";

      //show choices
      echo "<div class='timeline_form'>";
      echo "<ul class='timeline_choices'>";

      if ($canadd_fup || $canadd_task || $canadd_document || $canadd_solution) {
         echo "<h2>"._sx('button', 'Add')." : </h2>";
      }
      if ($canadd_fup) {
         echo "<li class='followup' onclick='".
              "javascript:viewAddSubitem".$this->fields['id']."$rand(\"ITILFollowup\");'>"
              . "<i class='far fa-comment'></i>"._n('Followup', 'Followups', 1)."</li>";
      }

      if ($canadd_task) {
         echo "<li class='task' onclick='".
              "javascript:viewAddSubitem".$this->fields['id']."$rand(\"$taskClass\");'>"
              ."<i class='far fa-check-square'></i>"._n('Task', 'Tasks', 1)."</li>";
      }
      if ($canadd_document) {
         echo "<li class='document' onclick='".
              "javascript:viewAddSubitem".$this->fields['id']."$rand(\"Document_Item\");'>"
              ."<i class='fa fa-paperclip'></i>".Document::getTypeName(1)."</li>";
      }
      if ($canadd_validation) {
         echo "<li class='validation' onclick='".
            "javascript:viewAddSubitem".$this->fields['id']."$rand(\"$validation_class\");'>"
            ."<i class='far fa-thumbs-up'></i>"._n('Approval', 'Approvals', 1)."</li>";
      }
      if ($canadd_solution) {
         echo "<li class='solution' onclick='".
              "javascript:viewAddSubitem".$this->fields['id']."$rand(\"Solution\");'>"
              ."<i class='fa fa-check'></i>"._n('Solution', 'Solutions', 1)."</li>";
      }
      Plugin::doHook('timeline_actions', ['item' => $this, 'rand' => $rand]);

      echo "</ul>"; // timeline_choices
      echo "<div class='clear'>&nbsp;</div>";
      //total_actiontime stat
      if (Session::getCurrentInterface() != 'helpdesk') {
         echo "<div class='timeline_stats'>";

         $taskClass  = $objType . "Task";
         $task_table = getTableForItemType($taskClass);
         $foreignKey = static::getForeignKeyField();

         $total_actiontime = 0;

         $criteria = [
            'SELECT'   => ['SUM' => 'actiontime AS actiontime'],
            'FROM'     => $task_table,
            'WHERE'    => [$foreignKey => $this->fields['id']]
         ];

         $req = $DB->request($criteria);
         if ($row = $req->next()) {
            $total_actiontime = $row['actiontime'];
         }
         if ($total_actiontime > 0) {
            echo "<h3>";
            $total   = Html::timestampToString($total_actiontime, false);
            $message = sprintf(__('Total duration: %s'),
                               $total);
            echo $message;
            echo "</h3>";
         }

         $criteria    = [$foreignKey => $this->fields['id']];
         $total_tasks = countElementsInTable($task_table, $criteria);
         if ($total_tasks > 0) {
            $states = [Planning::INFO => __('Information tasks: %s %%'),
                       Planning::TODO => __('Todo tasks: %s %%'),
                       Planning::DONE => __('Done tasks: %s %% ')];
            echo "<h3>";
            foreach ($states as $state => $string) {
               $criteria = [$foreignKey => $this->fields['id'],
                            "state"     => $state];
               $tasks    = countElementsInTable($task_table, $criteria);
               if ($tasks > 0) {
                  $percent_todotasks = Html::formatNumber((($tasks * 100) / $total_tasks));
                  $message           = sprintf($string,
                                               $percent_todotasks);
                  echo "&nbsp;";
                  echo $message;
               }
            }
            echo "</h3>";
         }
         echo "</div>";
      }
      echo "</div>"; //end timeline_form

      echo "<div class='ajax_box' id='viewitem" . $this->fields['id'] . "$rand'></div>\n";
   }


   /**
    * Retrieves all timeline items for this ITILObject
    *
    * @since 9.4.0
    *
    * @return mixed[] Timeline items
    */
   function getTimelineItems() {

      $objType = static::getType();
      $foreignKey = static::getForeignKeyField();
      $supportsValidation = $objType === "Ticket" || $objType === "Change";

      $timeline = [];

      $user = new User();

      $fupClass           = 'ITILFollowup';
      $followup_obj       = new $fupClass;
      $taskClass             = $objType."Task";
      $task_obj              = new $taskClass;
      $document_item_obj     = new Document_Item();
      if ($supportsValidation) {
         $validation_class    = $objType."Validation";
         $valitation_obj     = new $validation_class;
      }

      //checks rights
      $restrict_fup = $restrict_task = [];
      if (!Session::haveRight("followup", ITILFollowup::SEEPRIVATE)) {
         $restrict_fup = [
            'OR' => [
               'is_private'   => 0,
               'users_id'     => Session::getLoginUserID()
            ]
         ];
      }

      $restrict_fup['itemtype'] = static::getType();
      $restrict_fup['items_id'] = $this->getID();

      if ($task_obj->maybePrivate() && !Session::haveRight("task", CommonITILTask::SEEPRIVATE)) {
         $restrict_task = [
            'OR' => [
               'is_private'   => 0,
               'users_id'     => Session::getCurrentInterface() == "central"
                                    ? Session::getLoginUserID()
                                    : 0
            ]
         ];
      }

      //add followups to timeline
      if ($followup_obj->canview()) {
         $followups = $followup_obj->find(['items_id'  => $this->getID()] + $restrict_fup, ['date DESC', 'id DESC']);
         foreach ($followups as $followups_id => $followup) {
            $followup_obj->getFromDB($followups_id);
            $followup['can_edit']                                   = $followup_obj->canUpdateItem();;
            $timeline[$followup['date']."_followup_".$followups_id] = ['type' => $fupClass,
                                                                            'item' => $followup,
                                                                            'itiltype' => 'Followup'];
         }
      }

      //add tasks to timeline
      if ($task_obj->canview()) {
         $tasks = $task_obj->find([$foreignKey => $this->getID()] + $restrict_task, 'date DESC');
         foreach ($tasks as $tasks_id => $task) {
            $task_obj->getFromDB($tasks_id);
            $task['can_edit']                           = $task_obj->canUpdateItem();
            $timeline[$task['date']."_task_".$tasks_id] = ['type' => $taskClass,
                                                                'item' => $task,
                                                                'itiltype' => 'Task'];
         }
      }

      //add documents to timeline
      $document_obj   = new Document();
      $document_items = $document_item_obj->find([
         $this->getAssociatedDocumentsCriteria(),
         'timeline_position'  => ['>', self::NO_TIMELINE]
      ]);
      foreach ($document_items as $document_item) {
         $document_obj->getFromDB($document_item['documents_id']);

         $date = $document_item['date'] ?? $document_item['date_creation'];

         $item = $document_obj->fields;
         $item['date'] = $date;
         // #1476 - set date_mod and owner to attachment ones
         $item['date_mod'] = $document_item['date_mod'];
         $item['users_id'] = $document_item['users_id'];
         $item['documents_item_id'] = $document_item['id'];

         $item['timeline_position'] = $document_item['timeline_position'];

         $timeline[$date."_document_".$document_item['documents_id']]
            = ['type' => 'Document_Item', 'item' => $item];
      }

      $solution_obj = new ITILSolution();
      $solution_items = $solution_obj->find([
         'itemtype'  => static::getType(),
         'items_id'  => $this->getID()
      ]);
      foreach ($solution_items as $solution_item) {
         // fix trouble with html_entity_decode who skip accented characters (on windows browser)
         $solution_content = preg_replace_callback("/(&#[0-9]+;)/", function($m) {
            return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES");
         }, $solution_item['content']);

         $timeline[$solution_item['date_creation']."_solution_" . $solution_item['id'] ] = [
            'type' => 'Solution',
            'item' => [
               'id'                 => $solution_item['id'],
               'content'            => Toolbox::unclean_cross_side_scripting_deep($solution_content),
               'date'               => $solution_item['date_creation'],
               'users_id'           => $solution_item['users_id'],
               'solutiontypes_id'   => $solution_item['solutiontypes_id'],
               'can_edit'           => $objType::canUpdate() && $this->canSolve(),
               'timeline_position'  => self::TIMELINE_RIGHT,
               'users_id_editor'    => $solution_item['users_id_editor'],
               'date_mod'           => $solution_item['date_mod'],
               'users_id_approval'  => $solution_item['users_id_approval'],
               'date_approval'      => $solution_item['date_approval'],
               'status'             => $solution_item['status']
            ]
         ];
      }

      if ($supportsValidation and $validation_class::canView()) {
         $validations = $valitation_obj->find([$foreignKey => $this->getID()]);
         foreach ($validations as $validations_id => $validation) {
            $canedit = $valitation_obj->can($validations_id, UPDATE);
            $cananswer = ($validation['users_id_validate'] === Session::getLoginUserID() &&
               $validation['status'] == CommonITILValidation::WAITING);
            $user->getFromDB($validation['users_id_validate']);
            $timeline[$validation['submission_date']."_validation_".$validations_id] = [
               'type' => $validation_class,
               'item' => [
                  'id'        => $validations_id,
                  'date'      => $validation['submission_date'],
                  'content'   => __('Validation request')." => ".$user->getlink().
                                                 "<br>".$validation['comment_submission'],
                  'users_id'  => $validation['users_id'],
                  'can_edit'  => $canedit,
                  'can_answer'   => $cananswer,
                  'users_id_validate'  => $validation['users_id_validate'],
                  'timeline_position' => $validation['timeline_position']
               ],
               'itiltype' => 'Validation'
            ];

            if (!empty($validation['validation_date'])) {
               $timeline[$validation['validation_date']."_validation_".$validations_id] = [
                  'type' => $validation_class,
                  'item' => [
                     'id'        => $validations_id,
                     'date'      => $validation['validation_date'],
                     'content'   => __('Validation request answer')." : ". _sx('status',
                                                 ucfirst($validation_class::getStatus($validation['status'])))
                                                   ."<br>".$validation['comment_validation'],
                     'users_id'  => $validation['users_id_validate'],
                     'status'    => "status_".$validation['status'],
                     'can_edit'  => $canedit,
                     'timeline_position' => $validation['timeline_position']
                  ],
                  'itiltype' => 'Validation'
               ];
            }
         }
      }

      //reverse sort timeline items by key (date)
      krsort($timeline);

      return $timeline;
   }


   /**
    * Displays the timeline of items for this ITILObject
    *
    * @since 9.4.0
    *
    * @param integer $rand random value used by div
    *
    * @return void
    */
   function showTimeline($rand) {
      global $DB, $CFG_GLPI, $autolink_options;

      $user              = new User();
      $group             = new Group();
      $pics_url          = $CFG_GLPI['root_doc']."/pics/timeline";
      $timeline          = $this->getTimelineItems();

      $autolink_options['strip_protocols'] = false;

      $objType = static::getType();
      $foreignKey = static::getForeignKeyField();

      //display timeline
      echo "<div class='timeline_history'>";

      $followup_class    = 'ITILFollowup';
      $followup_obj      = new $followup_class();
      $followup_obj->getEmpty();
      $followup_obj->fields['itemtype'] = $objType;

      // show approbation form on top when ticket/change is solved
      if ($this->fields["status"] == CommonITILObject::SOLVED) {
         echo "<div class='approbation_form' id='approbation_form$rand'>";
         $followup_obj->showApprobationForm($this);
         echo "</div>";
      }

      // show title for timeline
      $this->showTimelineHeader();

      $timeline_index = 0;
      foreach ($timeline as $item) {
         $options = [ 'parent' => $this,
                           'rand' => $rand
                           ];
         if ($obj = getItemForItemtype($item['type'])) {
            $obj->fields = $item['item'];
         } else {
            $obj = $item;
         }
         Plugin::doHook('pre_show_item', ['item' => $obj, 'options' => &$options]);

         if (is_array($obj)) {
            $item_i = $obj['item'];
         } else {
            $item_i = $obj->fields;
         }

         $date = "";
         if (isset($item_i['date'])) {
            $date = $item_i['date'];
         } else if (isset($item_i['date_mod'])) {
            $date = $item_i['date_mod'];
         }

         // set item position depending on field timeline_position
         $user_position = 'left'; // default position
         if (isset($item_i['timeline_position'])) {
            switch ($item_i['timeline_position']) {
               case self::TIMELINE_LEFT:
                  $user_position = 'left';
                  break;
               case self::TIMELINE_MIDLEFT:
                  $user_position = 'left middle';
                  break;
               case self::TIMELINE_MIDRIGHT:
                  $user_position = 'right middle';
                  break;
               case self::TIMELINE_RIGHT:
                  $user_position = 'right';
                  break;
            }
         }

         //display solution in middle
         if (($item['type'] == "Solution") && $item_i['status'] != CommonITILValidation::REFUSED
              && in_array($this->fields["status"], [CommonITILObject::SOLVED, CommonITILObject::CLOSED])) {
            $user_position.= ' middle';
         }

         echo "<div class='h_item $user_position'>";

         echo "<div class='h_info'>";

         echo "<div class='h_date'><i class='far fa-clock'></i>".Html::convDateTime($date)."</div>";
         if ($item_i['users_id'] !== false) {
            echo "<div class='h_user'>";
            if (isset($item_i['users_id']) && ($item_i['users_id'] != 0)) {
               $user->getFromDB($item_i['users_id']);

               echo "<div class='tooltip_picture_border'>";
               echo "<img class='user_picture' alt=\"".__s('Picture')."\" src='".
                      User::getThumbnailURLForPicture($user->fields['picture'])."'>";
               echo "</div>";

               echo "<span class='h_user_name'>";
               $userdata = getUserName($item_i['users_id'], 2);
               $entity = $this->getEntityID();

               $itilFollowup = ITILFollowup::getById($item_i['id']);
               $document_item = null;
               if (isset($item_i['documents_item_id'])) {
                  $documentItem = Document_Item::getById($item_i['documents_item_id']);
               }

               if (Entity::getUsedConfig('anonymize_support_agents', $entity)
                  && Session::getCurrentInterface() == 'helpdesk'
                  && (
                     $item['type'] == "Solution"
                     || is_subclass_of($item['type'], "CommonITILTask")
                     || ($item['type'] == "ITILFollowup"
                        && is_object($itilFollowup)
                        && $itilFollowup->isFromSupportAgent()
                     )
                     || ($item['type'] == "Document_Item"
                        && is_object($documentItem)
                        && $documentItem->isFromSupportAgent()
                     )
                  )
               ) {
                  echo __("Helpdesk");
               } else {
                  echo $user->getLink()."&nbsp;";
                  echo Html::showToolTip(
                     $userdata["comment"],
                     Session::getCurrentInterface() != 'helpdesk' ? ['link' => $userdata['link']] : []
                  );
               }
               echo "</span>";
            } else {
               echo _n('Requester', 'Requesters', 1);
            }
            echo "</div>"; // h_user
         }

         echo "</div>"; //h_info

         $domid = "viewitem{$item['type']}{$item_i['id']}";
         if ($item['type'] == $objType.'Validation' && isset($item_i['status'])) {
            $domid .= $item_i['status'];
         }
         $randdomid = $domid . $rand;
         $domid = Toolbox::slugify($domid);

         $fa = null;
         $class = "h_content";
         if (isset($item['itiltype'])) {
            $class .= " ITIL{$item['itiltype']}";
         } else {
            $class .= " {$item['type']}";
         }
         if ($item['type'] == 'Solution') {
            switch ($item_i['status']) {
               case CommonITILValidation::WAITING:
                  $fa = 'question';
                  $class .= ' waiting';
                  break;
               case CommonITILValidation::ACCEPTED:
                  $fa = 'thumbs-up';
                  $class .= ' accepted';
                  break;
               case CommonITILValidation::REFUSED:
                  $fa = 'thumbs-down';
                  $class .= ' refused';
                  break;
            }
         } else if (isset($item_i['status'])) {
            $class .= " {$item_i['status']}";
         }

         echo "<div class='$class' id='$domid' data-uid='$randdomid'>";
         if ($fa !== null) {
            echo "<i class='solimg fa fa-$fa fa-5x'></i>";
         }
         if (isset($item_i['can_edit']) && $item_i['can_edit']) {
            echo "<div class='edit_item_content'></div>";
            echo "<span class='cancel_edit_item_content'></span>";
         }
         echo "<div class='displayed_content'>";
         echo "<div class='h_controls'>";
         if (!in_array($item['type'], ['Document_Item', 'Assign'])
            && $item_i['can_edit']
            && !in_array($this->fields['status'], $this->getClosedStatusArray())
         ) {
            // merge/split icon
            if ($objType == 'Ticket' && $item['type'] == ITILFollowup::getType()) {
               if (isset($item_i['sourceof_items_id']) && $item_i['sourceof_items_id'] > 0) {
                  echo Html::link('', Ticket::getFormURLWithID($item_i['sourceof_items_id']), [
                     'class' => 'fa fa-code-branch control_item disabled',
                     'title' => __('Followup was already promoted')
                  ]);
               } else {
                  echo Html::link('', Ticket::getFormURL()."?_promoted_fup_id=".$item_i['id'], [
                     'class' => 'fa fa-code-branch control_item',
                     'title' => __('Promote to Ticket')
                  ]);
               }
            }
            // edit item
            echo "<span class='far fa-edit control_item' title='".__('Edit')."'";
            echo "onclick='javascript:viewEditSubitem".$this->fields['id']."$rand(event, \"".$item['type']."\", ".$item_i['id'].", this, \"$randdomid\")'";
            echo "></span>";
         }

         // show "is_private" icon
         if (isset($item_i['is_private']) && $item_i['is_private']) {
            echo "<span class='private'><i class='fas fa-lock control_item' title='" . __s('Private') .
               "'></i><span class='sr-only'>".__('Private')."</span></span>";
         }

         echo "</div>";
         if (isset($item_i['requesttypes_id'])
             && file_exists("$pics_url/".$item_i['requesttypes_id'].".png")) {
            echo "<img src='$pics_url/".$item_i['requesttypes_id'].".png' class='h_requesttype' />";
         }

         if (isset($item_i['content'])) {
            $content = $item_i['content'];
            $content = Toolbox::getHtmlToDisplay($content);
            $content = autolink($content, false);

            $long_text = "";
            if ((substr_count($content, "<br") > 30) || (strlen($content) > 2000)) {
               $long_text = "long_text";
            }

            echo "<div class='item_content $long_text'>";
            echo "<p>";
            if (isset($item_i['state'])) {
               $onClick = "onclick='change_task_state(".$item_i['id'].", this)'";
               if (!$item_i['can_edit']) {
                  $onClick = "style='cursor: not-allowed;'";
               }
               echo "<span class='state state_".$item_i['state']."'
                           $onClick
                           title='".Planning::getState($item_i['state'])."'>";
               echo "</span>";
            }
            echo "</p>";

            echo "<div class='rich_text_container'>";
            $richtext = Html::setRichTextContent('', $content, '', true);
            $richtext = Html::replaceImagesByGallery($richtext);
            echo $richtext;
            echo "</div>";

            if (!empty($long_text)) {
               echo "<p class='read_more'>";
               echo "<a class='read_more_button'>.....</a>";
               echo "</p>";
            }
            echo "</div>";
         }

         $entity = $this->getEntityID();
         echo "<div class='b_right'>";
         if (isset($item_i['solutiontypes_id']) && !empty($item_i['solutiontypes_id'])) {
            echo Dropdown::getDropdownName("glpi_solutiontypes", $item_i['solutiontypes_id'])."<br>";
         }
         if (isset($item_i['taskcategories_id']) && !empty($item_i['taskcategories_id'])) {
            echo Dropdown::getDropdownName("glpi_taskcategories", $item_i['taskcategories_id'])."<br>";
         }
         if (isset($item_i['requesttypes_id']) && !empty($item_i['requesttypes_id'])) {
            echo Dropdown::getDropdownName("glpi_requesttypes", $item_i['requesttypes_id'])."<br>";
         }

         if (isset($item_i['actiontime']) && !empty($item_i['actiontime'])) {
            echo "<span class='actiontime'>";
            echo Html::timestampToString($item_i['actiontime'], false);
            echo "</span>";
         }
         if (isset($item_i['begin'])) {
            echo "<span class='planification'>";
            echo Html::convDateTime($item_i["begin"]);
            echo " &rArr; ";
            echo Html::convDateTime($item_i["end"]);
            echo "</span>";
         }
         if (isset($item_i['users_id_tech']) && ($item_i['users_id_tech'] > 0)) {
            echo "<div class='users_id_tech' id='users_id_tech_".$item_i['users_id_tech']."'>";
            $user->getFromDB($item_i['users_id_tech']);

            if (Entity::getUsedConfig('anonymize_support_agents', $entity)
               && Session::getCurrentInterface() == 'helpdesk'
            ) {
               echo __("Helpdesk");
            } else {
               echo "<i class='fas fa-user'></i> ";
               $userdata = getUserName($item_i['users_id_tech'], 2);
               echo $user->getLink()."&nbsp;";
               echo Html::showToolTip(
                  $userdata["comment"],
                  ['link' => $userdata['link']]
               );
            }
            echo "</div>";
         }
         if (isset($item_i['groups_id_tech']) && ($item_i['groups_id_tech'] > 0)) {
            echo "<div class='groups_id_tech'>";
            $group->getFromDB($item_i['groups_id_tech']);
            echo "<i class='fas fa-users' aria-hidden='true'></i>&nbsp;";
            echo $group->getLink(['comments' => true]);
            echo "</div>";
         }
         if (isset($item_i['users_id_editor']) && $item_i['users_id_editor'] > 0) {
            echo "<div class='users_id_editor' id='users_id_editor_".$item_i['users_id_editor']."'>";

            if (Entity::getUsedConfig('anonymize_support_agents', $entity)
               && Session::getCurrentInterface() == 'helpdesk'
            ) {
               echo sprintf(
                  __('Last edited on %1$s by %2$s'),
                  Html::convDateTime($item_i['date_mod']),
                  __("Helpdesk")
               );
            } else {
               $user->getFromDB($item_i['users_id_editor']);
               $userdata = getUserName($item_i['users_id_editor'], 2);
               echo sprintf(
                  __('Last edited on %1$s by %2$s'),
                  Html::convDateTime($item_i['date_mod']),
                  $user->getLink()
               );
               echo Html::showToolTip($userdata["comment"],
                                      ['link' => $userdata['link']]);
            }

            echo "</div>";
         }
         if ($objType == 'Ticket' && isset($item_i['sourceitems_id']) && $item_i['sourceitems_id'] > 0) {
            echo "<div id='sourceitems_id_".$item_i['sourceitems_id']."'>";
            echo sprintf(
               __('Merged from Ticket %1$s'),
               Html::link($item_i['sourceitems_id'], Ticket::getFormURLWithID($item_i['sourceitems_id']))
            );
            echo "</div>";
         }
         if ($objType == 'Ticket' && isset($item_i['sourceof_items_id']) && $item_i['sourceof_items_id'] > 0) {
            echo "<div id='sourceof_items_id_".$item_i['sourceof_items_id']."'>";
            echo sprintf(
               __('Promoted to Ticket %1$s'),
               Html::link($item_i['sourceof_items_id'], Ticket::getFormURLWithID($item_i['sourceof_items_id']))
            );
            echo "</div>";
         }
         if (strpos($item['type'], 'Validation') > 0 &&
            (isset($item_i['can_answer']) && $item_i['can_answer'])) {
            $form_url = $item['type']::getFormURL();
            echo "<form id='validationanswers_id_{$item_i['id']}' class='center' action='$form_url' method='post'>";
            echo Html::hidden('id', ['value' => $item_i['id']]);
            echo Html::hidden('users_id_validate', ['value' => $item_i['users_id_validate']]);
            Html::textarea([
               'name'   => 'comment_validation',
               'rows'   => 5
            ]);
            echo "<button type='submit' class='submit approve' name='approval_action' value='approve'>";
            echo "<i class='far fa-thumbs-up'></i>&nbsp;&nbsp;".__('Approve')."</button>";

            echo "<button type='submit' class='submit refuse very_small_space' name='approval_action' value='refuse'>";
            echo "<i class='far fa-thumbs-down'></i>&nbsp;&nbsp;".__('Refuse')."</button>";
            Html::closeForm();
         }
         if ($item['type'] == 'Solution' && $item_i['status'] != CommonITILValidation::WAITING && $item_i['status'] != CommonITILValidation::NONE) {
            echo "<div class='users_id_approval' id='users_id_approval_".$item_i['users_id_approval']."'>";
            $user->getFromDB($item_i['users_id_approval']);
            $userdata = getUserName($item_i['users_id_editor'], 2);
            $message = __('%1$s on %2$s by %3$s');
            $action = $item_i['status'] == CommonITILValidation::ACCEPTED ? __('Accepted') : __('Refused');
            echo sprintf(
               $message,
               $action,
               Html::convDateTime($item_i['date_approval']),
               $user->getLink()
            );
            echo Html::showToolTip($userdata["comment"],
                                   ['link' => $userdata['link']]);
            echo "</div>";
         }

         echo "</div>"; // b_right

         if ($item['type'] == 'Document_Item') {
            if ($item_i['filename']) {
               $filename = $item_i['filename'];
               $ext      = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
               echo "<img src='";
               if (empty($filename)) {
                  $filename = $item_i['name'];
               }
               if (file_exists(GLPI_ROOT."/pics/icones/$ext-dist.png")) {
                  echo $CFG_GLPI['root_doc']."/pics/icones/$ext-dist.png";
               } else {
                  echo "$pics_url/file.png";
               }
               echo "'/>&nbsp;";

               $docsrc = $CFG_GLPI['root_doc']."/front/document.send.php?docid=".$item_i['id']
                      ."&$foreignKey=".$this->getID();
               echo Html::link($filename, $docsrc, ['target' => '_blank']);
               $docpath = GLPI_DOC_DIR . '/' . $item_i['filepath'];
               if (Document::isImage($docpath)) {
                  $imgsize = getimagesize($docpath);
                  echo Html::imageGallery([
                     [
                        'src'             => $docsrc,
                        'thumbnail_src'   => $docsrc . '&context=timeline',
                        'w'               => $imgsize[0],
                        'h'               => $imgsize[1]
                     ]
                  ], [
                     'gallery_item_class' => 'timeline_img_preview'
                  ]);
               }
            }
            if ($item_i['link']) {
               echo "<a href='{$item_i['link']}' target='_blank'><i class='fa fa-external-link'></i>{$item_i['name']}</a>";
            }
            if (!empty($item_i['mime'])) {
               echo "&nbsp;";
               echo Html::showToolTip(
                  sprintf(__('File size: %s'), Toolbox::getSize(filesize(GLPI_DOC_DIR . "/" . $item_i['filepath']))) . '<br>'
                  . sprintf(__('MIME type: %s'), $item_i['mime'])
               );
            }
            echo "<span class='buttons'>";
            if (Session::getCurrentInterface() != 'helpdesk') {
               echo "<a href='".Document::getFormURLWithID($item_i['id'])."' class='edit_document fa fa-eye pointer' title='".
                     _sx("button", "Show")."'>";
               echo "<span class='sr-only'>" . _sx('button', 'Show') . "</span></a>";
            }

            $doc = new Document();
            $doc->getFromDB($item_i['id']);
            if ($doc->can($item_i['id'], UPDATE)) {
               echo '<form method="POST" action="' . static::getFormURL() . '" style="display:inline;">';
               echo Html::hidden('_glpi_csrf_token', ['value' => Session::getNewCSRFToken()]);
               echo Html::hidden('delete_document', ['value' => 1]);
               echo Html::hidden('documents_id', ['value' => $item_i['id']]);
               echo Html::hidden($foreignKey, ['value' => $this->getID()]);
               echo '<button type="submit" class="unstyled">';
               echo '<i class="delete_document fas fa-trash-alt pointer"
                        title="' .  _sx("button", "Delete permanently") . '"></i>';
               echo '<span class="sr-only">' . _sx('button', 'Delete permanently') . '</span></a>';
               echo '</form>';
            }
            echo "</span>";
         }

         echo "</div>"; // displayed_content
         echo "</div>"; //end h_content

         echo "</div>"; //end  h_info

         $timeline_index++;

         Plugin::doHook('post_show_item', ['item' => $obj, 'options' => $options]);

      } // end foreach timeline

      echo "<div class='break'></div>";

      // recall content
      echo "<div class='h_item middle'>";

      echo "<div class='h_info'>";
      echo "<div class='h_date'><i class='far fa-clock'></i>".Html::convDateTime($this->fields['date'])."</div>";
      echo "<div class='h_user'>";

      $user = new User();
      $display_requester = false;
      $requesters = $this->getUsers(CommonITILActor::REQUESTER);
      if (count($requesters) === 1) {
         $requester = reset($requesters);
         if ($requester['users_id'] > 0) {
            // Display requester identity only if there is only one requester
            // and only if it is not an anonymous user
            $display_requester = $user->getFromDB($requester['users_id']);
         }
      }

      echo "<div class='tooltip_picture_border'>";
      $picture = "";
      if ($display_requester && isset($user->fields['picture'])) {
         $picture = $user->fields['picture'];
      }
      echo "<img class='user_picture' alt=\"".__s('Picture')."\" src='".
      User::getThumbnailURLForPicture($picture)."'>";
      echo "</div>";

      if ($display_requester) {
         echo $user->getLink()."&nbsp;";
         $reqdata = getUserName($user->getID(), 2);
         echo Html::showToolTip(
            $reqdata["comment"],
            Session::getCurrentInterface() != 'helpdesk' ? ['link' => $reqdata['link']] : []
         );
      } else {
         echo _n('Requester', 'Requesters', count($requesters));
      }

      echo "</div>"; // h_user
      echo "</div>"; //h_info

      echo "<div class='h_content ITILContent'>";
      echo "<div class='displayed_content'>";
      echo "<div class='b_right'>";

      if ($objType == 'Ticket') {
         $result = $DB->request([
            'SELECT' => ['id', 'itemtype', 'items_id'],
            'FROM'   => ITILFollowup::getTable(),
            'WHERE'  => [
               'sourceof_items_id'  => $this->fields['id'],
               'itemtype'           => static::getType()
            ]
         ])->next();
         if ($result) {
            echo Html::link(
               '',
               static::getFormURLWithID($result['items_id']) . '&forcetab=Ticket$1#viewitemitilfollowup' . $result['id'], [
                  'class' => 'fa fa-code-branch control_item disabled',
                  'title' => __('Followup promotion source')
               ]
            );
         }
      }
      echo sprintf(__($objType."# %s description"), $this->getID());
      echo "</div>";

      echo "<div class='title'>";
      echo Html::setSimpleTextContent($this->fields['name']);
      echo "</div>";

      echo "<div class='rich_text_container'>";
      $richtext = Html::setRichTextContent('', $this->fields['content'], '', true);
      $richtext = Html::replaceImagesByGallery($richtext);
      echo $richtext;
      echo "</div>";

      echo "</div>"; // h_content ITILContent

      echo "</div>"; // .displayed_content
      echo "</div>"; // h_item middle

      echo "<div class='break'></div>";

      // end timeline
      echo "</div>"; // h_item $user_position
      echo "<script type='text/javascript'>$(function() {read_more();});</script>";
   }


   /**
    * @since 9.4.0
    *
    * @param CommonDBTM $item The item whose form should be shown
    * @param integer $id ID of the item
    * @param mixed[] $params Array of extra parameters
    *
    * @return void
    */
   static function showSubForm(CommonDBTM $item, $id, $params) {

      if ($item instanceof Document_Item) {
         Document_Item::showAddFormForItem($params['parent'], '');

      } else if (method_exists($item, "showForm")
                 && $item->can(-1, CREATE, $params)) {
         $item->showForm($id, $params);
      }
   }


   function showFormHeader($options = []) {
      $ID   = $this->fields['id'];
      $rand = mt_rand();

      if (!isset($options['template_preview']) || !$options['template_preview']) {
         $output = "<form method='post' name='form_ticket' enctype='multipart/form-data' action='".static::getFormURL()."'";
         if ($ID) {
            $output .= " data-track-changes='true'";
         }
         $output .= '>';
         echo $output;

         if (isset($options['_projecttasks_id'])) {
            echo "<input type='hidden' name='_projecttasks_id' value='".$options['_projecttasks_id']."'>";
         }
         if (isset($this->fields['_tasktemplates_id'])) {
            foreach ($this->fields['_tasktemplates_id'] as $tasktemplates_id) {
               echo "<input type='hidden' name='_tasktemplates_id[]' value='$tasktemplates_id'>";
            }
         }
      }
      echo "<div class='spaced' id='tabsbody'>";

      echo "<table class='tab_cadre_fixe' id='mainformtable'>";

      // Optional line
      $ismultientities = Session::isMultiEntitiesMode();
      echo "<tr class='headerRow responsive_hidden'>";
      echo "<th colspan='4'>";

      if ($ID) {
         $text = sprintf(__('%1$s - ID %2$d'), $this->getTypeName(1), $ID);
         if ($ismultientities) {
            $text = sprintf(__('%1$s (%2$s)'), $text,
                            Dropdown::getDropdownName('glpi_entities',
                                                      $this->fields['entities_id']));
         }
         echo $text;
      } else {
         if ($ismultientities) {
            echo sprintf(
               //TRANS first parameter is the type name, second the entity name
               __('%1$s will be added in entity %2$s'),
               static::getTypeName(1),
               Dropdown::getDropdownName("glpi_entities", $this->fields['entities_id'])
            );
         } else {
            echo sprintf(
               __('New %s'),
               static::getTypeName(1)
            );
         }
      }

      if ($this->maybeRecursive()) {
         echo "&nbsp;<label for='dropdown_is_recursive$rand'>".__('Child entities')."</label>&nbsp;";
         Dropdown::showYesNo("is_recursive", $this->fields["is_recursive"], -1, ['rand' => $rand]);
      }
      echo "</th>";
      echo "</tr>";

      Plugin::doHook("pre_item_form", ['item' => $this, 'options' => &$options]);
   }

   /**
    * Summary of getITILActors
    * Get the list of actors for the current Change
    * will return an assoc array of users_id => array of roles.
    *
    * @since 9.4.0
    *
    * @return array[] of array[] of users and roles
    */
   public function getITILActors() {
      global $DB;

      $users_table = $this->getTable() . '_users';
      switch ($this->getType()) {
         case 'Ticket':
            $groups_table = 'glpi_groups_tickets';
            break;
         case 'Problem':
            $groups_table = 'glpi_groups_problems';
            break;
         default:
            $groups_table = $this->getTable() . '_groups';
            break;
      }
      $fk = $this->getForeignKeyField();

      $subquery1 = new \QuerySubQuery([
         'SELECT'    => [
            'usr.id AS users_id',
            'tu.type AS type'
         ],
         'FROM'      => "$users_table AS tu",
         'LEFT JOIN' => [
            User::getTable() . ' AS usr' => [
               'ON' => [
                  'tu'  => 'users_id',
                  'usr' => 'id'
               ]
            ]
         ],
         'WHERE'     => [
            "tu.$fk" => $this->getID()
         ]
      ]);

      $subquery2 = new \QuerySubQuery([
         'SELECT'    => [
            'usr.id AS users_id',
            'gt.type AS type'
         ],
         'FROM'      => "$groups_table AS gt",
         'LEFT JOIN' => [
            Group_User::getTable() . ' AS gu'   => [
               'ON' => [
                  'gu'  => 'groups_id',
                  'gt'  => 'groups_id'
               ]
            ],
            User::getTable() . ' AS usr'        => [
               'ON' => [
                  'gu'  => 'users_id',
                  'usr' => 'id'
               ]
            ]
         ],
         'WHERE'     => [
            "gt.$fk" => $this->getID()
         ]
      ]);

      $union = new \QueryUnion([$subquery1, $subquery2], false, 'allactors');
      $iterator = $DB->request([
         'SELECT'          => [
            'users_id',
            'type'
         ],
         'DISTINCT'        => true,
         'FROM'            => $union
      ]);

      $users_keys = [];
      while ($current_tu = $iterator->next()) {
         $users_keys[$current_tu['users_id']][] = $current_tu['type'];
      }

      return $users_keys;
   }


   /**
    * Number of followups of the object
    *
    * @param boolean $with_private true : all followups / false : only public ones (default 1)
    *
    * @return integer followup count
   **/
   function numberOfFollowups($with_private = true) {
      global $DB;

      $RESTRICT = [];
      if ($with_private !== true) {
         $RESTRICT['is_private'] = 0;
      }

      // Set number of followups
      $result = $DB->request([
         'COUNT'  => 'cpt',
         'FROM'   => 'glpi_itilfollowups',
         'WHERE'  => [
            'itemtype'  => $this->getType(),
            'items_id'  => $this->fields['id']
         ] + $RESTRICT
      ])->next();

      return $result['cpt'];
   }

   /**
    * Number of tasks of the object
    *
    * @param boolean $with_private true : all followups / false : only public ones (default 1)
    *
    * @return integer
   **/
   function numberOfTasks($with_private = true) {
      global $DB;

      $table = 'glpi_' . strtolower($this->getType()) . 'tasks';

      $RESTRICT = [];
      if ($with_private !== true && $this->getType() == 'Ticket') {
         //No private tasks for Problems and Changes
         $RESTRICT['is_private'] = 0;
      }

      // Set number of tasks
      $row = $DB->request([
         'COUNT'  => 'cpt',
         'FROM'   => $table,
         'WHERE'  => [
            $this->getForeignKeyField()   => $this->fields['id']
         ] + $RESTRICT
      ])->next();
      return (int)$row['cpt'];
   }

   /**
    * Check if input contains a flag set to prevent 'takeintoaccount' delay computation.
    *
    * @param array $input
    *
    * @return boolean
    */
   public function isTakeIntoAccountComputationBlocked($input) {
      return array_key_exists('_do_not_compute_takeintoaccount', $input)
         && $input['_do_not_compute_takeintoaccount'];
   }


   /**
    * Check if input contains a flag set to prevent status computation.
    *
    * @param array $input
    *
    * @return boolean
    */
   public function isStatusComputationBlocked(array $input) {
      return array_key_exists('_do_not_compute_status', $input)
         && $input['_do_not_compute_status'];
   }


   /**
    * Define manually current tabs to set specific order
    *
    * @param array &$tab    Tab array passed as reference
    * @param array $options Options
    *
    * @return CommonITILObject
    */
   protected function defineDefaultObjectTabs(array &$tab, array $options) {
      $withtemplate = 0;
      if (isset($options['withtemplate'])) {
         $withtemplate = $options['withtemplate'];
      }

      //timeline first, then main, then the rest?
      $local_tabs = $this->getTabNameForItem($this, $withtemplate);
      if (is_array($local_tabs)) {
         foreach ($local_tabs as $key => $val) {
            if (!empty($val)) {
               $tab[static::class . '$' . $key] = $val;
            }

            if (1 === count($tab)) {
               $tab[$this->getType().'$main'] = $this->getTypeName(1);
            }
         }
      }

      return $this;
   }


   /**
    * @see CommonGLPI::getAdditionalMenuOptions()
    *
    * @since 0.85
   **/
   static function getAdditionalMenuOptions() {
      $tplclass = self::getTemplateClass();
      if ($tplclass::canView()) {
         $menu = [
            $tplclass => [
               'title' => $tplclass::getTypeName(Session::getPluralNumber()),
               'page'  => $tplclass::getSearchURL(false),
               'icon'  => $tplclass::getIcon(),
               'links' => [
                  'search' => $tplclass::getSearchURL(false),
               ],
            ],
         ];

         if ($tplclass::canCreate()) {
            $menu[$tplclass]['links']['add'] = $tplclass::getFormURL(false);
         }
         return $menu;
      }
      return false;
   }


   /**
    * @see CommonGLPI::getAdditionalMenuLinks()
    *
    * @since 9.5.0
   **/
   static function getAdditionalMenuLinks() {
      $links = [];
      $tplclass = self::getTemplateClass();
      if ($tplclass::canView()) {
         $links['template'] = $tplclass::getSearchURL(false);
      }

      return $links;
   }


   /**
    * Get template to use
    * Use force_template first, then try on template define for type and category
    * then use default template of active profile of connected user and then use default entity one
    *
    * @param integer      $force_template     itiltemplate_id to use (case of preview for example)
    * @param integer|null $type               type of the ticket
    *                                         (use Ticket::INCIDENT_TYPE or Ticket::DEMAND_TYPE constants value)
    * @param integer      $itilcategories_id  ticket category
    * @param integer      $entities_id
    *
    * @return ITILTemplate
    *
    * @since 9.5.0
   **/
   function getITILTemplateToUse(
      $force_template = 0,
      $type = null,
      $itilcategories_id = 0,
      $entities_id = -1
   ) {
      if (!$type && $this->getType() != Ticket::getType()) {
         $type = true;
      }
      // Load template if available :
      $tplclass = static::getTemplateClass();
      $tt              = new $tplclass();
      $template_loaded = false;

      if ($force_template) {
         // with type and categ
         if ($tt->getFromDBWithData($force_template, true)) {
            $template_loaded = true;
         }
      }

      if (!$template_loaded
          && $type
          && $itilcategories_id) {

         $categ = new ITILCategory();
         if ($categ->getFromDB($itilcategories_id)) {
            $field = $this->getTemplateFieldName($type);

            if (!empty($categ->fields[$field]) && $categ->fields[$field]) {
               // without type and categ
               if ($tt->getFromDBWithData($categ->fields[$field], false)) {
                  $template_loaded = true;
               }
            }
         }
      }

      // If template loaded from type and category do not check after
      if ($template_loaded) {
         return $tt;
      }

      //Get template from profile
      if (!$template_loaded && $type) {
         $field = $this->getTemplateFieldName($type);
         $field = str_replace(['_incident', '_demand'], ['', ''], $field);
         // load default profile one if not already loaded
         if (isset($_SESSION['glpiactiveprofile'][$field])
            && $_SESSION['glpiactiveprofile'][$field]) {
            // with type and categ
            if ($tt->getFromDBWithData($_SESSION['glpiactiveprofile'][$field],
                                       true)) {
               $template_loaded = true;
            }
         }
      }

      //Get template from entity
      if (!$template_loaded
         && ($entities_id >= 0)) {
         // load default entity one if not already loaded
         if ($template_id = Entity::getUsedConfig(strtolower($this->getType()).'templates_id', $entities_id)) {
            // with type and categ
            if ($tt->getFromDBWithData($template_id, true)) {
               $template_loaded = true;
            }
         }
      }

      // Check if profile / entity set type and category and try to load template for these values
      if ($template_loaded) { // template loaded for profile or entity
         $newtype              = $type;
         $newitilcategories_id = $itilcategories_id;
         // Get predefined values for ticket template
         if (isset($tt->predefined['itilcategories_id']) && $tt->predefined['itilcategories_id']) {
            $newitilcategories_id = $tt->predefined['itilcategories_id'];
         }
         if (isset($tt->predefined['type']) && $tt->predefined['type']) {
            $newtype = $tt->predefined['type'];
         }
         if ($newtype
             && $newitilcategories_id) {

            $categ = new ITILCategory();
            if ($categ->getFromDB($newitilcategories_id)) {
               $field = $this->getTemplateFieldName($newtype);

               if (isset($categ->fields[$field]) && $categ->fields[$field]) {
                  // without type and categ
                  if ($tt->getFromDBWithData($categ->fields[$field], false)) {
                     $template_loaded = true;
                  }
               }
            }
         }
      }
      return $tt;
   }

   /**
    * Get template field name
    *
    * @param string $type Type, if any
    *
    * @return string
    */
   public function getTemplateFieldName($type = null) :string {
      $field = strtolower(static::getType()) . 'templates_id';
      if (static::getType() === Ticket::getType()) {
         switch ($type) {
            case Ticket::INCIDENT_TYPE:
               $field .= '_incident';
               break;

            case Ticket::DEMAND_TYPE:
               $field .= '_demand';
               break;

            case true:
               //for changes and problem, or from profiles
               break;

            default:
               $field = '';
               trigger_error('Missing type for Ticket template!', E_USER_WARNING);
               break;
         }
      }

      return $field;
   }

   /**
    * @since 9.5.0
    *
    * @param integer $entity entities_id usefull if function called by cron (default 0)
   **/
   abstract static function getDefaultValues($entity = 0);

   /**
    * Get template class name.
    *
    * @since 9.5.0
    *
    * @return string
    */
   public static function getTemplateClass() {
      return static::getType() . 'Template';
   }

   /**
    * Get template form field name
    *
    * @since 9.5.0
    *
    * @return string
    */
   public static function getTemplateFormFieldName() {
      return '_' . strtolower(static::getType()) . 'template';
   }

   /**
    * Get common request criteria
    *
    * @since 9.5.0
    *
    * @return array
    */
   public static function getCommonCriteria() {
      $fk = self::getForeignKeyField();
      $gtable = str_replace('glpi_', 'glpi_groups_', static::getTable());
      $itable = str_replace('glpi_', 'glpi_items_', static::getTable());
      if (self::getType() == 'Change') {
         $gtable = 'glpi_changes_groups';
         $itable = 'glpi_changes_items';
      }
      $utable = static::getTable() . '_users';
      $stable = static::getTable() . '_suppliers';
      if (self::getType() == 'Ticket') {
         $stable = 'glpi_suppliers_tickets';
      }
      $table = static::getTable();
      $criteria = [
         'SELECT'          => [
            "$table.*",
            'glpi_itilcategories.completename AS catname'
         ],
         'DISTINCT'        => true,
         'FROM'            => $table,
         'LEFT JOIN'       => [
            $gtable  => [
               'ON' => [
                  $table   => 'id',
                  $gtable  => $fk
               ]
            ],
            $utable  => [
               'ON' => [
                  $table   => 'id',
                  $utable  => $fk
               ]
            ],
            $stable  => [
               'ON' => [
                  $table   => 'id',
                  $stable  => $fk
               ]
            ],
            'glpi_itilcategories'      => [
               'ON' => [
                  $table                  => 'itilcategories_id',
                  'glpi_itilcategories'   => 'id'
               ]
            ],
            $itable  => [
               'ON' => [
                  $table   => 'id',
                  $itable  => $fk
               ]
            ]
         ],
         'ORDERBY'            => "$table.date_mod DESC"
      ];
      if (count($_SESSION["glpiactiveentities"]) > 1) {
         $criteria['LEFT JOIN']['glpi_entities'] = [
            'ON' => [
               'glpi_entities'   => 'id',
               $table            => 'entities_id'
            ]
         ];
         $criteria['SELECT'] = array_merge(
            $criteria['SELECT'], [
               'glpi_entities.completename AS entityname',
               "$table.entities_id AS entityID"
            ]
         );
      }
      return $criteria;
   }

   public function getForbiddenSingleMassiveActions() {
      $excluded = parent::getForbiddenSingleMassiveActions();

      if (isset($this->fields['global_validation']) && $this->fields['global_validation'] != CommonITILValidation::NONE) {
         //a validation has already been requested/done
         $excluded[] = 'TicketValidation:submit_validation';
      }
      return $excluded;
   }

   /**
    * Returns criteria that can be used to get documents related to current instance.
    *
    * @return array
    */
   public function getAssociatedDocumentsCriteria($bypass_rights = false): array {
      $task_class = $this->getType() . 'Task';

      $or_crits = [
         // documents associated to ITIL item directly
         [
            Document_Item::getTableField('itemtype') => $this->getType(),
            Document_Item::getTableField('items_id') => $this->getID(),
         ],
      ];

      // documents associated to followups
      if ($bypass_rights || ITILFollowup::canView()) {
         $fup_crits = [
            ITILFollowup::getTableField('itemtype') => $this->getType(),
            ITILFollowup::getTableField('items_id') => $this->getID(),
         ];
         if (!$bypass_rights && !Session::haveRight(ITILFollowup::$rightname, ITILFollowup::SEEPRIVATE)) {
            $fup_crits[] = [
               'OR' => ['is_private' => 0, 'users_id' => Session::getLoginUserID()],
            ];
         }
         $or_crits[] = [
            Document_Item::getTableField('itemtype') => ITILFollowup::getType(),
            Document_Item::getTableField('items_id') => new QuerySubQuery(
               [
                  'SELECT' => 'id',
                  'FROM'   => ITILFollowup::getTable(),
                  'WHERE'  => $fup_crits,
               ]
            ),
         ];
      }

      // documents associated to solutions
      if (ITILSolution::canView()) {
         $or_crits[] = [
            Document_Item::getTableField('itemtype') => ITILSolution::getType(),
            Document_Item::getTableField('items_id') => new QuerySubQuery(
               [
                  'SELECT' => 'id',
                  'FROM'   => ITILSolution::getTable(),
                  'WHERE'  => [
                     ITILSolution::getTableField('itemtype') => $this->getType(),
                     ITILSolution::getTableField('items_id') => $this->getID(),
                  ],
               ]
            ),
         ];
      }

      // documents associated to tasks
      if ($bypass_rights || $task_class::canView()) {
         $tasks_crit = [
            $this->getForeignKeyField() => $this->getID(),
         ];
         if (!$bypass_rights && !Session::haveRight($task_class::$rightname, CommonITILTask::SEEPRIVATE)) {
            $tasks_crit[] = [
               'OR' => ['is_private' => 0, 'users_id' => Session::getLoginUserID()],
            ];
         }
         $or_crits[] = [
            'glpi_documents_items.itemtype' => $task_class::getType(),
            'glpi_documents_items.items_id' => new QuerySubQuery(
               [
                  'SELECT' => 'id',
                  'FROM'   => $task_class::getTable(),
                  'WHERE'  => $tasks_crit,
               ]
            ),
         ];
      }

      return ['OR' => $or_crits];
   }

   /**
    * Check if this item is new
    *
    * @return bool
    */
   protected function isNew() {
      if (isset($this->input['status'])) {
         $status = $this->input['status'];
      } else if (isset($this->fields['status'])) {
         $status = $this->fields['status'];
      } else {
         throw new LogicException("Can't get status value: no object loaded");
      }

      return $status == CommonITILObject::INCOMING;
   }

   /**
    * Retrieve linked items table name
    *
    * @since 9.5.0
    *
    * @return string
    */
   public static function getItemsTable() {
      switch (static::getType()) {
         case 'Change':
            return 'glpi_changes_items';
         case 'Problem':
            return 'glpi_items_problems';
         case 'Ticket':
            return 'glpi_items_tickets';
         default:
            throw new \RuntimeException('Unknown ITIL type ' . static::getType());
      }

   }


   public function getLinkedItems() :array {
      global $DB;

      $assets = $DB->request([
         'SELECT' => ["itemtype", "items_id"],
         'FROM'   => static::getItemsTable(),
         'WHERE'  => [$this->getForeignKeyField() => $this->getID()]
      ]);

      $assets = iterator_to_array($assets);

      $tab = [];
      foreach ($assets as $asset) {
         if (!class_exists($asset['itemtype'])) {
            //ignore if class does not exists (maybe a plugin)
            continue;
         }
         $tab[$asset['itemtype']][$asset['items_id']] = $asset['items_id'];
      }

      return $tab;
   }

   /**
    * Should impact tab be displayed? Check if there is a valid linked item
    *
    * @return boolean
    */
   protected function hasImpactTab() {
      foreach ($this->getLinkedItems() as $itemtype => $items) {
         $class = $itemtype;
         if (Impact::isEnabled($class) && Session::getCurrentInterface() === "central") {
            return true;
         }
      }
      return false;
   }

   /**
    * Get criteria needed to match objets with an "open" status (= not resolved
    * or closed)
    *
    * @return array
    */
   public static function getOpenCriteria(): array {
      $table = static::getTable();

      return [
         'NOT' => [
            "$table.status" => array_merge(
               static::getSolvedStatusArray(),
               static::getClosedStatusArray()
            )
         ]
      ];
   }

   public function displayHiddenItemsIdInput(array $options): void {
      $input_items_id = $options['items_id'] ?? [];

      if (empty($input_items_id)) {
         return;
      }

      foreach ($input_items_id as $itemtype => $items) {
         foreach ($items as $items_id) {
            echo "<input type='hidden' name='items_id[$itemtype][$items_id]' value='$items_id'>";
         }
      }
   }

   public function handleItemsIdInput(): void {
      if (!empty($this->input['items_id'])) {
         $item_link_class = static::getItemLinkClass();
         $item_link = new $item_link_class();
         foreach ($this->input['items_id'] as $itemtype => $items) {
            foreach ($items as $items_id) {
               $item_link->add([
                  'items_id'                    => $items_id,
                  'itemtype'                    => $itemtype,
                  static::getForeignKeyField()  => $this->fields['id'],
                  '_disablenotif'               => true
               ]);
            }
         }
      }
   }

   abstract public static function getItemLinkClass(): string;

   protected function handleFileUploadField(ITILTemplate $template, array $options = []): void {
      $options = array_replace([
         'colwidth' => 13,
      ], $options);

      if (!in_array($this->fields['status'], $this->getClosedStatusArray())) {
         // View files added
         echo "<tr class='tab_bg_1'>";
         // Permit to add doc when creating a ticket
         echo "<th style='width:{$options['colwidth']}%'>";
         echo $template->getBeginHiddenFieldText('_documents_id');
         $doctitle =  sprintf(__('File (%s)'), Document::getMaxUploadSize());
         printf(__('%1$s%2$s'), $doctitle, $template->getMandatoryMark('_documents_id'));
         // Do not show if hidden.
         if (!$template->isHiddenField('_documents_id')) {
            DocumentType::showAvailableTypesLink();
         }
         echo $template->getEndHiddenFieldText('_documents_id');
         echo "</th>";
         echo "<td colspan='3'>";
         // Do not set values
         echo $template->getEndHiddenFieldValue('_documents_id');
         if ($template->isPredefinedField('_documents_id')) {
            if (isset($options['_documents_id'])
               && is_array($options['_documents_id'])
               && count($options['_documents_id'])) {

               echo "<span class='b'>".__('Default documents:').'</span>';
               echo "<br>";
               $doc = new Document();
               foreach ($options['_documents_id'] as $key => $val) {
                  if ($doc->getFromDB($val)) {
                     echo "<input type='hidden' name='_documents_id[$key]' value='$val'>";
                     echo "- ".$doc->getNameID()."<br>";
                  }
               }
            }
         }
         if (!$template->isHiddenField('_documents_id')) {
            $uploads = [];
            if (isset($this->input['_filename'])) {
               $uploads['_filename'] = $this->input['_filename'];
               $uploads['_tag_filename'] = $this->input['_tag_filename'];
            }
            Html::file([
               'filecontainer' => 'fileupload_info_'.(strtolower(static::class)),
               'showtitle'     => false,
               'multiple'      => true,
               'uploads'       => $uploads,
            ]);
         }
         echo "</td>";
         echo "</tr>";
      }
   }

   function canReopen() {
      return false;
   }

}
