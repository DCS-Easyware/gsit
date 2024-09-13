<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierType extends Common
{
  protected $table = 'glpi_suppliertypes';
  protected $definition = '\App\Models\Definitions\SupplierType';
  protected $titles = ['Third party type', 'Third party types'];
  protected $icon = 'edit';

}
