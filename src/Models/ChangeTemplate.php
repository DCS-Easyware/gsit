<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChangeTemplate extends Common
{
  protected $table = 'glpi_changetemplates';
  protected $definition = '\App\Models\Definitions\ChangeTemplate';

}
