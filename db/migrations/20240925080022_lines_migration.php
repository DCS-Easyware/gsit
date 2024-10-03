<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class LinesMigration extends AbstractMigration
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
    $item = $this->table('lines');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_lines');
      $rows = $stmt->fetchAll();
      foreach ($rows as $row)
      {
        $data = [
          [
            'id'              => $row['id'],
            'name'            => $row['name'],
            'comment'         => $row['comment'],
            'entity_id'       => $row['entities_id'],
            'is_recursive'    => $row['is_recursive'],
            'is_deleted'      => $row['is_deleted'],
            'caller_num'      => $row['caller_num'],
            'caller_name'     => $row['caller_name'],
            'user_id'         => $row['users_id'],
            'group_id'        => $row['groups_id'],
            'lineoperator_id' => $row['lineoperators_id'],
            'location_id'     => $row['locations_id'],
            'state_id'        => $row['states_id'],
            'linetype_id'     => $row['linetypes_id'],
            'updated_at'      => $row['date_mod'],
            'created_at'      => $row['date_creation'],
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
