<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperatingSystemEdition extends Common
{
  protected $table = 'glpi_operatingsystemeditions';
  protected $definition = '\App\Models\Definitions\OperatingSystemEdition';
  protected $titles = ['Edition', 'Editions'];
  protected $icon = 'edit';

}
