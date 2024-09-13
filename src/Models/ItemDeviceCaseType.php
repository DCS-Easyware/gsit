<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemDeviceCaseType extends Common
{
  protected $table = 'glpi_devicecasetypes';
  protected $definition = '\App\Models\Definitions\ItemDeviceCaseType';
  protected $titles = ['Case type', 'Case types'];
  protected $icon = 'edit';

}
