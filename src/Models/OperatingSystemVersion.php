<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperatingSystemVersion extends Common
{
  protected $table = 'glpi_operatingsystemversions';
  protected $definition = '\App\Models\Definitions\OperatingSystemVersion';
  protected $titles = ['Version of the operating system', 'Versions of the operating systems'];
  protected $icon = 'edit';

}
