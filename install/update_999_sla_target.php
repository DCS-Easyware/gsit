<?php
/*
 * @version $Id: update_085_0853.php 23433 2015-04-09 12:07:57Z moyo $
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2014 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

/** @file
* @brief
*/

/**
 * Update from 0.85 to 0.85.3
 *
 * @return bool for success (will die for most error)
**/
function update999SlaTarget() {
   global $DB;

   if (!TableExists('glpi_entities_slas')) {
      $query = "CREATE TABLE `glpi_entities_slas` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `slas_id` int(11) NOT NULL DEFAULT '0',
          `entities_id` int(11) NOT NULL DEFAULT '0',
          `is_recursive` tinyint(1) NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`),
          KEY `slas_id` (`slas_id`),
          KEY `entities_id` (`entities_id`),
          KEY `is_recursive` (`is_recursive`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
      $DB->queryOrDie($query, "add table glpi_entities_slas");
   }

   if (!TableExists('glpi_groups_slas')) {
      $query = "CREATE TABLE `glpi_groups_slas` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `slas_id` int(11) NOT NULL DEFAULT '0',
            `groups_id` int(11) NOT NULL DEFAULT '0',
            `entities_id` int(11) NOT NULL DEFAULT '-1',
            `is_recursive` tinyint(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            KEY `slas_id` (`slas_id`),
            KEY `groups_id` (`groups_id`),
            KEY `entities_id` (`entities_id`),
            KEY `is_recursive` (`is_recursive`)
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
      $DB->queryOrDie($query, "add table glpi_groups_slas");
   }

   if (!TableExists('glpi_slas_profiles')) {
      $query = "CREATE TABLE `glpi_slas_profiles` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `slas_id` int(11) NOT NULL DEFAULT '0',
        `profiles_id` int(11) NOT NULL DEFAULT '0',
        `entities_id` int(11) NOT NULL DEFAULT '-1',
        `is_recursive` tinyint(1) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`),
        KEY `slas_id` (`slas_id`),
        KEY `profiles_id` (`profiles_id`),
        KEY `entities_id` (`entities_id`),
        KEY `is_recursive` (`is_recursive`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
      $DB->queryOrDie($query, "add table glpi_slas_profiles");
   }

   if (!TableExists('glpi_slas_users')) {
      $query = "CREATE TABLE `glpi_slas_users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `slas_id` int(11) NOT NULL DEFAULT '0',
        `users_id` int(11) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`),
        KEY `slas_id` (`slas_id`),
        KEY `users_id` (`users_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
      $DB->queryOrDie($query, "add table glpi_slas_users");
   }

}

?>