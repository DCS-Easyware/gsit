<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class TicketrecurrentsMigration extends AbstractMigration
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
    $item = $this->table('ticketrecurrents');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_ticketrecurrents');
      $rows = $stmt->fetchAll();
      foreach ($rows as $row)
      {
        $data = [
          [
            'id'                  => $row['id'],
            'name'                => $row['name'],
            'comment'             => $row['comment'],
            'entity_id'           => $row['entities_id'],
            'is_recursive'        => $row['is_recursive'],
            'is_active'           => $row['is_active'],
            'tickettemplate_id'   => $row['tickettemplates_id'],
            'begin_date'          => $row['begin_date'],
            'periodicity'         => $row['periodicity'],
            'create_before'       => $row['create_before'],
            'next_creation_date'  => $row['next_creation_date'],
            'calendar_id'         => $row['calendars_id'],
            'end_date'            => $row['end_date'],
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
