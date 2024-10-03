<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class SuppliersMigration extends AbstractMigration
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
    $item = $this->table('suppliers');

    if ($this->isMigratingUp())
    {
      $stmt = $pdo->query('SELECT * FROM glpi_suppliers');
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
            'suppliertype_id' => $row['suppliertypes_id'],
            'address'         => $row['address'],
            'postcode'        => $row['postcode'],
            'town'            => $row['town'],
            'state'           => $row['state'],
            'country'         => $row['country'],
            'website'         => $row['website'],
            'phonenumber'     => $row['phonenumber'],
            'is_deleted'      => $row['is_deleted'],
            'fax'             => $row['fax'],
            'email'           => $row['email'],
            'is_active'       => $row['is_active'],
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
