<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class RulesMigration extends AbstractMigration
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
    $item = $this->table('rules');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_rules');
      $rows = $stmt->fetchAll();
      foreach ($rows as $row)
      {
        $data = [
          [
            'id'            => $row['id'],
            'entity_id'     => $row['entities_id'],
            'sub_type'      => $row['sub_type'],
            'ranking'       => $row['ranking'],
            'name'          => $row['name'],
            'description'   => $row['description'],
            'match'         => $row['match'],
            'is_active'     => $row['is_active'],
            'comment'       => $row['comment'],
            'updated_at'    => $row['date_mod'],
            'is_recursive'  => $row['is_recursive'],
            'uuid'          => $row['uuid'],
            'condition'     => $row['condition'],
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
