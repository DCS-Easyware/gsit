<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class ItemsDeviceprocessorsMigration extends AbstractMigration
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
    $item = $this->table('item_deviceprocessor');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_items_deviceprocessors');
      $rows = $stmt->fetchAll();
      foreach ($rows as $row)
      {
        $data = [
          [
            'id'                  => $row['id'],
            'item_id'             => $row['items_id'],
            'item_type'           => $row['itemtype'],
            'deviceprocessor_id'  => $row['deviceprocessors_id'],
            'frequency'           => $row['frequency'],
            'serial'              => $row['serial'],
            'is_dynamic'          => $row['is_dynamic'],
            'nbcores'             => $row['nbcores'],
            'nbthreads'           => $row['nbthreads'],
            'entity_id'           => $row['entities_id'],
            'is_recursive'        => $row['is_recursive'],
            'busID'               => $row['busID'],
            'otherserial'         => $row['otherserial'],
            'location_id'         => $row['locations_id'],
            'state_id'            => $row['states_id'],
            'deleted_at'          => self::convertIsDeleted($row['is_deleted']),
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

  public function convertIsDeleted($is_deleted) {
    if ($is_deleted == 1) {
      return date('Y-m-d H:i:s', time());
    }

    return null;
  }
}
