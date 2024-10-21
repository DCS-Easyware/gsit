<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class RemindersMigration extends AbstractMigration
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
    $item = $this->table('reminders');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_reminders');
      $rows = $stmt->fetchAll();
      foreach ($rows as $row)
      {
        $data = [
          [
            'id'              => $row['id'],
            'uuid'            => $row['uuid'],
            'date'            => $row['date'],
            'user_id'         => $row['users_id'],
            'name'            => $row['name'],
            'text'            => $row['text'],
            'begin'           => $row['begin'],
            'end'             => $row['end'],
            'is_planned'      => $row['is_planned'],
            'updated_at'      => $row['date_mod'],
            'state'           => $row['state'],
            'begin_view_date' => $row['begin_view_date'],
            'end_view_date'   => $row['end_view_date'],
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
