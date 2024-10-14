<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class GroupsTicketsMigration extends AbstractMigration
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
    $item = $this->table('group_ticket');

    if ($this->isMigratingUp())
    {
      $nbRows = $pdo->query('SELECT count(*) FROM glpi_groups_tickets')->fetchColumn();
      $nbLoops = ceil($nbRows / 20000);

      for ($i = 0; $i < $nbLoops; $i++) {
        $stmt = $pdo->query('SELECT * FROM glpi_groups_tickets ORDER BY id LIMIT 20000 OFFSET ' . ($i * 20000));

        $rows = $stmt->fetchAll();
        foreach ($rows as $row)
        {
          $data = [
            [
              'id'        => $row['id'],
              'ticket_id' => $row['tickets_id'],
              'group_id'  => $row['groups_id'],
              'type'      => $row['type'],
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
