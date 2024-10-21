<?php

declare(strict_types=1);

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Phinx\Migration\AbstractMigration;
use Phinx\Migration\Manager\Environment;
use Phinx\Config\Config;
use App\v1\Controllers\Toolbox;

final class AuthssoMigration extends AbstractMigration
{
  public function change(): void
  {
    $table = $this->table('authssos');
    $table->addColumn('name', 'string', ['null' => true])
          ->addColumn('comment', 'text', ['null' => true])
          ->addColumn('created_at', 'timestamp', ['null' => true])
          ->addColumn('updated_at', 'timestamp', ['null' => true])
          ->addColumn('deleted_at', 'timestamp', ['null' => true])
          ->addColumn('is_active', 'boolean', ['null' => false, 'default' => false])
          ->addColumn('provider', 'string', ['null' => true])
          ->addColumn('callbackid', 'string', ['null' => true])
          ->addColumn('applicationid', 'string', ['null' => true])
          ->addColumn('applicationsecret', 'string', ['null' => true])
          ->addColumn('applicationpublic', 'string', ['null' => true])
          ->addColumn('directoryid', 'string', ['null' => true])
          ->addColumn('baseurl', 'string', ['null' => true])
          ->addColumn('realm', 'string', ['null' => true])
          ->addIndex(['is_active'])
          ->addIndex(['created_at'])
          ->addIndex(['updated_at'])
          ->addIndex(['deleted_at'])
          ->create();

    $table = $this->table('authssoscopes');
    $table->addColumn('name', 'string', ['null' => true])
          ->addColumn('authsso_id', 'integer', ['null' => false, 'default' => 0])
          ->addColumn('created_at', 'timestamp', ['null' => true])
          ->addColumn('updated_at', 'timestamp', ['null' => true])
          ->addColumn('deleted_at', 'timestamp', ['null' => true])
          ->create();

    $table = $this->table('authssooptions');
    $table->addColumn('authsso_id', 'integer', ['null' => false, 'default' => 0])
          ->addColumn('key', 'string', ['null' => true])
          ->addColumn('value', 'string', ['null' => true])
          ->addColumn('created_at', 'timestamp', ['null' => true])
          ->addColumn('updated_at', 'timestamp', ['null' => true])
          ->addColumn('deleted_at', 'timestamp', ['null' => true])
          ->create();
  }
}
