<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class AppliancesMigration extends AbstractMigration
{
  public function change()
  {
    $configArray = require('phinx.php');
    $environments = array_keys($configArray['environments']);
    if (in_array('old', $environments))
    {
      // Migration of database

      $config = Config::fromPhp('phinx.php');
      $environment = new Environment('old', $config->getEnvironment('old'));
      $pdo = $environment->getAdapter()->getConnection();
    } else {
      return;
    }
    $item = $this->table('appliances');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_appliances');
      $rows = $stmt->fetchAll();
      foreach ($rows as $row)
      {
        $data = [
          [
            'id'                        => $row['id'],
            'name'                      => $row['name'],
            'comment'                   => $row['comment'],
            'entity_id'                 => $row['entities_id'],
            'is_recursive'              => $row['is_recursive'],
            'is_deleted'                => $row['is_deleted'],
            'appliancetype_id'          => $row['appliancetypes_id'],
            'location_id'               => $row['locations_id'],
            'manufacturer_id'           => $row['manufacturers_id'],
            'applianceenvironment_id'   => $row['applianceenvironments_id'],
            'user_id'                   => $row['users_id'],
            'user_id_tech'              => $row['users_id_tech'],
            'group_id'                  => $row['groups_id'],
            'group_id_tech'             => $row['groups_id_tech'],
            'state_id'                  => $row['states_id'],
            'externalidentifier'        => $row['externalidentifier'],
            'serial'                    => $row['serial'],
            'otherserial'               => $row['otherserial'],
            'is_helpdesk_visible'       => $row['is_helpdesk_visible'],
            'updated_at'                => $row['date_mod'],
            'created_at'                => $row['date_creation'],
          ]
        ];
        $item->insert($data)
             ->saveData();
      }
    } else {
      // rollback
      $item->truncate();
    }
  }
}
