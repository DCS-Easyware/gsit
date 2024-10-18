<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class TicketsUsersMigration extends AbstractMigration
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
    $item = $this->table('ticket_user');

    if ($this->isMigratingUp())
    {
      $nbRows = $pdo->query('SELECT count(*) FROM glpi_tickets_users')->fetchColumn();
      $nbLoops = ceil($nbRows / 20000);

      for ($i = 0; $i < $nbLoops; $i++) {
        $stmt = $pdo->query('SELECT * FROM glpi_tickets_users ORDER BY id LIMIT 20000 OFFSET ' . ($i * 20000));

        $rows = $stmt->fetchAll();
        foreach ($rows as $row)
        {
          $data = [
            [
              'id'                => $row['id'],
              'ticket_id'         => $row['tickets_id'],
              'user_id'           => $row['users_id'],
              'type'              => $row['type'],
              'use_notification'  => $row['use_notification'],
              'alternative_email' => $row['alternative_email'],
            ]
          ];

          $item->insert($data)
              ->saveData();
        }
      }
    } else {
      // rollback
      $item->truncate();
    }
  }
}
