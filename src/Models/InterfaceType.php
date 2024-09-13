<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InterfaceType extends Common
{
  protected $table = 'glpi_interfacetypes';
  protected $definition = '\App\Models\Definitions\InterfaceType';
  protected $titles = ['Interface type (Hard drive...)', 'Interface types (Hard drive...)'];
  protected $icon = 'edit';

}
