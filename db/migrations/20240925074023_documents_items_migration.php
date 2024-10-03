<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class DocumentsItemsMigration extends AbstractMigration
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
    $item = $this->table('document_item');

    if ($this->isMigratingUp())
    {
      $nbRows = $pdo->query('SELECT count(*) FROM glpi_documents_items')->fetchColumn();
      $nbLoops = ceil($nbRows / 15000);

      for ($i = 0; $i < $nbLoops; $i++) {
        $stmt = $pdo->query('SELECT * FROM glpi_documents_items ORDER BY id LIMIT 15000 OFFSET ' . ($i * 15000));

        $rows = $stmt->fetchAll();
        $data = [];
        foreach ($rows as $row)
        {
          $data[] = [
            'id'                => $row['id'],
            'document_id'       => $row['documents_id'],
            'item_id'           => $row['items_id'],
            'item_type'         => $row['itemtype'],
            'entity_id'         => $row['entities_id'],
            'is_recursive'      => $row['is_recursive'],
            'user_id'           => $row['users_id'],
            'timeline_position' => $row['timeline_position'],
            'date'              => $row['date'],
            'updated_at'        => $row['date_mod'],
            'created_at'        => $row['date_creation'],
          ];
        }
        $item->insert($data)
             ->saveData();
      }
    } else {
      // rollback
      $item->truncate();
    }
  }
}
