<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manufacturer extends Common
{
  protected $table = 'glpi_manufacturers';
  protected $definition = '\App\Models\Definitions\Manufacturer';
  protected $titles = ['Manufacturer', 'Manufacturers'];
  protected $icon = 'edit';

}
