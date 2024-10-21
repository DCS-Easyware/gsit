<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class PassivedcequipmentsMigration extends AbstractMigration
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
    $item = $this->table('passivedcequipments');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_passivedcequipments');
      $rows = $stmt->fetchAll();
      foreach ($rows as $row)
      {
        $data = [
          [
            'id'                          => $row['id'],
            'name'                        => $row['name'],
            'entity_id'                   => $row['entities_id'],
            'is_recursive'                => $row['is_recursive'],
            'location_id'                 => $row['locations_id'],
            'serial'                      => $row['serial'],
            'otherserial'                 => $row['otherserial'],
            'passivedcequipmentmodel_id'  => $row['passivedcequipmentmodels_id'],
            'passivedcequipmenttype_id'   => $row['passivedcequipmenttypes_id'],
            'user_id_tech'                => $row['users_id_tech'],
            'group_id_tech'               => $row['groups_id_tech'],
            'is_template'                 => $row['is_template'],
            'template_name'               => $row['template_name'],
            'state_id'                    => $row['states_id'],
            'comment'                     => $row['comment'],
            'manufacturer_id'             => $row['manufacturers_id'],
            'updated_at'                  => $row['date_mod'],
            'created_at'                  => $row['date_creation'],
            'deleted_at'                  => self::convertIsDeleted($row['is_deleted']),
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
