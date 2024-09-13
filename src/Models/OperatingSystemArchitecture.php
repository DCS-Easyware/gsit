<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OperatingSystemArchitecture extends Common
{
  protected $table = 'glpi_operatingsystemarchitectures';
  protected $definition = '\App\Models\Definitions\OperatingSystemArchitecture';
  protected $titles = ['Operating system architecture', 'Operating system architectures'];
  protected $icon = 'edit';

}
