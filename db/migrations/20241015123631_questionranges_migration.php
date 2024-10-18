<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class QuestionrangesMigration extends AbstractMigration
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
        $table = $this->table('questions');
        $table->addColumn('range_min', 'string', ['null' => true])
            ->addColumn('range_max', 'string', ['null' => true])
            ->update();


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
        $item = $this->table('questions');

        if ($this->isMigratingUp())
        {
            $nbRows = $pdo->query('SELECT count(*) FROM glpi_plugin_formcreator_questionranges')->fetchColumn();
            $nbLoops = ceil($nbRows / 5000);

            for ($i = 0; $i < $nbLoops; $i++) {
                $stmt = $pdo->query('SELECT * FROM glpi_plugin_formcreator_questionranges ORDER BY id LIMIT 5000 OFFSET ' . ($i * 5000));

                $rows = $stmt->fetchAll();
                $data = [];
                foreach ($rows as $row)
                {
                    $builder = $this->getQueryBuilder('update');
                    $builder
                        ->update('questions')
                        ->set('range_min', $row['range_min'])
                        ->set('range_max', $row['range_max'])
                        ->where(['id' => $row['plugin_formcreator_questions_id']])
                        ->execute();
                }
            }
        }
    }
}
