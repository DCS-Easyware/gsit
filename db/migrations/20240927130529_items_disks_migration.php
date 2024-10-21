<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class ItemsDisksMigration extends AbstractMigration
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
    $item = $this->table('item_disk');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_items_disks');
      $rows = $stmt->fetchAll();
      foreach ($rows as $row)
      {
        $data = [
          [
            'id'                    => $row['id'],
            'entity_id'             => $row['entities_id'],
            'item_type'             => $row['itemtype'],
            'item_id'               => $row['items_id'],
            'name'                  => $row['name'],
            'device'                => $row['device'],
            'mountpoint'            => $row['mountpoint'],
            'filesystem_id'         => $row['filesystems_id'],
            'totalsize'             => $row['totalsize'],
            'freesize'              => $row['freesize'],
            'is_dynamic'            => $row['is_dynamic'],
            'encryption_status'     => $row['encryption_status'],
            'encryption_tool'       => $row['encryption_tool'],
            'encryption_algorithm'  => $row['encryption_algorithm'],
            'encryption_type'       => $row['encryption_type'],
            'updated_at'            => $row['date_mod'],
            'created_at'            => $row['date_creation'],
            'deleted_at'            => self::convertIsDeleted($row['is_deleted']),
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
