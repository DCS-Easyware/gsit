<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FileSystem extends Common
{
  protected $table = 'glpi_filesystems';
  protected $definition = '\App\Models\Definitions\FileSystem';
  protected $titles = ['File system', 'File systems'];
  protected $icon = 'edit';

}
