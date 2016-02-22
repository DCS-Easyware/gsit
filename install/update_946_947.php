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

/**
 * Update from 9.4.6 to 9.4.7
 *
 * @return bool for success (will die for most error)
 **/
function update946to947() {
   global $DB, $migration;

   $updateresult     = true;

   //TRANS: %s is the number of new version
   $migration->displayTitle(sprintf(__('Update to %s'), '9.4.7'));
   $migration->setVersion('9.4.7');

   $DB->updateOrDie('glpi_events', ['type'   => 'dcrooms'], ['type' => 'serverroms']);

   /**************SAML authentication ************ */
   if (!$DB->tableExists('glpi_authsamls')) {
      $query = "CREATE TABLE `glpi_authsamls` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `sp_entityid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `sp_assertionconsumerservice_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `sp_assertionconsumerservice_binding` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `sp_singlelogoutservice_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `sp_singlelogoutservice_binding` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `sp_nameidformat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `idp_entityid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `idp_singlesignonservice_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `idp_singlesignonservice_binding` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `idp_singlelogoutservice_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `idp_singlelogoutservice_binding` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `idp_certfingerprint` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `idp_certfingerprintalgorithm` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `date_mod` datetime DEFAULT NULL,
                  `comment` text COLLATE utf8_unicode_ci,
                  `is_active` tinyint(1) NOT NULL DEFAULT '0',
                  PRIMARY KEY (`id`),
                  KEY `date_mod` (`date_mod`),
                  KEY `is_active` (`is_active`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
      $DB->queryOrDie($query, "9.4 add table glpi_authsamls");
      $DB->queryOrDie("INSERT INTO `glpi_authsamls` (`id`, `sp_entityid`, `sp_assertionconsumerservice_url`, `sp_assertionconsumerservice_binding`, `sp_singlelogoutservice_url`, `sp_singlelogoutservice_binding`, `sp_nameidformat`, `idp_entityid`, `idp_singlesignonservice_url`) VALUES (1, 'https://glpi/index.php', 'https://glpi/front/login.php', 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST', 'https://glpi/front/logout.php', 'urn:oasis:names:tc:SAML:2.0:bindings:HTTP-Redirect', 'urn:oasis:names:tc:SAML:1.1:nameid-format:emailAddress', 'http://adfs.test.local/adfs/services/trust', 'https://adfs.test.local/adfs/ls/IdpInitiatedSignon.aspx');");
   }
   if (!$DB->tableExists('glpi_authmappings')) {
      $query = "CREATE TABLE `glpi_authmappings` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `itemtype` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
                  `items_id` int(11) NOT NULL DEFAULT '0',
                  `remotefield` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  `userfield` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
      $DB->queryOrDie($query, "9.4 add table glpi_authmappings");
   }


   // ************ Keep it at the end **************
   $migration->executeMigration();

   return $updateresult;
}
