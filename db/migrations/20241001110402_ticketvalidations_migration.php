<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class TicketvalidationsMigration extends AbstractMigration
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
    $item = $this->table('ticketvalidations');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_ticketvalidations');
      $rows = $stmt->fetchAll();
      foreach ($rows as $row)
      {
        $data = [
          [
            'id'                  => $row['id'],
            'entity_id'           => $row['entities_id'],
            'user_id'             => $row['users_id'],
            'ticket_id'           => $row['tickets_id'],
            'user_id_validate'    => $row['users_id_validate'],
            'comment_submission'  => $row['comment_submission'],
            'comment_validation'  => $row['comment_validation'],
            'status'              => $row['status'],
            'submission_date'     => $row['submission_date'],
            'validation_date'     => $row['validation_date'],
            'timeline_position'   => $row['timeline_position'],
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
