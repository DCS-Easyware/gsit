<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class NetworkequipmentsMigration extends AbstractMigration
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
    $item = $this->table('networkequipments');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_networkequipments');
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
            'ram'                       => $row['ram'],
            'serial'                    => $row['serial'],
            'otherserial'               => $row['otherserial'],
            'contact'                   => $row['contact'],
            'contact_num'               => $row['contact_num'],
            'user_id_tech'              => $row['users_id_tech'],
            'group_id_tech'             => $row['groups_id_tech'],
            'location_id'               => $row['locations_id'],
            'network_id'                => $row['networks_id'],
            'networkequipmenttype_id'   => $row['networkequipmenttypes_id'],
            'networkequipmentmodel_id'  => $row['networkequipmentmodels_id'],
            'manufacturer_id'           => $row['manufacturers_id'],
            'is_deleted'                => $row['is_deleted'],
            'is_template'               => $row['is_template'],
            'template_name'             => $row['template_name'],
            'user_id'                   => $row['users_id'],
            'group_id'                  => $row['groups_id'],
            'state_id'                  => $row['states_id'],
            'ticket_tco'                => $row['ticket_tco'],
            'is_dynamic'                => $row['is_dynamic'],
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
