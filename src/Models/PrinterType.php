<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrinterType extends Common
{
  protected $table = 'glpi_printertypes';
  protected $definition = '\App\Models\Definitions\PrinterType';
  protected $titles = ['Printer type', 'Printer types'];
  protected $icon = 'edit';

}
