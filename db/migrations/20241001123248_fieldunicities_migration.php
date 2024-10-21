<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class FieldunicitiesMigration extends AbstractMigration
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
    $item = $this->table('fieldunicities');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_fieldunicities');
      $rows = $stmt->fetchAll();
      foreach ($rows as $row)
      {
        $data = [
          [
            'id'            => $row['id'],
            'name'          => $row['name'],
            'is_recursive'  => $row['is_recursive'],
            'item_type'     => $row['itemtype'],
            'entity_id'     => $row['entities_id'],
            'fields'        => $row['fields'],
            'is_active'     => $row['is_active'],
            'action_refuse' => $row['action_refuse'],
            'action_notify' => $row['action_notify'],
            'comment'       => $row['comment'],
            'updated_at'    => $row['date_mod'],
            'created_at'    => $row['date_creation'],
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
