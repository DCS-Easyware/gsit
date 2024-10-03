<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class ContractsMigration extends AbstractMigration
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
    $item = $this->table('contracts');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_contracts');
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
            'num'                 => $row['num'],
            'contracttype_id'     => $row['contracttypes_id'],
            'begin_date'          => $row['begin_date'],
            'duration'            => $row['duration'],
            'notice'              => $row['notice'],
            'periodicity'         => $row['periodicity'],
            'billing'             => $row['billing'],
            'accounting_number'   => $row['accounting_number'],
            'is_deleted'          => $row['is_deleted'],
            'week_begin_hour'     => $row['week_begin_hour'],
            'week_end_hour'       => $row['week_end_hour'],
            'saturday_begin_hour' => $row['saturday_begin_hour'],
            'saturday_end_hour'   => $row['saturday_end_hour'],
            'use_saturday'        => $row['use_saturday'],
            'monday_begin_hour'   => $row['monday_begin_hour'],
            'monday_end_hour'     => $row['monday_end_hour'],
            'use_monday'          => $row['use_monday'],
            'max_links_allowed'   => $row['max_links_allowed'],
            'alert'               => $row['alert'],
            'renewal'             => $row['renewal'],
            'template_name'       => $row['template_name'],
            'is_template'         => $row['is_template'],
            'state_id'            => $row['states_id'],
            'updated_at'          => $row['date_mod'],
            'created_at'          => $row['date_creation'],
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
