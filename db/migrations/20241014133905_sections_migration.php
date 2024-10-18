<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class SectionsMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table = $this->table('sections');
        $table->addColumn('name', 'string', ['null' => true])
              ->addColumn('created_at', 'timestamp', ['null' => true])
              ->addColumn('updated_at', 'timestamp', ['null' => true])
              ->addColumn('deleted_at', 'timestamp', ['null' => true])
              ->addColumn('order', 'integer', ['null' => false, 'default' => 0])
              ->addIndex(['name'])
              ->addIndex(['order'])
              ->addIndex(['created_at'])
              ->addIndex(['updated_at'])
              ->addIndex(['deleted_at'])
              ->create();


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
        $item = $this->table('sections');

        if ($this->isMigratingUp())
        {
            $nbRows = $pdo->query('SELECT count(*) FROM glpi_plugin_formcreator_sections')->fetchColumn();
            $nbLoops = ceil($nbRows / 5000);

            for ($i = 0; $i < $nbLoops; $i++) {
              $stmt = $pdo->query('SELECT * FROM glpi_plugin_formcreator_sections ORDER BY id LIMIT 5000 OFFSET ' . ($i * 5000));
              $rows = $stmt->fetchAll();
              foreach ($rows as $row)
              {
                $data = [
                  [
                    'id'         => $row['id'],
                    'name'       => $row['name'],
                    'order'      => $row['order'],
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
