<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComputerModel extends Common
{
  protected $table = 'glpi_computermodels';
  protected $definition = '\App\Models\Definitions\ComputerModel';
  protected $titles = ['Computer model', 'Computer models'];
  protected $icon = 'edit';

}
