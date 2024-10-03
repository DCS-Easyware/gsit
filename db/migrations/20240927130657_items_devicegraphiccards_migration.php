<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class ItemsDevicegraphiccardsMigration extends AbstractMigration
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
    $item = $this->table('item_devicegraphiccard');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_items_devicegraphiccards');
      $rows = $stmt->fetchAll();
      foreach ($rows as $row)
      {
        $data = [
          [
            'id'                    => $row['id'],
            'item_id'               => $row['items_id'],
            'item_type'             => $row['itemtype'],
            'devicegraphiccard_id'  => $row['devicegraphiccards_id'],
            'memory'                => $row['memory'],
            'is_deleted'            => $row['is_deleted'],
            'is_dynamic'            => $row['is_dynamic'],
            'entity_id'             => $row['entities_id'],
            'is_recursive'          => $row['is_recursive'],
            'serial'                => $row['serial'],
            'busID'                 => $row['busID'],
            'otherserial'           => $row['otherserial'],
            'location_id'           => $row['locations_id'],
            'state_id'              => $row['states_id'],
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
