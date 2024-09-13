<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PrinterModel extends Common
{
  protected $table = 'glpi_printermodels';
  protected $definition = '\App\Models\Definitions\PrinterModel';
  protected $titles = ['Printer model', 'Printer models'];
  protected $icon = 'edit';

}
