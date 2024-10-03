<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class DocumentsMigration extends AbstractMigration
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
    $item = $this->table('documents');

    if ($this->isMigratingUp())
    {
      $nbRows = $pdo->query('SELECT count(*) FROM glpi_documents')->fetchColumn();
      $nbLoops = ceil($nbRows / 5000);

      for ($i = 0; $i < $nbLoops; $i++) {
        $stmt = $pdo->query('SELECT * FROM glpi_documents ORDER BY id LIMIT 5000 OFFSET ' . ($i * 5000));

        $rows = $stmt->fetchAll();
        $data = [];
        foreach ($rows as $row)
        {
          $data[] = [
            'id'                  => $row['id'],
            'name'                => $row['name'],
            'comment'             => $row['comment'],
            'entity_id'           => $row['entities_id'],
            'is_recursive'        => $row['is_recursive'],
            'filename'            => $row['filename'],
            'filepath'            => $row['filepath'],
            'documentcategory_id' => $row['documentcategories_id'],
            'mime'                => $row['mime'],
            'is_deleted'          => $row['is_deleted'],
            'link'                => $row['link'],
            'user_id'             => $row['users_id'],
            'ticket_id'           => $row['tickets_id'],
            'sha1sum'             => $row['sha1sum'],
            'is_blacklisted'      => $row['is_blacklisted'],
            'tag'                 => $row['tag'],
            'updated_at'          => $row['date_mod'],
            'created_at'          => $row['date_creation'],
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
